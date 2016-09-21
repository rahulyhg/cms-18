<?php

class UsersController extends AdminController {

    public $pluralTitle = 'Doctors';
    public $singleTitle = 'Doctor';
    public $cannotDetele = array();

    public function actionCreate() {
        try {
            $model = new Users('createDoctor');
            if (isset($_POST['Users'])) {
                $model->attributes = $_POST['Users'];
                $model->role_id = ROLE_MEMBER;
                $model->application_id = 2;
                if ($model->save()) {
                    $model->password_hash = md5($model->temp_password);
                    $doctor = new Doctor;
                    $doctor->name = $model->full_name;
                    $doctor->user_id = $model->id;
                    $doctor->salutation = $model->salutation;
                    $doctor->save();
                    $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been created');
                    $this->redirect(array('view', 'id' => $model->id));
                } else
                    $this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be created for some reasons');
            }
            $this->render('create', array(
                'model' => $model,
                'actions' => $this->listActionsCanAccess,
            ));
        } catch (exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException($e);
        }
    }

    public function actionDelete($id) {
        try {
            if (Yii::app()->request->isPostRequest) {
                // we only allow deletion via POST request
                if (!in_array($id, $this->cannotDetele)) {
                    if ($model = $this->loadModel($id)) {
                        $this->setNotifyMessage(NotificationType::Success, 'Your password has been changed successfully');
                        $userId = $model->id;
                        if ($model->delete())
                            $doctor = Doctor::model()->find("user_id = $userId");
                            if ($doctor)
                                $doctor->delete();
                            Yii::log("Delete record " . print_r($model->attributes, true), 'info');
                    }

                    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                    if (!isset($_GET['ajax']))
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
                }
            } else {
                Yii::log("Invalid request. Please do not repeat this request again.");
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            }
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException($e);
        }
    }

    public function actionIndex() {
        try {
            $model = new Users('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Users']))
                $model->attributes = $_GET['Users'];
            $model->role_id = ROLE_MEMBER;
            $this->render('index', array(
                'model' => $model, 'actions' => $this->listActionsCanAccess,
            ));
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException($e);
        }
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->scenario = "updateDoctor";
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $model->password_hash = md5($model->temp_password);
            if ($model->save()) {
                $doctor = Doctor::model()->find("user_id = $model->id");
                if ($doctor)
                {
                    $doctor->name = $model->full_name;
                    $doctor->salutation = $model->salutation;
                    $doctor->update(array('name', 'salutation'));
                }
                
                $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been updated');
                $this->redirect(array('view', 'id' => $model->id));
            } else
                $this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be updated for some reasons');
        }
        //$model->beforeRender();
        $this->render('update', array(
            'model' => $model,
            'actions' => $this->listActionsCanAccess,
            'title_name' => $model->id));
    }

    public function actionView($id) {
        try {
            $model = $this->loadModel($id);
            $this->render('view', array(
                'model' => $model,
                'actions' => $this->listActionsCanAccess,
                'title_name' => $model->id));
        } catch (Exception $exc) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    /*
     * Bulk delete
     * If you don't want to delete some specified record please configure it in global $cannotDetele variable
     */

    public function actionDeleteAll() {
        $deleteItems = $_POST['users-grid_c0'];
        $shouldDelete = array_diff($deleteItems, $this->cannotDetele);

        if (!empty($shouldDelete)) {
            Doctor::model()->deleteAll('user_id in (' . implode(',', $shouldDelete) . ')');
            Users::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
            $this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted');
        } else
            $this->setNotifyMessage(NotificationType::Error, 'No records was deleted');

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function loadModel($id) {
        //need this define for inherit model case. Form will render parent model name in control if we don't have this line
        $initMode = new Users();
        $model = $initMode->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
