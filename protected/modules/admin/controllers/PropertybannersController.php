<?php

class PropertybannersController extends AdminController {

    public $pluralTitle = 'Property Banners';
    public $singleTitle = 'Property Banner';
    public $cannotDetele = array();

    public function actionCreate() {
        try {

            $model = new PropertyBanners('create');
            if (isset($_POST['PropertyBanners'])) {
                $model->attributes = $_POST['PropertyBanners'];
                $model->property_id = $property_id;
                if ($model->save()) {
                    $model->saveImage('large_image');
                    $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been created');
                    $this->redirect(array('view', 'id' => $model->id));
                } else
                    $this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be created for some reasons');
            }
            $this->render('create', array(
                'model' => $model,
                'property_id' => $property_id,
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
                        $model->removeImage(array('large_image'), true);
                        if ($model->delete())
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

    public function actionIndex($property_id) {
        try {

            $this->layout = '/layouts/ajaxpupup';
            $model = new PropertyBanners('create');
            if (isset($_POST['PropertyBanners'])) {
                $model->attributes = $_POST['PropertyBanners'];
                $model->property_id = $property_id;

                if ($model->save()) {
                    $model->saveImage('large_image');
                    $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been created');
                    $model->unsetAttributes();
                    if (!isset($_GET['ajax']))
                        $this->redirect(array('index', 'property_id' => $property_id));
                } else
                    $this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be created for some reasons');
            }


            $modelPropertyBanners = new PropertyBanners('search');

            $modelPropertyBanners->unsetAttributes();  // clear any default values
            if (isset($_GET['PropertyBanners']))
                $modelPropertyBanners->attributes = $_GET['PropertyBanners'];
            $modelPropertyBanners->property_id = $property_id;
            $this->render('index', array(
                'model' => $model,
                'propertyBanners' => $modelPropertyBanners,
                'property_id' => $property_id,
                'actions' => $this->listActionsCanAccess,
            ));
        } catch (exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException($e);
        }
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        if (isset($_POST['PropertyBanners'])) {
            $model->attributes = $_POST['PropertyBanners'];
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
        $deleteItems = $_POST['property-banners-grid_c0'];
        $shouldDelete = array_diff($deleteItems, $this->cannotDetele);

        if (!empty($shouldDelete)) {
            $deleteFile = PropertyBanners::model()->findAll('property_id in (' . implode(',', $shouldDelete) . ')');
            foreach ($deleteFile as $item) {
                $item->removeFile(array('large_image'), true);
            }
            PropertyBanners::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
            $this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted');
        } else
            $this->setNotifyMessage(NotificationType::Error, 'No records was deleted');

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function loadModel($id) {
        //need this define for inherit model case. Form will render parent model name in control if we don't have this line
        $initMode = new PropertyBanners();
        $model = $initMode->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionPropertyBanner($property_id) {
        try {

            $this->layout = '/layouts/ajaxpupup';
            $model = new PropertyBanners('create');
            if (isset($_POST['PropertyBanners'])) {
                $model->attributes = $_POST['PropertyBanners'];
                $model->property_id = $property_id;

                if ($model->save()) {
                    $model->saveImage('large_image');
                    $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been created');
                    $model->unsetAttributes();
                    if (!isset($_GET['ajax']))
                        $this->redirect(array('brochure', 'property_id' => $property_id));
                } else
                    $this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be created for some reasons');
            }


            $modelPropertyBanners = new PropertyBanners('search');

            $modelPropertyBanners->unsetAttributes();  // clear any default values
            if (isset($_GET['PropertyBanners']))
                $modelPropertyBanners->attributes = $_GET['PropertyBanners'];
            $modelPropertyBanners->property_id = $property_id;
            $this->render('propertybanners', array(
                'model' => $model,
                'propertyBanners' => $modelPropertyBanners,
                'property_id' => $property_id,
                'actions' => $this->listActionsCanAccess,
            ));
        } catch (exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException($e);
        }
    }

}
