<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ReportsController extends FrontController
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
  
    public function actionPayments(){
        $model = new Dispense('search');
        $model->unsetAttributes();
        if (isset($_GET['Dispense']))
            $model->setAttributes($_GET['Dispense']);
       
        return $this->render('payments', array('model'=>$model));
    }
    
     public function actionPayAmounts($payment_id = null){
        $model = new PaymentAmount('search');
        if(!empty($payment_id)) {
           $payment_id = $_GET['payment_id'];
        }
        $payment = Dispense::model()->findByPk($payment_id);
        $model->unsetAttributes();
        if (isset($_GET['PaymentAmount']))
            $model->setAttributes($_GET['PaymentAmount']);
        
        return $this->render('payment_amount', 
                                array(
                                        'model'=>$model,
                                        'payment_id' => $payment_id,
                                        'payment' => $payment
                                
                                ));
    }
    
    
  


    public function loadModel($id) 
    {
        $initMode = new Dispense();
        $model = $initMode->findByPk($id);
        if ($model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    
    public  function actionViewAmount($id) {
        $amount = $this->loadModelAmount($id);
        $model = $this->loadModel($amount->payment_id);
       
        if(empty( $model )) {
             throw new CHttpException(404, 'The requested page does not exist.');
        }
        
//        if( $model->total_receive == ($model->amount_after_discount + $model->total_with_gst)) {
//             return $this->redirect(array('view','id'=>$model->id));
//        }
        $patient = Patient::model()->getPatientID( $model->patient_id);
        $DrugAlert = PatientDrugAlert::model()->getDrugAlertPatientID( $model->patient_id);
        $patientInfor = Patient::model()->getPatientInforMation( $model->patient_id);
        $langueges = PatientLanguage::model()->getPatientLanguegesName( $model->patient_id);
        $payAmonut = $amount;
        if(isset($_POST['PaymentAmount'])) 
        {
            $payAmonut->attributes = Yii::app()->request->getPost('PaymentAmount');
            $payAmonut->payment_id = $model->id;
            $payAmonut->no_receipt = AutoInvoiceNoHelper::getReceptNo();
            $payAmonut->created = time();
            if ($payAmonut->save()) 
            {
                $queue = Queue::model()->findByPk($model->queue_id);
                $queue ->paid = $payAmonut->amount_pay;
                $queue ->save();
                $model -> total_receive = $payAmonut->amount_pay;
                $model -> amount_due = 0;
                $model->save();
                return $this->redirect(array('view','id'=>$model->id));
            }
        }
        return $this->render('view_amount',array(
                            'drugalert'=>$DrugAlert,
                            'patientInfor'=>$patientInfor,
                            'langueges'=>$langueges,
                            'model'=>$model,
                            'payAmonut' =>$payAmonut,
                            'id'=> $id
            
            ));
    }
    
    public function loadModelAmount($id) 
    {
        $initMode = new PaymentAmount();
        $model = $initMode->findByPk($id);
        if ($model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    
    public function actionUpdateAmount($id) {
        
        $payAmonut = $this->loadModelAmount($id);
        $model = $this->loadModel($payAmonut->payment_id);
       
        if(empty( $model )) {
             throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        $patient = Patient::model()->getPatientID( $model->patient_id);
        $DrugAlert = PatientDrugAlert::model()->getDrugAlertPatientID( $model->patient_id);
        $patientInfor = Patient::model()->getPatientInforMation( $model->patient_id);
        $langueges = PatientLanguage::model()->getPatientLanguegesName( $model->patient_id);
       
        if(empty( $payAmonut )) {
            $payAmonut = new PaymentAmount();
        }
        $payAmonut->pay_type = explode(',', $payAmonut->pay_type);
        $payAmonut->amount_pay = number_format($model->amount_after_discount + $model->total_with_gst,2);
        if(isset($_POST['PaymentAmount'])) 
        {
            $payAmonut->attributes = Yii::app()->request->getPost('PaymentAmount');
            $payAmonut->payment_id = $model->id;
            $payAmonut->no_receipt = AutoInvoiceNoHelper::getReceptNo();
            $payAmonut->update = time();
            $payAmonut->amount =  $payAmonut->amount_pay;
            $payAmonut->total = $payAmonut->amount_pay;
         
            if ($payAmonut->validate()) 
            {
                $payAmonut->pay_type = implode(',',  $payAmonut->pay_type);
                $payAmonut->save();
                $queue = Queue::model()->findByPk($model->queue_id);
                $queue ->paid = $payAmonut->amount_pay;
                $queue ->save();
                $model -> total_receive = $payAmonut->amount_pay;
                $model -> amount_due = 0;
                $model->save();
                $this->setNotifyMessage(NotificationType::Success, 'Update payment made successfully');
                return $this->redirect(array('viewAmount','id'=>$payAmonut->id));
            }
           
            
        }
        return $this->render('update_amount',array(
                            'drugalert'=>$DrugAlert,
                            'patientInfor'=>$patientInfor,
                            'langueges'=>$langueges,
                            'model'=>$model,
                            'payAmonut' =>$payAmonut,
                            'id'=> $id
            
            ));
    }
    
    public function actionPrintAmount($id)
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
                
        $Amount = $this->loadModelAmount($id);
        $model = $this->loadModel($Amount->payment_id);
        $queue = Queue::model()->findByPk($model->queue_id);
        $patient = Patient::model()->getPatientID($model->patient_id);
        $doctor = Doctor::model()->getDoctorById($queue->doctor_id);
        $DrugAlert = PatientDrugAlert::model()->getDrugAlertPatientID( $model->patient_id);
        $patientInfor = Patient::model()->getPatientInforMation( $model->patient_id);
        $langueges = PatientLanguage::model()->getPatientLanguegesName( $model->patient_id);
        $item = new DispenseItems();
        $html = $this->renderPartial('/reports/print/print_amount',array(
                            'drugalert'=>$DrugAlert,
                            'patientInfor'=>$patientInfor,
                            'langueges'=>$langueges,
                            'model'=>$model,
                            'invoiceItem' =>$item->getAll($model->id),
                            'queue' => $queue,
                            'css' => $stylesheet,
                            'Amount' => $Amount
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
    
    public function actionPrintAllPayments($patient_id = null)
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
                
        $sql = 'SELECT D.id,D.patient_id, D.invoice_no,D.subtotal,D.discount,D.total_with_gst,D.discount_type,D.amount_after_discount,D.add_gst,D.amount_due,D.total_receive,D.created_date,P.name as patient_name
                        FROM '.  Dispense::tableName().' as D 
                        INNER JOIN '. Queue::tableName().' as Q ON Q.id = D.queue_id 
                        INNER JOIN '. Patient::tableName().' as P ON P.id = D.patient_id ';
                       // WHERE  Q.doctor_id = "'.Yii::app()->user->id.'"
                       //';
        
        if(!empty($patient_id)) {
            $sql .= 'AND D.patient_id = "'.$patient_id.'"' ;
        }
        
        $sql.= ' GROUP BY D.id';
        
        $model = Yii::app()->db->createCommand($sql)->queryAll();
        
        $html = $this->renderPartial('/reports/print/print_payment',array(
                            'css' => $stylesheet,
                            'model' => $model,
                            'patient_id' => $patient_id,
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
    
    public function actionPrintAllAmount($payment_id = null)
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
                
        
         $sql = 'SELECT PA.id,D.invoice_no,  PA.id,PA.amount_pay,PA.no_receipt,PA.payment_id,PA.pay_type,PA.created
                        FROM '. PaymentAmount::tableName().' as PA 
                        INNER JOIN '. Dispense::tableName().' as D ON D.id = PA.payment_id 
                        INNER JOIN '. Queue::tableName().' as Q ON Q.id = D.queue_id 
                        INNER JOIN '. Patient::tableName().' as P ON P.id = D.patient_id 
                        WHERE  Q.doctor_id = "'.Yii::app()->user->id.'" and PA.payment_id ='.$payment_id.'
                        GROUP BY PA.id';
        $model = Yii::app()->db->createCommand($sql)->queryAll();
        
        $html = $this->renderPartial('/reports/print/print_all_amount',array(
                            'css' => $stylesheet,
                            'model' => $model
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
    
    
    public function actionPrint(){
        $model = new PrintForm();
        if(isset($_POST['PrintForm'])) {
            $model->attributes = $_POST['PrintForm'];
            if($model->validate()) {
                $patient = Patient::model()->findAll('name = :name', array('name'=> $model->patient_name));
                $view = '';
                if(!empty($patient)) {
                    switch ($model->print_type){
                        case 1:
                           $view = 'medical';
                            break;
                        case 2 :
                           $view = 'invoice';
                            break;
                        case 3:
                           $view = 'receipt';
                            break;
                        default :
                           $view = 'medical';
                            break;
                    }
                    
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
                    $html = $this->renderPartial('/reports/print/'.$view.'',array(
                                        'css' => $stylesheet,
                                        'model' => $patient[0]
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
                else
                {
                     $this->setNotifyMessage(NotificationType::Error, 'Oop! sorry, Patient "'.$model->patient_name.'" not found in system.');
                }
            }
        }
        return $this->render('print', array('model'=> $model));
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
}
?>
