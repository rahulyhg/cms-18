<?php

class PropertysearchsController extends AdminController {

    public $pluralTitle = 'Property search';
    public $singleTitle = 'Property search';
    public $cannotDetele = array();
    public $export;

    public function setExport($model) {
        $this->export = $model;
    }

    public function getExport() {
        return $this->export;
    }

    public function actionCreate() {
        try {
            $model = new Propertysearch('create');
            if (isset($_POST['Propertysearch'])) {
                $model->attributes = $_POST['Propertysearch'];
                if ($model->save()) {
                    $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been created');
                    $this->redirect(array('view', 'id' => $model->id));
                }
                else
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

    public function actionExport() {

        if (!empty(Yii::app()->session['export_search'])) {
            $this->ExportToFileExcel(Yii::app()->session['export_search']);
        }
        Yii::app()->session['export_search'] = null;
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public static function exportToExcel($objPHPExcel, $activeSheet, $sheetName, $columns, $data, $headerRowIndex) {

        $objPHPExcel->setActiveSheetIndex($activeSheet);
        $objPHPExcel->getActiveSheet()->setTitle($sheetName);

        $i = 1;
        $startCol = '';
        $endCol = '';
        //build excel sheet header
        foreach ($columns as $column) {
            
            $column = (object) $column;
            if ($i == 1)
                $startCol = $column->anphalbe;

            if ($i == count($columns))
                $endCol = $column->anphalbe;

            $objPHPExcel->getActiveSheet()->setCellValue($column->anphalbe . $headerRowIndex, $column->name, true);
            $i++;
        }
        
            
        //build data
        $index = $headerRowIndex;
        $sn = 1;
        foreach ($data as $item) {
            if (!empty($item)) {
                $index++;

                $item = (object) $item;
                
                //                $full_name = $model->first_name.' '.$model->last_name;
                foreach ($columns as $column) {
                    $column = (object) $column;
                    $colName = $column->attr_name;
                    if (strtoupper($column->anphalbe) == 'A')
                        $objPHPExcel->getActiveSheet()->setCellValue($column->anphalbe . $index, $sn, true);
                    else
                    {
                       
                            if($colName=='type_id')
                            {
                                $model= Propertytype::model()->find('id='.$item->$colName.'');
                                if(!empty($model))
                                $objPHPExcel->getActiveSheet()->setCellValue($column->anphalbe . $index, $model->property_type, true);
                                
                                
                                
                            }
                            else if ($colName=='property_id') {
                                $model= Properties::model()->find('id='.$item->$colName.'');
                                if(!empty($model))
                                $objPHPExcel->getActiveSheet()->setCellValue($column->anphalbe . $index, $model->title, true);
                                else
                                {
                                          $objPHPExcel->getActiveSheet()->setCellValue($column->anphalbe . $index, 'General', true);
  
                                }
                                
                                
                            }
                            else if($colName=='tenure_id')
                            {
                                $model= Tenures::model()->find('id='.$item->$colName.'');
                                if(!empty($model))
                                $objPHPExcel->getActiveSheet()->setCellValue($column->anphalbe . $index, $model->name, true);
                              
                                
                                
                            }
                             else if($colName=='ready')
                            {
                               
                                if($item->$colName==1)
                                $objPHPExcel->getActiveSheet()->setCellValue($column->anphalbe . $index, 'Ready', true);
                            else {
                                                                $objPHPExcel->getActiveSheet()->setCellValue($column->anphalbe . $index, 'BUC', true);

                            }
                                
                                
                            }
                            else if ($colName=='property_id') {
                                $model= Properties::model()->find('id='.$item->$colName.'');
                                if(!empty($model))
                                $objPHPExcel->getActiveSheet()->setCellValue($column->anphalbe . $index, $model->title, true);
                            }
                            else {
                                $objPHPExcel->getActiveSheet()->setCellValue($column->anphalbe . $index, $item->$colName, true);
                            }
                            
                     
                       
                       
                    }
                    $objPHPExcel->getActiveSheet()->getStyle($column->anphalbe . $index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $objPHPExcel->getActiveSheet()->getColumnDimension($column->anphalbe)->setAutoSize(true);
                }
            }
            
            $sn++;
        }
 
        $objPHPExcel->getActiveSheet()->getStyle($startCol . $headerRowIndex . ':' . $endCol . $headerRowIndex)->getFont()->setSize(13)->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle($startCol . $headerRowIndex . ':' . $endCol . $headerRowIndex)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle($startCol . $headerRowIndex . ':' . $endCol . $headerRowIndex)->getFill()->getStartColor()->setRGB('DBEAF9');
        $objPHPExcel->getActiveSheet()->getStyle($startCol . $headerRowIndex . ':' . $endCol . $headerRowIndex)->getFont()->getColor()->setRGB('000000');
        //$objPHPExcel->getActiveSheet()->getStyle($startCol . $headerRowIndex . ':' . $endCol . $headerRowIndex)->applyFromArray($styleArray2);
        return $objPHPExcel;
    }

    public function ExportToFileExcel($model = null) {

        $list = null;
        if (empty($model)) {
            $list = Propertysearch::model()->findAll();
        } else {

            $list = $model->data;
        }
        Yii::import('application.extensions.phpexcel.Classes.PHPExcel');
        $objPHPExcel = new PHPExcel();
        // Set properties
        $objPHPExcel->getProperties()->setCreator("VerzDesign")
                ->setLastModifiedBy("Verzdesign.com")
                ->setTitle('Export Current List')
                ->setSubject("Office 2007 XLSX Document")
                ->setDescription("Members")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Members");
        for ($j = 0; $j <= 2; $j++) {
            $objPHPExcel->createSheet($j);
        }

        

        $sheet1Columns = array(
            array('anphalbe' => 'A', 'name' => 'S/N', 'attr_name' => 's_n'),
            array('anphalbe' => 'B', 'name' => 'Name', 'attr_name' => 'name'),
            array('anphalbe' => 'C', 'name' => 'Type', 'attr_name' => 'type_id'),
            array('anphalbe' => 'D', 'name' => 'Property', 'attr_name' => 'property_id'),
            array('anphalbe' => 'E', 'name' => 'Location', 'attr_name' => 'location'),
            array('anphalbe' => 'F', 'name' => 'Min Bedroom', 'attr_name' => 'min_bedroom'),
            array('anphalbe' => 'G', 'name' => 'Max Bedroom', 'attr_name' => 'max_bedroom'),
            array('anphalbe' => 'H', 'name' => 'Mobile', 'attr_name' => 'mobile'),
            array('anphalbe' => 'I', 'name' => 'Email', 'attr_name' => 'email'),
            array('anphalbe' => 'J', 'name' => 'Budget', 'attr_name' => 'budget'),
            array('anphalbe' => 'K', 'name' => 'Minimun Size', 'attr_name' => 'minimun_size'),
            array('anphalbe' => 'L', 'name' => 'Referred View', 'attr_name' => 'referred_view'),
            array('anphalbe' => 'M', 'name' => 'Ready', 'attr_name' => 'ready'),
            array('anphalbe' => 'N', 'name' => 'Tenure', 'attr_name' => 'tenure_id'),
            array('anphalbe' => 'O', 'name' => 'Created Date', 'attr_name' => 'created_date'),
            
        );

        $objPHPExcel = self::exportToExcel($objPHPExcel, 0, 'Attributes', $sheet1Columns, $list, 3);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        for ($level = ob_get_level(); $level > 0; --$level) {
            @ob_end_clean();
        }
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-type: ' . 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . 'precicon_products' . '.' . 'xlsx' . '"');

        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        Yii::app()->end();
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

            $model = new Propertysearch('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Propertysearch']))
                $model->attributes = $_GET['Propertysearch'];

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
        if (isset($_POST['Propertysearch'])) {
            $model->attributes = $_POST['Propertysearch'];
            if ($model->save()) {
                $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been updated');
                $this->redirect(array('view', 'id' => $model->id));
            }
            else
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
        $deleteItems = $_POST['propertysearch-grid_c0'];
        $shouldDelete = array_diff($deleteItems, $this->cannotDetele);

        if (!empty($shouldDelete)) {
            Propertysearch::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
            $this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted');
        }
        else
            $this->setNotifyMessage(NotificationType::Error, 'No records was deleted');

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function loadModel($id) {
        //need this define for inherit model case. Form will render parent model name in control if we don't have this line
        $initMode = new Propertysearch();
        $model = $initMode->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}