<?php
/**
 * Author: Jason Hai
 * Email: pmhai90@gmail.com
 * Des: To export all options
 */

class ExportController extends FrontController {

    public $exportColumns = array(
        'DoctorName' => 'checked="checked"',
        'name' => 'checked="checked"',
        'nric' => 'checked="checked"',
        'contact' => 'checked="checked"',
        'Date' => 'checked="checked"',
        'Time' => 'checked="checked"',
        'VisitReason' => '',
        'comments' => '',
        'turnup' => 'checked="checked"',
    );
    
    /**
     * [$listExportColumnsChecked description]
     * @var array
     * <Jason Hai>
     * <pmhai90@gmail.com>
     */
    public $listExportColumnsChecked = array(
        'doctor_name' => 'checked="checked"',
        'name' => 'checked="checked"',
        'identity' => 'checked="checked"',
        'contact_no' => 'checked="checked"',
        'speaks' => 'checked="checked"',
        'dob' => 'checked="checked"',
        'gender' => 'checked="checked"',
        'address' => 'checked="checked"',
        'important_comment_to_notes' => 'checked="checked"',
    );

    public function behaviors()
    {
        return array(
            'eexcelview' => array(
                'class' => 'ext.eexcelView.EExcelBehavior',
            ),
        );
    }

    public function actionAppointment()
    {
        $model = new ExportAppointment('search');
        $c = new CDbCriteria;
        $c->order = 'is_default desc, name';
        $doctorList = Doctor::model()->findAll($c);
        $startDate = '';
        $endDate = '';
        $modelPreview = new Appointment();
        $doctorPreview = new Doctor();
        $columns = '';
        if (isset($_POST['ExportAppointment']['doctor_id'])) {
            $doctor_id = $_POST['ExportAppointment']['doctor_id'];
            $startDate = HDateTime::formatDate($_POST['ExportAppointment']['startDate']);
            $endDate = HDateTime::formatDate($_POST['ExportAppointment']['endDate']);
            $time = $_POST['ExportAppointment']['time'];

            $model->doctor_id = $doctor_id;
            $model->startDate = HDateTime::format($startDate, 'd-m-Y');
            $model->endDate = HDateTime::format($endDate, 'd-m-Y');
            $model->time = $time;
            $columns = $_POST['export-column'];
            foreach($columns as $col) {
                if (!empty($col)) {
                    $this->exportColumns[$col] = 'checked="checked"';
                }
                else {
                    $this->exportColumns[$col] = '';
                }
            }
            $modelPreview = Appointment::searchAppointmentForPrint($doctor_id, $startDate, $endDate, $time);
            $doctorPreview = Doctor::model()->findByPk($doctor_id);
        }


        $this->render('appointment', array(
            'model' => $model,
            'modelPreview' => $modelPreview,
            'doctorList' => $doctorList,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'doctorPreview' => $doctorPreview,
            'columns' => $columns,
        ));
    }
    
    public function actionExportAppointment() {
        $model = new ExportAppointment('search');
        if (isset($_POST['ExportAppointment']['doctor_id'])) {
            $doctor_id = $_POST['ExportAppointment']['doctor_id'];
            $startDate = HDateTime::formatDate($_POST['ExportAppointment']['startDate']);
            $endDate = HDateTime::formatDate($_POST['ExportAppointment']['endDate']);
            $time = $_POST['ExportAppointment']['time'];
            $print_type = $_POST['print-type'];
            $dataset = $model->searchAppointment($doctor_id,$startDate,$endDate,$time,$print_type);
            $filename = 'Appointments-' . date("Y-m-d-H-i-s");
            $columns = $_POST['export-column'];
            if ($_POST['exportType'] == 'excel') $this->exportExcel($dataset, $columns, $filename);
            else $this->exportWord($dataset, $columns, $filename);
       }
    }

    protected function exportExcel($dataset, $columns, $filename = "Appointments")
    {
        $this->toExcel($dataset, $columns, $filename, array(
            'creator' => 'RedBullHQ',
                ), 'Excel2007');
        $this->redirect(Yii::app()->baseUrl . "/upload/temp/" . $filename . '.xlsx');
        // return Yii::app()->baseUrl . "/upload/temp/" . $filename . ".xlsx";
    }

