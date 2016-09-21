<?php
/**
 * Author: Jason Hai
 * Email: pmhai90@gmail.com
 * Des: To print all options
 */
class MpdfPrintController extends FrontController {
    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('captcha'),
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $this->pageTitle = 'Print - '. Yii::app()->params['defaultPageTitle'];
        $patient_id = Yii::app()->request->getParam('patient_id',null);
        $type = Yii::app()->request->getParam('type',null);

        switch ($type) {
            case 'patient':
                {
                    $dataProvider = Patient::model()->search(true);
                    if(!isset($dataProvider)) $this->redirect(array('patients/index')); //return to patient page
                }
                break;              
            case 'drugalert':
            {
               
                $dataProvider = PatientDrugAlert::model()->getListBaseOnPatient($patient_id, true);
                if(!isset($dataProvider))  {
                    $this->redirect(array('patients/detail', 'patient_id' => $patient_id)); //return to drugalert page
                }
            }
                break;
            case 'appointmenthistory':
                {
                    $dataProvider = Appointment::model()->getListBaseOnPatient($patient_id, true);
                    
                    if(!isset($dataProvider)) $this->redirect(array('patients/detail', 'patient_id' => $patient_id)); //return to drugalert page
                }
                break;
            case 'dispensinghistory':
                {
                    $dataProvider = Dispense::model()->findAll('patient_id = '.$patient_id);
                    if(!isset($dataProvider)) $this->redirect(array('patients/detail', 'patient_id' => $patient_id)); //return to drugalert page
                }
                break;
            case 'prescription':
                {
                    $dataProvider = Prescription::model()->getAll($patient_id, true);
                    if(!isset($dataProvider)) $this->redirect(array('patients/detail', 'patient_id' => $patient_id)); //return to drugalert page
                }
                break;   
            case 'selected_prescription':
                {
                    $shouldPrint = Yii::app()->request->getParam('shouldPrint',null);
                    $dataProvider = Prescription::model()->getAllBaseOnArray($shouldPrint);
                    if(!isset($dataProvider)) $this->redirect(array('patients/detail', 'patient_id' => $patient_id)); //return to drugalert page
                }
                break;                 
            case 'paymenthistory':
                {
               
                    $dataProvider = Pay::model()->getListPayment($patient_id);
                    if(!isset($dataProvider)) {
                        $this->redirect(array('patients/detail', 'patient_id' => $patient_id)); //return to drugalert page
                    }
                }
                break; 
            case 'selected_paymenthistory':
                {
                    $shouldPrint = Yii::app()->request->getParam('shouldPrint',null);
                    $dataProvider = PayItems::model()->getAllBaseOnArray($shouldPrint);
                    if(!isset($dataProvider)) $this->redirect(array('patients/detail', 'patient_id' => $patient_id)); //return to drugalert page
                }
                break;   
            case 'heightweight':
                {
                    $dataProvider = PatientHeightWeight::model()->getListBaseOnPatient($patient_id, true);
                    if(!isset($dataProvider)) $this->redirect(array('patients/detail', 'patient_id' => $patient_id)); //return to drugalert page
                }
                break; 
            case 'selected_heightweight':
                {
                    $shouldPrint = Yii::app()->request->getParam('shouldPrint',null);
                    $dataProvider = PatientHeightWeight::model()->getAllBaseOnArray($shouldPrint);
                    if(!isset($dataProvider)) $this->redirect(array('patients/detail', 'patient_id' => $patient_id)); //return to drugalert page
                }
                break;  
            case 'blood_pressure':
                {
                    $dataProvider = PatientBloodPressure::model()->getListBaseOnPatient($patient_id, true);
                    if(!isset($dataProvider)) $this->redirect(array('patients/detail', 'patient_id' => $patient_id)); //return to drugalert page
                }
                break; 
            case 'glucose':
                {
                    $dataProvider = PatientGlucose::model()->getListBaseOnPatient($patient_id, true);
                    if(!isset($dataProvider)) $this->redirect(array('patients/detail', 'patient_id' => $patient_id)); //return to drugalert page
                }
                break;                                                                                                          
            case 'medicalrecord':
                {
                    $dataProvider = PatientMedicalRecord::model()->getListBaseOnPatient($patient_id, true);
                    if(!isset($dataProvider)) $this->redirect(array('patients/detail', 'patient_id' => $patient_id)); //return to drugalert page
                }
                break;          
            case 'companymedicalinsurrance':
                {
                    $dataProvider = PatientMedicalInsurrance::model()->getListBaseOnPatient($patient_id);
                    if(!isset($dataProvider)) $this->redirect(array('patients/detail', 'patient_id' => $patient_id)); //return to drugalert page
                }
                break;   
            case 'payments':
            {
                $dataProvider = Pay::model()->getListPayment($patient_id);
                if(!isset($dataProvider)) {
                    $this->redirect(array('payments/print', 'patient_id' => $patient_id)); //return to payment page
                }
            }
            case 'queue':
            {
               
                $dataProvider = Queue::model()->getQueuesByDoctorId(Yii::app()->user->id);
                
                if(!isset($dataProvider)) {
                    $this->redirect(array('payments/print', 'patient_id' => $patient_id)); //return to payment page
                }
            }
            break;
              
           
        }
        $this->getContent($type, $dataProvider,$patient_id);
    }

    public function getContent($type, $dataProvider, $patient_id = null, $columns = null, $title = null)
    {
        ob_start(); 
        $this->pageTitle = 'Print - '. Yii::app()->params['defaultPageTitle'];
        header('Content-type: application/pdf');
        // header('Content-Type: application/force-download');
        // header('Content-Type: application/octet-stream');
        // header('Content-Type: application/download'); 
        $trialMark  = false;
        $printWaterMark = false;
        $arrayRepTag = array('<p>', '</p>');
        $statusId    = 0;
        
        //****************** START PRINT PDF ************************
        $mpdfPageType   = 'P';// Defaut is Portrait
        $mpdfFormatType = 'A4';
        
        // CREATE NEW PDF
        $height = 0;
        $marginRight = 15;
        $marginLeft  = 15;
        $marginTop   = $height + 10;
        $marginBot   = 10;
        
        $mpdf = new mpdf('', $mpdfFormatType, 0, '', $marginLeft, $marginRight, $marginTop, $marginBot, 9, 9);
        $mpdf->SetDisplayMode(100);
        $mpdf->SetTitle('FPDF tutorial');
        
         //Set Watermark                
        if($printWaterMark){
            $watermarkImg = Yii::app()->theme->baseUrl . '/img/watermark.png';
            $mpdf->SetWatermarkImage($watermarkImg, 0.8);
            $mpdf->showWatermarkImage = true;
        }
      
        $mpdf->SetFont('ctimes', '', 14);
        $mpdf->SetTextColor(0, 0, 0);
                
       
        // //Get PDF Template To Print  
        $printLayout = $type;              
        $printTemplateName = $this->getTemplateName($printLayout);
        $layoutContent  = $this->renderPartial($printTemplateName, compact('dataProvider', 'printHeader', 'columns', 'title','patient_id'), true, true); 
        //echo $layoutContent; die;
        $mpdf->WriteHTML($layoutContent);
        //OUT PUT PDF        
        $pdfName = '';
        $pdfName .= date('His') . '_' .date("Ymd");
        $pdfName .= '.pdf';
        ob_end_clean();    
        $mpdf->Output($pdfName , 'I');
        unset($mpdf);
        exit;
    }

    protected function getTemplateName($printLayout){
        switch($printLayout){    
            case 'patient':  $printLayoutName = 'patient';break; 
            case 'drugalert':  $printLayoutName = 'drugalert';break; 
            case 'appointmenthistory':  $printLayoutName = 'appointmenthistory';break; 
            case 'dispensinghistory':  $printLayoutName = 'dispensinghistory';break; 
            case 'prescription':  
            case 'selected_prescription':
                $printLayoutName = 'prescription';break; 
            case 'paymenthistory':  
                 $printLayoutName = 'paymenthistory';break; 
            case 'selected_paymenthistory':
                $printLayoutName = 'paymenthistory';break; 
            case 'heightweight':  
            case 'selected_heightweight':
                $printLayoutName = 'heightweight';break;                 
            case 'blood_pressure':  $printLayoutName = 'blood_pressure';break; 
            case 'glucose':  $printLayoutName = 'glucose';break;  
            case 'medicalrecord':  $printLayoutName = 'medicalrecord';break;  
            case 'companymedicalinsurrance':  $printLayoutName = 'companymedicalinsurrance';break;  

            case 'allpatient':  $printLayoutName = 'tools/allpatient';break; 
            case 'payments':  $printLayoutName = 'payments/payments';break; 
            case 'payments-invoice':  $printLayoutName = 'payments/payments_invoice';break;
            case 'invoice':  $printLayoutName = 'payments/invoice';break;
            case 'receipt':  $printLayoutName = 'payments/receipt';break;
            case 'queue': $printLayoutName = 'queue';break;
            
        }  
        return $printLayoutName; 
    }

    /**
     * Start area for tools function
     */
    public $printColumns = array(
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
    public $listPrintColumnsChecked = array(
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

    public function actionPrintPatientByAllentry(){
        $model = new ExportForm();
        $model->registration_date = Date('d/m/Y');
        $title = 'Print Patient List - All Entry';

        if (isset($_POST['print_type'])) {
            $columns = $_POST['print-column'];
            foreach ($this->listPrintColumnsChecked as $key => $value) {
                $pos = strpos(implode(',', array_keys($columns)), $key);
                if ($pos === false) {
                    $this->listPrintColumnsChecked[$key] = '';
                }
                else{
                    $this->listPrintColumnsChecked[$key] = 'checked="checked"';
                }
            }

            $model->validate();
            if (!$model->hasErrors()) {
                $list = Patient::model()->getListByAllentry();
                $this->processPrint('allpatient', $list, $columns, $title);
            }
        }
        $this->render('tools/print_patient_by_allentry', compact('model', 'title'));
    }

    public function actionPrintPatientByAlphabet(){
        $model = new ExportForm();
        $model->registration_date = Date('d/m/Y');
        $title = 'Print patient list - Name start with alphabet to alphabet';

        if (isset($_POST['print_type'])) {
            $columns = $_POST['print-column'];
            foreach ($this->listPrintColumnsChecked as $key => $value) {
                $pos = strpos(implode(',', array_keys($columns)), $key);
                if ($pos === false) {
                    $this->listPrintColumnsChecked[$key] = '';
                }
                else{
                    $this->listPrintColumnsChecked[$key] = 'checked="checked"';
                }
            }

            $model->validate();
            if (!$model->hasErrors()) {
                $list = Patient::model()->getListByAlphabet($_POST['ExportForm']);
                $this->processPrint('allpatient', $list, $columns, $title);
            }
        }
        $this->render('tools/print_patient_by_alphabet', compact('model', 'title'));
    }

    public function actionPrintPatientNameLabel(){
        $title = 'Print patient name label - Tick box to select one patient';
        $dataProvider = Patient::model()->getListByAllentry();

        if (isset($_POST['patient'])) {
            $columns = $_POST['print-column'];
            $patients = $_POST['patient'];
            foreach ($this->listPrintColumnsChecked as $key => $value) {
                $pos = strpos(implode(',', array_keys($columns)), $key);
                if ($pos === false) {
                    $this->listPrintColumnsChecked[$key] = '';
                }
                else{
                    $this->listPrintColumnsChecked[$key] = 'checked="checked"';
                }
            }
            $patients = implode(',', $patients);
            $list = Patient::model()->getListByChecked($patients);
            $this->processPrint('allpatient', $list, $columns, $title);
        }
        $this->render('tools/print_patient_name_label', compact('title', 'dataProvider'));
    }

    public function actionPrintPatientChecked(){
        $title = 'Print patient list - By Checked';
        $patient = new Patient('search');
        
        if (isset($_POST['patient'])) {
            $columns = $_POST['print-column'];
            $patients = $_POST['patient'];
            foreach ($this->listPrintColumnsChecked as $key => $value) {
                $pos = strpos(implode(',', array_keys($columns)), $key);
                if ($pos === false) {
                    $this->listPrintColumnsChecked[$key] = '';
                }
                else{
                    $this->listPrintColumnsChecked[$key] = 'checked="checked"';
                }
            }
            $patients = implode(',', $patients);
            $list = Patient::model()->getListByChecked($patients);
            $this->processPrint('allpatient', $list, $columns, $title);
        }
        $this->render('tools/print_patient_checked', compact('title', 'patient'));
    }

    public function actionPrintPatientProfile(){
        $title = 'Print patient Profile - Tick box to select one patient';
        $patient = new Patient('search');

        if (isset($_POST['patient'])) {
            $columns = $_POST['print-column'];
            $patients = $_POST['patient'];
            foreach ($this->listPrintColumnsChecked as $key => $value) {
                $pos = strpos(implode(',', array_keys($columns)), $key);
                if ($pos === false) {
                    $this->listPrintColumnsChecked[$key] = '';
                }
                else{
                    $this->listPrintColumnsChecked[$key] = 'checked="checked"';
                }
            }
            $patients = implode(',', $patients);
            $list = Patient::model()->getListByChecked($patients);
            $this->processPrint('allpatient', $list, $columns, $title);
        }
        $this->render('tools/print_patient_profile', compact('title', 'patient'));
    }

    public function processPrint($type, $list, $columns, $title){
        if(!isset($list)) $this->redirect(array('tools/print')); //return to patient page
        $this->getContent($type, $list, $columns, $title);
    }
    public function actionPrintInvoice($patient_id = null){
        $title = 'Print patient Invoice - Tick box to select one patient';
        $model= new Pay('search');
        if($patient_id!=null) {
               $model =  Pay::model()->getAll($patient_id);
        }
        $this->render('../tools/print/invoice',array('model'=>$model,'patient_id'=>$patient_id));
    }
    
    public function actionPrintPayment($patient_id = null){
        $title = 'Print patient Invoice - Tick box to select one patient';
        
        $payment= new Pay('search');
        if($patient_id!=null) {
              $payment =  Pay::model()->getAll($patient_id);
        }
       
        $this->render('../tools/print/payment',array('model'=>$payment,'patient_id'=>$patient_id));
    }
    
    public function actionPrintReceipt($patient_id=null){
        $title = 'Print patient Receipt - Tick box to select one patient';
        $model= new Pay('search');
        if($patient_id!=null) {
              $model =  Pay::model()->getAll($patient_id);
        }
        $this->render('../tools/print/receipt',array('model'=>$model,'patient_id'=>$patient_id));
    }
    
    /*
     * function print invoice
     * @param int 
     * @return view
     */
    public  function actionInvoice($patient_id,$pay_id,$type) {
        
        $dataProvider = PayItems::model()->getListPayment($patient_id,$pay_id);
        if(!isset($dataProvider)) {
            $this->redirect(array('payments/invoice', 'patient_id' => $patient_id,'pay_id'=>$pay_id)); //return to payment page
        }
        $this->getContent($type, $dataProvider);
    }
    
    /*
     * function print Receipt
     * @param int 
     * @return view
     */
    public  function actionReceipt($pay_id,$type) {
        
        $dataProvider = PaymentAmount::model()->getListPayment($pay_id);
        $this->getContent($type, $dataProvider);
    }

    
    /*
     * function print Receipt
     * @param int 
     * @return view
     */
    public  function actionPrintSelect() {
        
        $get = Yii::app()->request->getParam('payment-history-grid_c0');
        $type = Yii::app()->request->getParam('type');
        if( isset( $get ) && isset($type)) {
            $dataProvider = Pay::model()->getList($get);
            $this->getContent($type, $dataProvider);
        }
        return true;
    }

    /**
     * End of tools function
     */
}

