<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class PaymentsController extends FrontController
{
    
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

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    protected function performAjaxValidation($model) {
        try {
            if (isset($_POST['ajax'])) {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException("Exception " . print_r($e, true));
        }
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
  

  
   
   public function actionIndex() 
   {
        if (isset($_POST['selectqueue']) && !empty($_POST['selectqueue']))
        {
            Queue::model()->deleteQueues($_POST['selectqueue']);
            $this->redirect(array('queue'));
        }
       

        $doctorList = Doctor::model()->getDoctorList();
     
        $this->render('queue', array('doctorList' => $doctorList));
   }
   
  

    public function actionPrintSelected(){
        $printItems = $_POST['payment-history-grid_c0'];
        $shouldPrint = implode(',', $printItems);
        if (!empty($shouldPrint))
        {
            $type = 'selected_paymenthistory';
            $link = Yii::app()->createAbsoluteUrl('mpdfprint/index', compact('shouldPrint', 'type'));
            echo json_encode(array(
                'link' => $link,
                'code' => true,
            ));
            die;
        }
    }
    
    
    public function actionSearch() {
        $this->pageTitle = 'Search Patients - ' . Yii::app()->params['defaultPageTitle'];
        $model = new Patient('search');
        $model->unsetAttributes();  // clear any default values
        
        $selectPatient = isset($_GET['patient-grid_c0']) ? $_GET['patient-grid_c0']: array();
        if (!empty($selectPatient))
        {
            if (isset($_GET['yt0']))
                $this->redirect(array('index', 'patient'=> $selectPatient[0]));
            else if (isset($_GET['yt1']))
                $this->redirect(array('Add', 'id'=> $selectPatient[0]));
        }
        
         
        if (isset($_GET['Patient'])){
            $model->attributes = $_GET['Patient'];
        }
        else{
            $model->id = -1;
        }

        if (isset($_GET['Patient']['first_char']) && ($_GET['Patient']['first_char'] != 'all')) {
            $model->first_char = $_GET['Patient']['first_char'];
        }
        else{
            $model->first_char = null;
        }
        $this->render('searchpatient', compact('model'));
    }
    
    public function actionPrint($patient_id) {
            
           $model= Pay::model()->getAll($patient_id);
           $this->render('print/_payment',array('model'=>$model));
    }
    
    
    public function actionMakePayments($queue_id )
    {
        $queue = Queue::model()->findByPk($queue_id);
        if(empty($queue)) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        $payment  = Dispense::model()->find('queue_id='.$queue_id);
        if(!empty($payment)) {
           return $this->redirect(array('view','id'=>$payment->id));
        }
        
        $saveData = false;
        $patient = Patient::model()->getPatientID($queue->patient_id);
       
        $DrugAlert = PatientDrugAlert::model()->getDrugAlertPatientID($queue->patient_id);
        $patientInfor = Patient::model()->getPatientInforMation($queue->patient_id, $queue->doctor_id);
        $model = new Dispense();
        $model->add_gst = '0.00';
        $model->subtotal = '0.00';
        $model->total_with_gst = '0.00';
        $model->amount_after_discount = '0.00';
        $model->discount = 0;
         
        for($i=0; $i<5 ; $i++ ) 
        {
            $invoiceItem[$i]  = new DispenseItems();
            $invoiceItem[$i]->quantity =1;
            $invoiceItem[$i]->price = 0;
            $invoiceItem[$i]->price_quantity = '0.00';
            $invoiceItem[$i]->discount =0;
            $invoiceItem[$i]->price_after_discount = '0.00';
            $invoiceItem[$i]->total = '0.00';
        }
        
        

        if (isset($_POST['DispenseItems'])) {

            $invoiceItem = array();
            $dataItem = $_POST['DispenseItems'];
            for($i=0; $i<  count($dataItem) ; $i++ ) 
            {
                
                $invoiceItem[$i]  = new DispenseItems();
                $invoiceItem[$i]->quantity =1;
                $invoiceItem[$i]->price = 0;
                $invoiceItem[$i]->price_quantity = '0.00';
                $invoiceItem[$i]->discount =0;
                $invoiceItem[$i]->price_after_discount = '0.00';
                $invoiceItem[$i]->total = '0.00';
            }
            $model->attributes = $_POST['Dispense'];
            $model->created_date = date('Y/m/d H:i');
           // var_dump($dataItem);die();
           // $model->attributes = $payment;
           
            $arrdataInvoiceItem = array();
            foreach ($dataItem as $item) {
                 if($item['price']>0 && $item['quantity'] > 0) {
                        $arrdataInvoiceItem[] = $item;
                 }
            }
            
            foreach($arrdataInvoiceItem as $index => $item) { 
                    $invoiceItem[$index] = new DispenseItems();
                    $invoiceItem[$index]->attributes = $item;
                    $invoiceItem[$index]->dispense_id = -9999;
                    $model->patient_id = $queue->patient_id;
                    $model->queue_id = $queue->id;
                    
            }
            foreach ($invoiceItem as $index => $item) {
                if($invoiceItem[$index]->price >0  && $invoiceItem[$index]->quantity>0) {
                    if($invoiceItem[$index]->validate()) {
                         $saveData = true;
                    }
                    else {
                        $saveData = false;
                      
                    }
                }
                else
                {
                    $this->setNotifyMessage(NotificationType::Error, 'Payment need at least one items.');
                }
            }
      
        }
        
        if($saveData==true && $model->validate()) {
            $model->invoice_no = AutoInvoiceNoHelper::getInvoiceNo();
            if($model->save(false) ){
                $queue->bill = $model->total_with_gst;
                $queue->seen = 1;
                $queue->dispense = 1;
                if($queue->save()) {
                    foreach ($invoiceItem as $index => $item) {
                        $invoiceItem[$index]->dispense_id = $model->id;
                        $invoiceItem[$index]->patient_id = $queue->patient_id;
                        $invoiceItem[$index]->queue_id = $queue->id;
                        $invoiceItem[$index]->created_date = date('Y-m-d');
                        if($invoiceItem[$index]->service_type == 2 && !empty($invoiceItem[$index]->service_id)) {
                           
                            $service = Inventory::model()->findByPk($invoiceItem[$index]->service_id);
                            //$service->packing = $service->packing - $invoiceItem[$index]->quantity;
                             $service->stock_amount_used = $service->stock_amount_used + $invoiceItem[$index]->quantity;
                            $service->stock_amount_remainder = $service->stock_amount_bought - $service->stock_amount_used ;
                            $service->save(false);
                            $service->save(false);
                        }
                         $invoiceItem[$index]->save();
                    }
                }
                else {
                    var_dump($queue->errors);die;
                }
                $this->setNotifyMessage(NotificationType::Error,null);
                $this->setNotifyMessage(NotificationType::Success, 'Create payments is successfully.');
                return $this->redirect(array('view','id' => $model->id));
            }
           
        }

      
        $doctor_id = $queue->doctor_id;
        
        $langueges = PatientLanguage::model()->getPatientLanguegesName($queue->patient_id);
        $doctor = Doctor::model()->getDoctorById($doctor_id);
        $this->pageTitle = 'Make Payments  - ' . Yii::app()->params['defaultPageTitle'];
        $this->render('make_payment', array(
            'patient' => $patient,
            'doctor' => $doctor,
            'drugalert' => $DrugAlert,
            'invoiceItem' => $invoiceItem,
            'patientInfor' => $patientInfor,
            'langueges' => $langueges,
            'model' =>$model
        ));
    }
    
    public function actionView($id)
    {
       
        $model = $this->loadModel($id);
        if(empty( $model )) {
            
             throw new CHttpException(404, 'The requested page does not exist.');
        }
        $queue = Queue::model()->findByPk($model->queue_id);
        $patient = Patient::model()->getPatientID($model->patient_id);
        $doctor = Doctor::model()->getDoctorById($queue->doctor_id);
        $DrugAlert = PatientDrugAlert::model()->getDrugAlertPatientID( $model->patient_id);
        $patientInfor = Patient::model()->getPatientInforMation( $model->patient_id, $queue->doctor_id);
        $langueges = PatientLanguage::model()->getPatientLanguegesName( $model->patient_id);
        $item = new DispenseItems();
        return $this->render('view',array(
                            'drugalert'=>$DrugAlert,
                            'patientInfor'=>$patientInfor,
                            'langueges'=>$langueges,
                            'model'=>$model,
                            'patient' =>$patient,
                            'invoiceItem' =>$item->getAll($model->id),
                            'queue' => $queue));
    }
    
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        if(empty($model)) {
             throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        $saveData = false;
        
        if((int)$model->total_receive > 0) {
             $this->setNotifyMessage(NotificationType::Error, 'Oop! sorry, cannot edit when bill has been paid.');
             return $this->redirect(array('view','id' => $model->id));
        }
        
        $patient = Patient::model()->getPatientID($model->patient_id);
        $queue = Queue::model()->findByPk($model->queue_id);
        $DrugAlert = PatientDrugAlert::model()->getDrugAlertPatientID($model->patient_id);
        $patientInfor = Patient::model()->getPatientInforMation($model->patient_id,  $queue->doctor_id);
       
         
        $data = new DispenseItems();
        $invoiceItem = $data->getAll($model->id);
        
         $listQty = array();
         foreach ( $invoiceItem as $item) {
              $listQty[$item->id] =  $item->quantity;
         }
        

        if (isset($_POST['DispenseItems'])) {

            $dataItem = $_POST['DispenseItems'];
            
            $model->attributes = $_POST['Dispense'];
            $model->created_date = date('Y/m/d H:i');
            
            $arrdataInvoiceItem = array();
            foreach ($dataItem as $item) {
                  $arrdataInvoiceItem[] = $item;
            }
            
            $invoiceItem = array();
           
            foreach($arrdataInvoiceItem as $index => $item) 
            { 
                    if(isset($item['id']) && !empty($item['id'])) {
                        $invoiceItem[$index] = DispenseItems::model()->findByPk($item['id']);
                        $invoiceItem[$index]->attributes = $item;
                        $invoiceItem[$index]->dispense_id = $model->id;
                        $invoiceItem[$index]->patient_id = $model->patient_id;
                        $invoiceItem[$index]->queue_id = $model->queue_id;
                        $invoiceItem[$index]->created_date = date('Y-m-d');
                       
                    }
                    else
                    {
                        $invoiceItem[$index] = new DispenseItems();
                        $invoiceItem[$index]->attributes = $item;
                        $invoiceItem[$index]->dispense_id = $model->id;
                        $invoiceItem[$index]->patient_id = $model->patient_id;
                        $invoiceItem[$index]->queue_id = $model->queue_id;
                        $invoiceItem[$index]->created_date = date('Y-m-d');
                    }
                    
            }
            
            foreach ($invoiceItem as $index => $item) {
                    if($invoiceItem[$index]->validate()) {
                         $saveData = true;
                    }
                    else {
                        $saveData = false;
                      
                    }
            }
      
        }
        
        $listItemDelete = array();
        if($saveData==true && $model->validate()) {
            if($model->save(false) ){
                //$queue = Queue::model()->findByPk($model->queue_id);
                $queue->bill = $model->total_with_gst;
                $queue->save(false);
                foreach ($invoiceItem as $index => $item) {
                    $invoiceItem[$index]->dispense_id = $model->id;
                    $model->patient_id = $model->patient_id;
                    $model->queue_id = $model->queue_id;
                   
                    $invoiceItem[$index]->save();
                    if($invoiceItem[$index]->service_type == 2 && !empty($invoiceItem[$index]->service_id)) {
                        if(!isset($listQty[$invoiceItem[$index]->id])) {
                            $service = Inventory::model()->findByPk($invoiceItem[$index]->service_id);
                            //$service->packing = $service->packing - $invoiceItem[$index]->quantity;
                            $service->stock_amount_used = $service->stock_amount_used + $invoiceItem[$index]->quantity;
                            $service->stock_amount_remainder = $service->stock_amount_bought - $service->stock_amount_used ;
                            $service->save(false);
                        }
                        
                        if(isset($listQty[$invoiceItem[$index]->id])) {
                            if($listQty[$invoiceItem[$index]->id] < $invoiceItem[$index]->quantity ) {
                               
                                $service = Inventory::model()->findByPk($invoiceItem[$index]->service_id);
                                $service->stock_amount_used = $service->stock_amount_used + ($invoiceItem[$index]->quantity - $listQty[$invoiceItem[$index]->id]);
                                $service->stock_amount_remainder = $service->stock_amount_bought - $service->stock_amount_used ;
                                //$service->packing = $service->packing - ($invoiceItem[$index]->quantity - $listQty[$invoiceItem[$index]->id]);
                                $service->save(false);
                            }
                            
                             if($listQty[$invoiceItem[$index]->id] > $invoiceItem[$index]->quantity ) {
                                $service = Inventory::model()->findByPk($invoiceItem[$index]->service_id);
                                $service->stock_amount_used = $service->stock_amount_used - ($listQty[$invoiceItem[$index]->id] - $invoiceItem[$index]->quantity);
                                $service->stock_amount_remainder = $service->stock_amount_bought - $service->stock_amount_used ;
                                //$service->packing = $service->packing + ($listQty[$invoiceItem[$index]->id] -$invoiceItem[$index]->quantity );
                                $service->save(false);
                                $service->save(false);
                            }
                            
                        }
                    }
                    $listItemDelete[] =  $invoiceItem[$index]->id;
                }
               
                if(!empty($listItemDelete)) {
                    $dataD = DispenseItems::model()->findAll('id NOT IN ('.implode(',',$listItemDelete).') and dispense_id = '.$id.'');
                    foreach ($dataD as $d) {
                        $item_invoice = DispenseItems::model()->findByPk($d->id);
                        if($item_invoice->service_type == 2 && !empty($item_invoice->service_id)) {
                            $service = Inventory::model()->findByPk($item_invoice->service_id);
                            $service->packing = $service->packing + $item_invoice->quantity;
                            $service->save(false);
                            $service->save(false);
                           
                        }
                       
                        
                    }
                    DispenseItems::model()->deleteAll('id NOT IN ('.implode(',',$listItemDelete).') and dispense_id = '.$id.'');
                       
                }
                $this->setNotifyMessage(NotificationType::Success, 'Update payments is successfully.');
                return $this->redirect(array('view','id' => $model->id));
            }
           
        }

       
        $queue = Queue::model()->findByPk($model->queue_id);
        $langueges = PatientLanguage::model()->getPatientLanguegesName($model->patient_id);
        $doctor = Doctor::model()->getDoctorID($queue->doctor_id);
        $this->pageTitle = 'Update Payments  - ' . Yii::app()->params['defaultPageTitle'];
        $this->render('update', array(
            'patient' => $patient,
            'doctor' => $doctor,
            'drugalert' => $DrugAlert,
            'invoiceItem' => $invoiceItem,
            'patientInfor' => $patientInfor,
            'langueges' => $langueges,
            'model' =>$model
        ));
        
        
    }
    
    
    public function actionList($id)
    {
        
        $model = Dispense::model()->find('queue_id ='.$id);
        
        if(empty($model)) {
            return $this->redirect(array('makePayments?queue_id='.$id));
        }
        
        $url = Yii::app()->createAbsoluteUrl('/payments/view/id/'.$model->id);
        return header('location:'.$url);
       
        
    }
    
    public  function actionMakePaid($id) {
        $model = $this->loadModel($id);
       
        if(empty( $model )) {
             throw new CHttpException(404, 'The requested page does not exist.');
        }
        
//        if( $model->total_receive == ($model->amount_after_discount + $model->total_with_gst)) {
//             return $this->redirect(array('reports/viewAmount/'.$model->id));
//        }
        $patient = Patient::model()->getPatientID( $model->patient_id);
        $DrugAlert = PatientDrugAlert::model()->getDrugAlertPatientID( $model->patient_id);
        $patientInfor = Patient::model()->getPatientInforMation( $model->patient_id);
        $langueges = PatientLanguage::model()->getPatientLanguegesName( $model->patient_id);
        
        $payAmonut = new PaymentAmount();
        
        $payAmonut->amount ='0.00';
        $payAmonut->total_received = '0.00';
        $payAmonut->amount_pay = number_format($model->amount_due,2);
        $payAmonut->total = $payAmonut->amount_pay;
        if(isset($_POST['PaymentAmount'])) 
        {
            $payAmonut->attributes = Yii::app()->request->getPost('PaymentAmount');
            $payAmonut->payment_id = $model->id;
            $payAmonut->no_receipt = AutoInvoiceNoHelper::getReceptNo();
            $payAmonut->created = time();
            if ($payAmonut->validate()) 
            {
                
                // payment
                $model->amount_due = $payAmonut->amount_pay;
                $model ->total_receive = $model->total_with_gst - $model->amount_due;
                $model->save();
                //queue
                $queue = Queue::model()->findByPk($model->queue_id);
                $queue ->paid = $model->total_receive ;
                $queue ->save();
               
                $payAmonut->pay_type = implode(',',  $payAmonut->pay_type);
                $payAmonut->amount_pay = $payAmonut->amount;
                $payAmonut->save();
                $this->setNotifyMessage(NotificationType::Success, 'Payment made successfully.');
                return $this->redirect(array('reports/viewAmount','id'=>$payAmonut->id));
            }
        }
        return $this->render('make_paid',array(
                            'drugalert'=>$DrugAlert,
                            'patientInfor'=>$patientInfor,
                            'langueges'=>$langueges,
                            'model'=>$model,
                            'payAmonut' =>$payAmonut,
                            'id'=> $id
            
            ));
    }

    public function actionListPrice() {
        
        $response = array(
            'code'    => 503,
            'data' => '',
        );
        
        $SQL="SELECT name FROM ".PriceList::model()->tableName()." where status = 1";
        $command    = Yii::app()->db->createCommand($SQL);
        $data  = $command->queryAll();
        $response['data'] = $data;
        $response['code'] = 200;
        echo CJSON::encode($response);
        Yii::app()->end();
        
        
        
        
    }
    
    
    public function actionListPriceByName() {
       
        $post = $_POST;
        $response = array(
             'code'  => 503,
             'data'  => $post,
             'price' => 0,
             'service_id' => 0,
         );
         if(isset($post["name"]) && !empty($post["name"])) {
            $service = $post['service_type']; 
            if($service == 1) 
            {
                $SQL="SELECT `clinic_price`,`insurance_price`,`id` FROM ".PriceList::model()->tableName()." WHERE `name` ='".$post["name"]."' and status = 1";
                $command    = Yii::app()->db->createCommand($SQL);
                $data  = $command->queryAll();
               
                $response['data'] = $data;
                $response['code'] = 200;
                if(!empty($data)) {
                    $response['price'] =  $data[0]['clinic_price'];
                    $patient = Patient::model()->findByPk($post["patient_id"]);
                   
                    if($patient->medical_follow == 1) {
                       
                        $response['price'] =  $data[0]['insurance_price'];
                        
                    }
                   
                    $response['service_id'] =  $data[0]['id'];
                }
            }
            if($service == 2) 
            {
                $SQL="SELECT `price_to_patient`,`id` , `insurance_price` FROM ".  Inventory::model()->tableName()." WHERE `brand_name` ='".$post["name"]."' and status = 1";
                $command    = Yii::app()->db->createCommand($SQL);
                $data  = $command->queryAll();

                $response['data'] = $data;
                $response['code'] = 200;
                if(!empty($data)) {
                    $patient = Patient::model()->findByPk($post["patient_id"]);
                    $response['price'] =  $data[0]['price_to_patient'];
                    if($patient->medical_follow == 1) {
                       
                        $response['price'] =  $data[0]['insurance_price'];
                        
                    }
                    $response['service_id'] =  $data[0]['id'];
                }
            }
            
            
         }

        echo CJSON::encode($response);
        Yii::app()->end();
    
    
    }
    
    public function actionPrintPdf($id)
    {
       
        ob_start(); 
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
        
        
        //**** PAGE FOOTER *****
        $htmlFooter = '<p align="center" style="color:grey">Redbull.com</p>';
        $mpdf->DefHTMLFooterByName('MyFooter',$htmlFooter);
        $mpdf->SetHTMLFooterByName('MyFooter');  
        $mpdf->SetFont('ctimes', '', 14);
        $mpdf->SetTextColor(0, 0, 0);
                
        
        $model = $this->loadModel($id);
        $queue = Queue::model()->findByPk($model->queue_id);
        $patient = Patient::model()->getPatientID($model->patient_id);
        $doctor = Doctor::model()->getDoctorById($queue->doctor_id);
        $DrugAlert = PatientDrugAlert::model()->getDrugAlertPatientID( $model->patient_id);
        $patientInfor = Patient::model()->getPatientInforMation( $model->patient_id);
        $langueges = PatientLanguage::model()->getPatientLanguegesName( $model->patient_id);
        $item = new DispenseItems();
        $html = $this->renderPartial('payment_pdf',array(
                            'drugalert'=>$DrugAlert,
                            'patientInfor'=>$patientInfor,
                            'langueges'=>$langueges,
                            'model'=>$model,
                            'invoiceItem' =>$item->getAll($model->id),
                            'queue' => $queue,
                            'css' => $stylesheet,
                           
            ),true);
        $mpdf->WriteHTML($html);
        //OUT PUT PDF        
        $pdfName = '';
        $pdfName .= date('His') . '_' .date("Ymd");
        $pdfName .= '.pdf';
        ob_end_clean();    
        $mpdf->Output($pdfName , 'I');
        unset($mpdf);
        exit;
        
    }
    
    

    public function loadModel($id) 
    {
        
        $initMode = new Dispense();
        $model = $initMode->findByPk($id);
        if ($model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    
    public function actionChangeSeen($id) {
        $objQueue = Queue::model()->findByPk($id);
        if ($id && $objQueue)
        {
            $objQueue->seen = 1;
            $objQueue->update (array('seen'));
        }
        $this->redirect(array('payments/index'));
    }
    
    
}
?>