    protected function exportWord($dataset, $columns, $filename = "Appointments")
    {
        $filename .= '.docx';
        $PHPWord = Yii::app()->CPHPWord;
        $PHPWord->addTable($dataset, $columns, $filename, YiiBase::getPathOfAlias("webroot") . "/upload/doc65Template.docx");
        $this->redirect(Yii::app()->baseUrl . "/upload/temp/" . $filename);
        // return Yii::app()->baseUrl . "/upload/temp/" . $filename;
    }
    
    
    /**
     * [actionExportPatientByVisit description]
     * @return [type] [description]
     * <Jason Hai>
     * <pmhai90@gmail.com>
     */
    public function actionExportPatientByVisit(){
        $model = new ExportForm('export_patient_by_visit');
        $model->from_date = Date('d/m/Y');
        $model->to_date = Date('d/m/Y');
        if (isset($_POST['ExportForm'])) {
            $columns = $_POST['export-column'];
            foreach ($this->listExportColumnsChecked as $key => $value) {
                $pos = strpos(implode(',', array_keys($columns)), $key);
                if ($pos === false) {
                    $this->listExportColumnsChecked[$key] = '';
                }
                else{
                    $this->listExportColumnsChecked[$key] = 'checked="checked"';
                }
            }

            $model->attributes = $_POST['ExportForm'];
            $model->validate();
            if (!$model->hasErrors()) {
                $list = Patient::model()->getListByVisit($_POST['ExportForm']);
                if ($_POST['export_type'] == 'excel') {
                    $this->toolExportExcel($list, $columns);
                }
                else{
                    $title = 'Export Patient List - By visit date from to';
                    $this->toolExportWord($list, $columns, $title);   
                }
            }
        }
        $this->render('export_patient_by_visit', compact('model'));
    }

    public function processExport($type, $list, $columns, $title = null){
        if ($type == 'excel') {
            $this->toolExportExcel($list, $columns);
        }
        else{
            $this->toolExportWord($list, $columns, $title);   
        }
    }

    public function actionExportPatientByAllentry(){
        $model = new ExportForm();
        $model->registration_date = Date('d/m/Y');
        $title = 'Export Patient List - All Entry';

        if (isset($_POST['export_type'])) {
            $columns = $_POST['export-column'];
            foreach ($this->listExportColumnsChecked as $key => $value) {
                $pos = strpos(implode(',', array_keys($columns)), $key);
                if ($pos === false) {
                    $this->listExportColumnsChecked[$key] = '';
                }
                else{
                    $this->listExportColumnsChecked[$key] = 'checked="checked"';
                }
            }

            $model->validate();
            if (!$model->hasErrors()) {
                $list = Patient::model()->getListByAllentry();
                $this->processExport($_POST['export_type'], $list, $columns, $title);
            }
        }
        $this->render('export_patient_by_allentry', compact('model', 'title'));
    }

    public function actionExportPatientByAlphabet(){
        $model = new ExportForm('export_patient_by_alphabet');
        $model->registration_date = Date('d/m/Y');
        $title = 'Export Patient List - Name starting with alphabet to alphabet';

        if (isset($_POST['ExportForm'])) {
            $columns = $_POST['export-column'];
            foreach ($this->listExportColumnsChecked as $key => $value) {
                $pos = strpos(implode(',', array_keys($columns)), $key);
                if ($pos === false) {
                    $this->listExportColumnsChecked[$key] = '';
                }
                else{
                    $this->listExportColumnsChecked[$key] = 'checked="checked"';
                }
            }

            $model->attributes = $_POST['ExportForm'];
            $model->validate();
            if (!$model->hasErrors()) {
                $list = Patient::model()->getListByAlphabet($_POST['ExportForm']);
                $this->processExport($_POST['export_type'], $list, $columns, $title);
            }
        }
        $this->render('export_patient_by_alphabet', compact('model', 'title'));
    }

    public function actionExportPatientByChecked(){
        $model = new ExportForm('export_patient_by_checked');
        $title = 'Export Patient List - By Checked';
        $dataProvider = new Patient();
        if (isset($_POST['patient-grid_c0'])) {
            $columns = $_POST['export-column'];
            foreach ($this->listExportColumnsChecked as $key => $value) {
                $pos = strpos(implode(',', array_keys($columns)), $key);
                if ($pos === false) {
                    $this->listExportColumnsChecked[$key] = '';
                }
                else{
                    $this->listExportColumnsChecked[$key] = 'checked="checked"';
                }
            }

            $model->validate();
            if (!$model->hasErrors()) {
                $post = implode(',', $_POST['patient-grid_c0']);
                $list = Patient::model()->getListByChecked($post);
                $this->processExport($_POST['export_type'], $list, $columns, $title);
            }
        }
        $this->render('export_patient_by_checked', compact('model', 'title', 'dataProvider'));
    }

    public function actionExportPatientByDoctorName(){
        $model = new ExportForm('export_patient_by_doctor_name');
        $model->registration_date = Date('d/m/Y');
        $title = 'Export Patient List - By doctor name ';

        if (isset($_POST['ExportForm'])) {
            $columns = $_POST['export-column'];
            foreach ($this->listExportColumnsChecked as $key => $value) {
                $pos = strpos(implode(',', array_keys($columns)), $key);
                if ($pos === false) {
                    $this->listExportColumnsChecked[$key] = '';
                }
                else{
                    $this->listExportColumnsChecked[$key] = 'checked="checked"';
                }
            }

            $model->attributes = $_POST['ExportForm'];
            $model->validate();
            if (!$model->hasErrors()) {
                $list = Patient::model()->getListByDoctorName($_POST['ExportForm']);
                $this->processExport($_POST['export_type'], $list, $columns, $title);
            }
        }
        $this->render('export_patient_by_doctor_name', compact('model', 'title'));
    }

