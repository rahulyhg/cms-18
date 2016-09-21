<?php

class InventoriesController extends FrontController {

    public $pluralTitle = 'Inventory';
    public $singleTitle = 'Inventory';
    public $cannotDelete = array();
    public $pageTitle = 'redbull-Inventory';

    public function actionCreate() {
        try {
            $model = new Inventory('create');
            $model->expiry_date = time();
            $model->bought_date = time();
            $model->status = 1;
            $model->warning = 0;
           
            
            if (isset($_POST['Inventory'])) {
               
                $model->attributes = $_POST['Inventory'];
                $expiry_date = explode('/', $model->expiry_date);
                $model->expiry_date = strtotime($expiry_date[2] . '/' . $expiry_date[1] . '/' . $expiry_date[0]);
                $bought_date = explode('/', $model->bought_date);
                $model->bought_date = strtotime($bought_date[2] . '/' . $bought_date[1] . '/' . $bought_date[0]);
                ;

                $model->created = time();
                //$model->stock_amount_remainder = $model->stock_amount_used-$model->stock_amount_bought;
                $decription = $model->file_description;
                $check = Inventory::model()->findAll('brand_name = :name and status = 1' , array('name' => $model->brand_name));
                $errors = false;
                if(count($check)>0) {
                    $errors = true;
                    $model->addError('brand_name', 'Brand Name "'.$model->brand_name.'" has already been taken.');
                }
                if ($errors == false && $model->save()) {
                    $model->saveFile('file', $decription);
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
            
            if (isset(Yii::app()->request->isPostRequest)) {
                // we only allow deletion via POST request

                if ($model = $this->loadModel($id)) {
                    if ($model->status == 1 || $model->status == 0) {
                        $model->status = -1;
                    } else {
                        $model->status = 1;
                    }

                    if ($model->save(false)) {
                        Yii::log("Delete record " . print_r($model->attributes, true), 'info');
                    }
                }

                return $this->redirect(array('index'));

                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            } else {
                $model = $this->loadModel($id);
                 if ($model->status == 1 || $model->status == 0) {
                        $model->status = -1;
                    } else {
                        $model->status = 1;
                    }

                    if ($model->save(false)) {
                        Yii::log("Delete record " . print_r($model->attributes, true), 'info');
                    }
                    
                    return $this->redirect(array('index'));
             
            }
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException($e);
        }
    }

    public function actionIndex($war = false) {


        try {
            $status = 1;
            if (isset($_GET['status'])) {
                $status = $_GET['status'];
            }
            $model = new Inventory('search');
            $model->unsetAttributes();  // clear any default values
            $show = 0;
            $patient = 0;
            if (isset($_GET['Inventory'])) {
                $model->attributes = $_GET['Inventory'];
                $show = 1;
                if (!empty($model->patient_name)) {
                    $patient = 1;
                }
            }
            $this->render('index', array(
                'model' => $model,
                'actions' => $this->listActionsCanAccess,
                'show' => $show,
                'status' => $status,
                'patient' => $patient,
                'war' => $war,
            ));
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException($e);
        }
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->scenario = 'update';

        $modelOld = clone $model;

        $fileInventory = InventoryFile::model()->findAll('inventory_id = :inventory', array(':inventory' => $model->id));
        if (isset($_POST['Inventory'])) {

            $model->attributes = $_POST['Inventory'];

            $expiry_date = explode('/', $model->expiry_date);
            $model->expiry_date = strtotime($expiry_date[2] . '/' . $expiry_date[1] . '/' . $expiry_date[0]);
            $bought_date = explode('/', $model->bought_date);
            $model->bought_date = strtotime($bought_date[2] . '/' . $bought_date[1] . '/' . $bought_date[0]);
            ;

            $model->updated = time();
            //$model->stock_amount_remainder = $model->stock_amount_used-$model->stock_amount_bought;
            // $model->old_stock = $modelOld->packing;
            $listKey = array();

            foreach ($fileInventory as $key => $file) {
                if (!empty($model->file_id) && in_array($file->id, $model->file_id)) {
                    $file->description = $model->file_description[$key];
                    $listKey[] = $key;
                    $file->save();
                } else {
                    $listKey[] = $key;
                    $path = Yii::getPathOfAlias("webroot") . '/upload/files/inventory/' . $file->file;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                    $file->delete();
                }
            }
            $decription = array();

            if (!empty($model->file_description)) {
                foreach ($model->file_description as $key => $value) {
                    if (!in_array($key, $listKey)) {
                        $decription[] = $value;
                    }
                }
            }


//           if($model->packing - $modelOld->packing > 0) {
//             $model->packing_total+= $model->packing - $modelOld->packing;
//           }

            if ($model->validate()) {
                $model->save();
                $model->saveFile('file', $decription);
                $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been updated');
                $this->redirect(array('view', 'id' => $model->id));
            } else
                $this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be updated for some reasons');
        }
        //$model->beforeRender();

        $this->render('update', array(
            'model' => $model,
            'actions' => $this->listActionsCanAccess,
            'title_name' => $model->id,
            'fileInventory' => $fileInventory
        ));
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
        $deleteItems = $_POST['inventory-grid_c0'];
        $shouldDelete = array_diff($deleteItems, $this->cannotDetele);

        if (!empty($shouldDelete)) {
            Inventory::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
            $this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted');
        } else
            $this->setNotifyMessage(NotificationType::Error, 'No records was deleted');

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function loadModel($id) {
        //need this define for inherit model case. Form will render parent model name in control if we don't have this line
        $initMode = new Inventory();
        $model = $initMode->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionList() {

        $response = array(
            'code' => 503,
            'data' => '',
        );

        $SQL = "SELECT `brand_name` as `name` FROM " . Inventory::model()->tableName() . " where status = 1";
        $command = Yii::app()->db->createCommand($SQL);
        $data = $command->queryAll();
        $response['data'] = $data;
        $response['code'] = 200;
        echo CJSON::encode($response);
        Yii::app()->end();
    }

    public function actionListPatient() {

        $response = array(
            'code' => 503,
            'data' => '',
        );

        $SQL = "SELECT `name` as `name` FROM " . Patient::model()->tableName() . "";
        $command = Yii::app()->db->createCommand($SQL);
        $data = $command->queryAll();
        $response['data'] = $data;
        $response['code'] = 200;
        echo CJSON::encode($response);
        Yii::app()->end();
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

    public function actionCheckDate() {
        $data = $_GET['Inventory'];

        $code = 200;
        $errors = '';
        $code_type = '';
        if ($data['date_type'] == 1) {

            $date_to = $data['to_date'];
            $date_from = $data['from_date'];

            if (empty($date_from) && empty($date_to)) {

                $code = 500;
                $code_type = 'required';
                $errors = '"From date" cannot be blank.';
                echo json_encode(array('code' => $code, 'errors' => $errors, 'code_type' => $code_type));
                Yii::app()->end();
            }

            if (empty($date_from)) {

                $code = 500;
                $code_type = 'fromdate';
                $errors = '"From date" cannot be blank.';
                echo json_encode(array('code' => $code, 'errors' => $errors, 'code_type' => $code_type));
                Yii::app()->end();
            }
            if (empty($date_to)) {
                $code = 500;
                $code_type = 'todate';
                $errors = '"To date" cannot be blank.';
                echo json_encode(array('code' => $code, 'errors' => $errors, 'code_type' => $code_type));
                Yii::app()->end();
            }
            if (strtotime($date_from) > strtotime($date_to)) {
                $code = 500;
                $code_type = 'todate';
                $errors = '"To date" must be greater than or qual "From date".';
                echo json_encode(array('code' => $code, 'errors' => $errors, 'code_type' => $code_type));
                Yii::app()->end();
            }
        }

        echo json_encode(array('code' => $code, 'errors' => $errors, 'code_type' => $code_type));
        Yii::app()->end();
    }

}
