<?php

class ServiceListController extends FrontController {

    public $pluralTitle = 'Price List';
    public $singleTitle = 'Price List';
    public $cannotDetele = array();

    public function actionCreate() {
        try {
            $this->pageTitle = 'Create Price List - ' . Yii::app()->params['defaultPageTitle'];
            $model = new PriceList('create');
            if (isset($_POST['PriceList'])) {
                $model->attributes = $_POST['PriceList'];
                $check = PriceList::model()->findAll('name = :name and status = 1' , array('name' => $model->name));
                $errors = false;
                if(count($check)>0) {
                    $errors = true;
                    $model->addError('name', 'Name "'.$model->name.'" has already been taken.');
                }
                if ($errors == false && $model->save()) {
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
        // try {

        if (Yii::app()->request->isPostRequest) {
            if ($model = $this->loadModel($id)) {
                if ($model->status == -1) {
                    $model->status = 1;
                } else {
                    $model->status = -1;
                }
                if ($model->save(false))
                    Yii::log("Delete record " . print_r($model->attributes, true), 'info');
            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else {
            Yii::log("Invalid request. Please do not repeat this request again.");
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
//        } catch (Exception $e) {
//            Yii::log("Exception " . print_r($e, true), 'error');
//            throw new CHttpException($e);
//        }
    }

    public function actionIndex() {
        try {
            $this->pageTitle = 'Price List - ' . Yii::app()->params['defaultPageTitle'];
            $status = 1;
            if (isset($_GET['status'])) {
                $status = $_GET['status'];
            }
            $model = new PriceList('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['PriceList']))
                $model->attributes = $_GET['PriceList'];

            $this->render('index', array(
                'model' => $model,
                'actions' => $this->listActionsCanAccess,
                'status' => $status
            ));
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException($e);
        }
    }

    public function actionUpdate($id) {
        $this->pageTitle = 'Update Price List - ' . Yii::app()->params['defaultPageTitle'];
        $model = $this->loadModel($id);
        if (isset($_POST['PriceList'])) {
            $model->attributes = $_POST['PriceList'];
            if ($model->save()) {
                $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been updated');
                $this->redirect(array('view', 'id' => $model->id));
            } else
                $this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be updated for some reasons');
        }
        //$model->beforeRender();
        $this->render('update', array(
            'model' => $model,
            'actions' => $this->listActionsCanAccess,
            'title_name' => $model->name));
    }

    public function actionView($id) {
        try {
            $this->pageTitle = 'View Price List - ' . Yii::app()->params['defaultPageTitle'];
            $model = $this->loadModel($id);
            $this->render('view', array(
                'model' => $model,
                'actions' => $this->listActionsCanAccess,
                'title_name' => $model->name));
        } catch (Exception $exc) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    /*
     * Bulk delete
     * If you don't want to delete some specified record please configure it in global $cannotDetele variable
     */

    public function actionDeleteAll() {
        $deleteItems = $_POST['product-grid_c0'];
        $shouldDelete = array_diff($deleteItems, $this->cannotDetele);

        if (!empty($shouldDelete)) {
            PriceList::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
            $this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted');
        } else
            $this->setNotifyMessage(NotificationType::Error, 'No records was deleted');

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function actionStatus($id) {
        if (Yii::app()->request->isPostRequest) {
            if ($model = $this->loadModel($id)) {
                if ($model->status == 0) {
                    $model->status = 1;
                } else {
                    $model->status = 0;
                }

                if ($model->save(false))
                    Yii::log("Delete record " . print_r($model->attributes, true), 'info');
            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else {
            Yii::log("Invalid request. Please do not repeat this request again.");
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /*
     * Remove upload image 
     * Only files are deleted not folder. Run in ajax mode. Can modify in custom.js admin theme
     */

    public function loadModel($id) {
        //need this define for inherit model case. Form will render parent model name in control if we don't have this line
        $initMode = new PriceList();
        $model = $initMode->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