    public function actionExportPatientByRegistrationDate(){
        $model = new ExportForm('export_patient_by_registration_date');
        $model->registration_date = Date('d/m/Y');
        $title = 'Export Patient List - By registration date';

        if (isset($_POST['ExportForm'])) {
            $columns = $_POST['export-column'];
            foreach ($this->listExportColumnsChecked as $key => $value) {
                $pos = strpos(implode(',', array_keys($columns)), $key);
                if ($pos === false) {
                    $this->listExportColumnsChecked[$key] = '';
                }
                else{
                    $this->listExportColumnsChecked[$key] = 'checked="checked"';
                }
            }

            $model->attributes = $_POST['ExportForm'];
            $model->validate();
            if (!$model->hasErrors()) {
                $list = Patient::model()->getListByRegistrationDate($_POST['ExportForm']);
                $this->processExport($_POST['export_type'], $list, $columns, $title);
            }
        }
        $this->render('export_patient_by_registration_date', compact('model', 'title'));
    }

    /**
     * [actionExportPatientByVisit description]
     * @return [type] [description]
     * <Jason Hai>
     * <pmhai90@gmail.com>
     */
    protected function toolExportWord($dataProvider, $columns, $title, $filename = "Patients.doc")
    {
        $view = $this->renderPartial('export_word', compact('dataProvider', 'columns', 'title'), true);
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment; filename=".$filename);
        header("Content-Transfer-Encoding: binary");
        ob_clean();
        flush();
        echo $view;
        Yii::app()->end();
    }

    /**
     * [actionExportPatientByVisit description]
     * @return [type] [description]
     * <Jason Hai>
     * <pmhai90@gmail.com>
     */
    protected function toolExportExcel($dataset, $columns, $filename = "Patients")
    {
        Yii::import('application.extensions.phpexcel.Classes.PHPExcel');
                $objPHPExcel = new PHPExcel();
                // Set properties
                $objPHPExcel->getProperties()->setCreator("VerzDesign")
                                ->setLastModifiedBy("VerzDesign")
                                ->setTitle($filename)
                                ->setSubject("Office 2007 XLSX Document")
                                ->setDescription("Members")
                                ->setKeywords("office 2007 openxml php")
                                ->setCategory("Members");
                $objPHPExcel->getActiveSheet()->setTitle($filename); 
                $objPHPExcel->setActiveSheetIndex(0);
        $row=1;
        $i=1;
        $index=1;
        $beginBorder = $row;
        $objPHPExcel->getActiveSheet()->setCellValue(MyFormat::columnName($index++)."$row", 'S/N');
        foreach ($columns as $key => $value) {
            $objPHPExcel->getActiveSheet()->setCellValue(MyFormat::columnName($index)."$row", $value);
            $objPHPExcel->getActiveSheet()->getColumnDimension(MyFormat::columnName($index++))->setWidth(ExportForm::$listExportWidth[$key]);
        }
        $objPHPExcel->getActiveSheet()->getStyle("A$beginBorder:".MyFormat::columnName($index).$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);       

        $index--;
        $row++;
        foreach ($dataset as $value) {
            $index=1;
            $objPHPExcel->getActiveSheet()->setCellValue(MyFormat::columnName($index++)."$row", $i);
            $item = Patient::model()->findByPk($value['id']);

            foreach ($columns as $key => $v) {
                $val = str_replace("<br>", PHP_EOL, $item->$key);
                if ($key == 'dob') {
                    $val = date('d/m/Y', strtotime($item->$key));
                }
                if ($key == 'doctor_name') {
                    $val = $item->doctor->name;
                }
                $objPHPExcel->getActiveSheet()->setCellValue(MyFormat::columnName($index++)."$row", $val);
            }
            $row++;
            $i++;
        }
        $row--;
        if (count($dataset) > 0) {
            $index--;
        }

        $objPHPExcel->getActiveSheet()->getStyle("B$beginBorder:".MyFormat::columnName($index).($row))
            ->getAlignment()->setWrapText(true);

        $objPHPExcel->getActiveSheet()->getStyle("A$beginBorder:".MyFormat::columnName($index).$row)
                        ->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);        

        $objPHPExcel->getActiveSheet()->getColumnDimension()->setAutoSize(true); //Scott, set column 
        $objPHPExcel->getActiveSheet()->getStyle("A$beginBorder:".MyFormat::columnName($index).$beginBorder)->getFont()->setSize(13)->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("A$beginBorder:".MyFormat::columnName($index).$beginBorder)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle("A$beginBorder:".MyFormat::columnName($index).$beginBorder)->getFill()->getStartColor()->setRGB('DBEAF9');
        $objPHPExcel->getActiveSheet()->getStyle("A$beginBorder:".MyFormat::columnName($index).$beginBorder)->getFont()->getColor()->setRGB('000000');

        ++$beginBorder;
        $objPHPExcel->getActiveSheet()->getStyle("A$beginBorder:".MyFormat::columnName($index).$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);       

        //save file
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        for($level=ob_get_level();$level>0;--$level)
        {
            @ob_end_clean();
        }
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-type: '.'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$filename.'.'.'xlsx'.'"');

        header('Cache-Control: max-age=0');             
        $objWriter->save('php://output');
        Yii::app()->end(); 
    }

}
