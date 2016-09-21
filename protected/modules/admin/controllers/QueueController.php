<?php

class QueueController extends AdminController {

    public $pluralTitle = 'Queue';
    public $singleTitle = 'Queue';
    public $cannotDelete = array();

    public function actionCreate() {
        try {
            $model = new Queue('create');
            if (isset($_POST['Queue'])) {
                $model->attributes = $_POST['Queue'];
                if ($model->save()) {
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

    public function actionIndex() {
        try {
            $model = new Queue('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Queue']))
                $model->attributes = $_GET['Queue'];

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
        if (isset($_POST['Queue'])) {
            $model->attributes = $_POST['Queue'];
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
        $deleteItems = $_POST['queue-grid_c0'];
        $shouldDelete = array_diff($deleteItems, $this->cannotDetele);

        if (!empty($shouldDelete)) {
            Queue::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
            $this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted');
        } else
            $this->setNotifyMessage(NotificationType::Error, 'No records was deleted');

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function loadModel($id) {
        //need this define for inherit model case. Form will render parent model name in control if we don't have this line
        $initMode = new Queue();
        $model = $initMode->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    
    public function actionExport() {
        $model = new Queue('search');
        $model->unsetAttributes();

        if (isset(Yii::app()->session['queue_criteria'])) {
            $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel.Classes');
            include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
            $objPHPExcel = new PHPExcel();
            //set properties
            $objPHPExcel->getProperties()->setCreator("Jason")
                    ->setLastModifiedBy("Jason")
                    ->setTitle("Export Patients")
                    ->setSubject("Office 2007 XLSX Document")
                    ->setDescription("Export Patients")
                    ->setKeywords("office 2007 openxml php")
                    ->setCategory("Export Patients");

            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'S/N', true);
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Time In', true);
            $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Tme Out', true);
            $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Patient Name', true);
            $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Seen', true);
            $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Dispense', true);
            $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Bill', true);
            $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Paid', true);
            $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Doctor', true);
            $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Created Date', true);
            $objPHPExcel->getActiveSheet()->setCellValue('K1', 'Follow Up', true);

            $objPHPExcel->getActiveSheet()->getStyle("A1:I1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("A1:I1")->getFont()
                            ->setBold(true);
            
            $i = 1;
            $dataAll = $model->search()->data;
            foreach ($dataAll as $item) {
                $i++;
              
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $i, true);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $item->time_in, true);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $item->time_out, true);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $item->patient_name, true);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $item->seen == 1 ? "Yes" : "No", true);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $item->dispense == 1 ? "Yes" : "No", true);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $item->bill, true);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $item->paid, true);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $item->doctor ? $item->doctor->full_name : "", true);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $item->created_date, true);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $item->follow_up, true);
            }
            // $objPHPExcel->getActiveSheet()->getStyle("A1:H$i")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(18);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);

            $objPHPExcel->getActiveSheet()->getColumnDimension()->setAutoSize(true); //Scott, set column 
            $objPHPExcel->getActiveSheet()->getStyle("A1:K1")->getFont()->setSize(13)->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("A1:K1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyle("A1:K1")->getFill()->getStartColor()->setRGB('DBEAF9');
            $objPHPExcel->getActiveSheet()->getStyle("A1:K1")->getFont()->getColor()->setRGB('000000');

            $objPHPExcel->getActiveSheet()->getStyle("B1:K$i")
            ->getAlignment()->setWrapText(true);
            
            $objPHPExcel->getActiveSheet()->getStyle("A1:K$i")
                    ->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);        

            $objPHPExcel->getActiveSheet()->getStyle("A2:K$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);       

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Patients_' . time() . '.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            unset(Yii::app()->session['errorRows']);
            Yii::app()->end();
        } else {
            $this->redirect(array('index'));
        }
    }

}
