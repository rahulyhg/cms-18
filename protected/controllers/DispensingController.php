<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class DispensingController extends FrontController {

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
    public function actionEntry($id=null) {
        
        if($id==null)
        {
            if(!empty(Yii::app()->Session['patient']))
            {
                $id=Yii::app()->Session['patient'];
            }
            else
            {
                 $this->setNotifyMessage(NotificationType::Success,' please select patient !');
                return  $this->render('not_patient');
              
            }
        }

        $patient = Patient::model()->getPatientID($id);
        $doctor_id = Queue::model()->getQueuesByDoctorId($id);
        $DrugAlert = PatientDrugAlert::model()->getDrugAlertPatientID($id);
        $patientInfor = Patient::model()->getPatientInforMation($id);
        for ($i = 0; $i < 10; $i++) {
            $model[$i] = new DispenseItems();
        }
        $result = array();
        $temp = 0;
        $isPost = 0;
        $discount = 0;
        $subtotal = 0;
        $total_without_gst = 0;
        $total_with_gst = 0;
        $checkItem=0;

        if (isset($_POST['DispenseItems'])) {

            $discount = $_POST['DispenseItems']['discount'];
            $subtotal = $_POST['DispenseItems']['subtotal'];
            $total_without_gst = $_POST['DispenseItems']['total_without_gst'];
            $total_with_gst = $_POST['DispenseItems']['total_with_gst'];
            for ($i = 0; $i < 10; $i++) {

                $model[$i]->attributes = $_POST['DispenseItems'][$i];
                if ($model[$i]->item_name != '') {
                    $isPost++;
                    $model[$i]->dispense_id = 1;
                    if ($model[$i]->validate()) {
                        $result[] = $i;
                    } else {
                        $temp++;
                    }
                }
                else
                {
                    $checkItem++;
                }
            }
        }
        if ($temp == 0 && $isPost != 0) {
            switch ($_POST['DispenseItems']['type']) {
                case 1:
                    // save pay
                    $modelPay = new Pay();
                    $modelPay->patient_id = $id;
                    $modelPay->created_date = Date('y/m/d');
                    $modelPay->total_without_gst = $total_without_gst;
                    $modelPay->subtotal = $subtotal;
                    $modelPay->discount = $discount;
                    $modelPay->total_with_gst = $total_with_gst;
                    $modelPay->invoice_no=  AutoInvoiceNoHelper::getInvoiceNo();
                    $modelPay->save();
                    //save dispensing
                    $modelDispensi = new Dispense();
                    $modelDispensi->patient_id = $id;
                    $modelDispensi->created_date = Date('y/m/d');
                    $modelDispensi->total_without_gst = $total_without_gst;
                    $modelDispensi->subtotal = $subtotal;
                    $modelDispensi->discount = $discount;
                    $modelDispensi->total_with_gst = $total_with_gst;
                    $modelDispensi->save();
                    for ($i = 0; $i < count($result); $i++) {
                        $model[$result[$i]]->attributes = $_POST['DispenseItems'][$result[$i]];
                        // save pay item
                        $pay = new PayItems();
                        $pay->item_name = $model[$result[$i]]->item_name;
                        $pay->pay_id = $modelPay->id;
                        $pay->discount = $model[$result[$i]]->discount;
                        $pay->quantity = $model[$result[$i]]->quantity;
                        $pay->price = $model[$result[$i]]->price;
                        $pay->payment_date = Date('y/m/d H:i:s');
                        $pay->patient_id=$id;
                        $pay->save();
                        // save dispensing item
                        $model[$result[$i]]->dispense_id = $modelDispensi->id;
                        $model[$result[$i]]->created_date = $modelDispensi->created_date;
                        $model[$result[$i]]->patient_id = $id;
                        $model[$result[$i]]->save();
                    }
                    $this->redirect(array('view', 'dispense' => $modelDispensi->id, 'patient_id' => $id));
                    break;

                case 2:
                   
                    $modelPay = new Pay();
                    $modelPay->patient_id = $id;
                    $modelPay->created_date = Date('y/m/d');
                    $modelPay->total_without_gst = $total_without_gst;
                    $modelPay->subtotal = $subtotal;
                    $modelPay->discount = $discount;
                    $modelPay->total_with_gst = $total_with_gst;
                    $modelPay->invoice_no=  AutoInvoiceNoHelper::getInvoiceNo();
                    $modelPay->save();
                    for ($i = 0; $i < count($result); $i++) {
                        $model[$result[$i]]->attributes = $_POST['DispenseItems'][$result[$i]];
                        $pay = new PayItems();
                        $pay->item_name = $model[$result[$i]]->item_name;
                        $pay->pay_id = $modelPay->id;
                        $pay->discount = $model[$result[$i]]->discount;
                        $pay->quantity = $model[$result[$i]]->quantity;
                        $pay->price = $model[$result[$i]]->price;
                        $pay->payment_date = Date('y/m/d H:i:s');
                        $pay->patient_id=$id;
                        $pay->save();
                    }
                    $this->redirect(array('view', 'dispense' => $modelDispensi->id, 'patient_id' => $id));
                    break;
                case 3:
                    $modelDispensi = new Dispense();
                    $modelDispensi->patient_id = $id;
                    $modelDispensi->created_date = Date('y/m/d');
                    $modelDispensi->total_without_gst = $total_without_gst;
                    $modelDispensi->subtotal = $subtotal;
                    $modelDispensi->discount = $discount;
                    $modelDispensi->total_with_gst = $total_with_gst;
                    $modelDispensi->save();

                    for ($i = 0; $i < count($result); $i++) {
                        $model[$result[$i]]->attributes = $_POST['DispenseItems'][$result[$i]];
                        $model[$result[$i]]->dispense_id = $modelDispensi->id;
                        $model[$result[$i]]->created_date = $modelDispensi->created_date;
                        $model[$result[$i]]->patient_id = $id;
                        $model[$result[$i]]->save();
                    }
                    $this->redirect(array('view', 'dispense' => $modelDispensi->id, 'patient_id' => $id));
                    break;
                default : break;
            }
            for ($i = 0; $i < 10; $i++) {
                $model[$i] = new DispenseItems();
            }
        }
        if($temp==0 && $isPost==0&&$checkItem==10) {
          
             Yii::app()->user->setFlash('entry','Please enter drug item. Drug name cannot be blank');
        }

        if (empty($doctor_id))
            $doctor_id = 1;
        $langueges = PatientLanguage::model()->getPatientLanguegesName($id);
        $doctor = Doctor::model()->getDoctorID($doctor_id);
        $this->pageTitle = 'Dispensing  - ' . Yii::app()->params['defaultPageTitle'];
        $this->render('entry', array(
            'patient' => $patient,
            'doctor' => $doctor,
            'drugalert' => $DrugAlert,
            'model' => $model,
            'patientInfor' => $patientInfor,
            'langueges' => $langueges,
        ));
    }

    

    public static function loadDispense($id) {
        $model = Dispense::model()->findAllByPk($id);
        return $model;
    }

    public function actionView($dispense, $patient_id) {

        $patient = Patient::model()->getPatientID($patient_id);
        $doctor_id = Queue::model()->getQueueDoctorID($patient_id);
        $DrugAlert = PatientDrugAlert::model()->getDrugAlertPatientID($patient_id);
        $patientInfor = Patient::model()->getPatientInforMation($patient_id);
        $model = DispenseItems::model()->findAll('dispense_id=' . $dispense . '');
        if (empty($doctor_id)){
            $doctor_id = 1;
        }
        $langueges = PatientLanguage::model()->getPatientLanguegesName($patient->id);
        $doctor = Doctor::model()->getDoctorID($doctor_id);
        $dispensing = Dispense::model()->find('id=' . $dispense . '');
        $this->render('view', array(
            'patient' => $patient,
            'doctor' => $doctor,
            'drugalert' => $DrugAlert,
            'model' => $model,
            'patientInfor' => $patientInfor,
            'langueges' => $langueges,
            'dispensing' => $dispensing,
            'dispense_id' => $dispense,
            'patient_id' => $patient_id,
        ));
    }

    public function actionUpdate($dispense, $patient_id) {
        $patient = Patient::model()->getPatientID($patient_id);
        $doctor_id = Queue::model()->getQueueDoctorID($patient_id);
        $DrugAlert = PatientDrugAlert::model()->getDrugAlertPatientID($patient_id);
        $patientInfor = Patient::model()->getPatientInforMation($patient_id);

        if (empty($doctor_id))
            $doctor_id = 1;
        $langueges = PatientLanguage::model()->getPatientLanguegesName($patient->id);
        $doctor = Doctor::model()->getDoctorID($doctor_id);

        $modelUpdate = DispenseItems::model()->findAll('dispense_id=' . $dispense . '');
        $i = 0;
        foreach ($modelUpdate as $data) {
            $model[$i] = $data;
            $i++;
        }
        for ($i = count($modelUpdate); $i < 10; $i++) {
            $model[$i] = new DispenseItems();
        }
        $result = array();
        $temp = 0;
        $isPost = 0;
        $discount = 0;
        $subtotal = 0;
        $total_without_gst = 0;
        $total_with_gst = 0;
        $dispensing = Dispense::model()->find('id=' . $dispense . '');
        if (isset($_POST['DispenseItems'])) {
            $discount = $_POST['DispenseItems']['discount'];
            $subtotal = $_POST['DispenseItems']['subtotal'];
            $total_without_gst = $_POST['DispenseItems']['total_without_gst'];
            $total_with_gst = $_POST['DispenseItems']['total_with_gst'];

            for ($i = 0; $i < 10; $i++) {

                $model[$i]->attributes = $_POST['DispenseItems'][$i];
                if ($model[$i]->item_name != '') {
                    $isPost++;
                    $model[$i]->dispense_id = $dispense;
                    if ($model[$i]->validate()) {
                        $result[] = $i;
                    } else {
                        $temp++;
                    }
                }
            }
        }
        if ($temp == 0 && $isPost != 0) {
            switch ($_POST['DispenseItems']['type']) {
                case 1:
                    // save pay
                    $modelPay = new Pay();
                    $modelPay->patient_id = $patient_id;
                    $modelPay->created_date = Date('y/m/d');
                    $modelPay->total_without_gst = $total_without_gst;
                    $modelPay->subtotal = $subtotal;
                    $modelPay->discount = $discount;
                    $modelPay->total_with_gst = $total_with_gst;
                    $modelPay->save();
                    //save dispensing
                    $modelDispensi = Dispense::model()->find('id=' . $dispense . '');
                    $modelDispensi->total_without_gst = $total_without_gst;
                    $modelDispensi->subtotal = $subtotal;
                    $modelDispensi->discount = $discount;
                    $modelDispensi->total_with_gst = $total_with_gst;
                    $modelDispensi->save();
                    DispenseItems::model()->deleteAll('dispense_id=' . $dispense . '');
                    for ($i = 0; $i < count($result); $i++) {
                        $model[$result[$i]]->attributes = $_POST['DispenseItems'][$result[$i]];
                        // save pay item
                        $pay = new PayItems();
                        $pay->item_name = $model[$result[$i]]->item_name;
                        $pay->pay_id = $modelPay->id;
                        $pay->discount = $model[$result[$i]]->discount;
                        $pay->quantity = $model[$result[$i]]->quantity;
                        $pay->price = $model[$result[$i]]->price;
                        $pay->payment_date = Date('y/m/d H:i:s');;
                        $pay->save();
                        // save dispensing item
                        $model[$result[$i]] = new DispenseItems();
                        $model[$result[$i]]->attributes = $_POST['DispenseItems'][$result[$i]];
                        $model[$result[$i]]->dispense_id = $modelDispensi->id;
                        $model[$result[$i]]->created_date = Date('y/m/d');
                        $model[$result[$i]]->patient_id = $patient_id;
                        $model[$result[$i]]->save();
                    }
                    $this->redirect(array('view', 'dispense' => $modelDispensi->id, 'patient_id' => $patient_id));
                    break;

                case 2:
                    $modelPay = new Pay();
                    $modelPay->patient_id = $patient_id;
                    $modelPay->created_date = Date('y/m/d');
                    $modelPay->total_without_gst = $total_without_gst;
                    $modelPay->subtotal = $subtotal;
                    $modelPay->discount = $discount;
                    $modelPay->total_with_gst = $total_with_gst;
                    $modelPay->save();
                    for ($i = 0; $i < count($result); $i++) {
                        $model[$result[$i]]->attributes = $_POST['DispenseItems'][$result[$i]];
                        $pay = new PayItems();
                        $pay->item_name = $model[$result[$i]]->item_name;
                        $pay->pay_id = $modelPay->id;
                        $pay->discount = $model[$result[$i]]->discount;
                        $pay->quantity = $model[$result[$i]]->quantity;
                        $pay->price = $model[$result[$i]]->price;
                        $pay->payment_date = Date('y/m/d H:i:s');
                        $pay->save();
                    }
                    $this->redirect(array('view', 'dispens' => $modelDispensi->id, 'patient_id' => $patient_id));
                    break;
                case 3:
                    $modelDispensi = Dispense::model()->find('id=' . $dispense . '');
                    $modelDispensi->total_without_gst = $total_without_gst;
                    $modelDispensi->subtotal = $subtotal;
                    $modelDispensi->discount = $discount;
                    $modelDispensi->total_with_gst = $total_with_gst;
                    $modelDispensi->save();
                    DispenseItems::model()->deleteAll('dispense_id=' . $dispense . '');
                    for ($i = 0; $i < count($result); $i++) {
                        $model[$result[$i]] = new DispenseItems();
                        $model[$result[$i]]->attributes = $_POST['DispenseItems'][$result[$i]];
                        $model[$result[$i]]->dispense_id = $modelDispensi->id;
                        $model[$result[$i]]->created_date = $modelDispensi->created_date;
                        $model[$result[$i]]->patient_id = $patient_id;
                        $model[$result[$i]]->save();
                    }
                    $this->redirect(array('view', 'dispense' => $modelDispensi->id, 'patient_id' => $patient_id));
                    break;
                default : break;
            }
            for ($i = 0; $i < 10; $i++) {
                $model[$i] = new DispenseItems();
            }
        }

        $this->render('update', array(
            'patient' => $patient,
            'doctor' => $doctor,
            'drugalert' => $DrugAlert,
            'model' => $model,
            'patientInfor' => $patientInfor,
            'langueges' => $langueges,
            'dispense_id' => $dispense,
            'patient_id' => $patient_id,
            'dispensing' => $dispensing,
        ));
    }
    
    
    public function actionEnquiry() {
        
        $this->pageTitle = 'Dispensing - ' . Yii::app()->params['defaultPageTitle'];
        $model = new SearchEnquiryForm();
        $type = 0;
        $date = 0;
        $dispenseItem=null;
        if (isset($_POST['SearchEnquiryForm'])) {

            $model->attributes = $_POST['SearchEnquiryForm'];
            $type = (int)$model->check_type;
            $date = (int)$model->date_type;
            if ($type == 0 && $date == 0) {
                $model->scenario = 'search_patient_name';
                
                if ($model->validate()) {
                    $patient=Patient::model()->searchName($model->patient_id);
                    $list=array();
                    foreach ($patient->data as $data )
                    {
                        $list[]=$data->id;
                    }
                    if(!empty($list))
                    {
                        $dispenseItem=  DispenseItems::model()->searchPatientName($list);
                    }
                    else {
                        $dispenseItem=  DispenseItems::model()->searchPatientName($model->patient_id);
                    }
                }
            }
            if ($type == 0 && $date == 1) {
                 
                $model->scenario = 'search_patient_name_date';    
                
                if ($model->validate()){
                    $patient=Patient::model()->searchName($model->patient_id);
                    $list=array();
                    foreach ($patient->data as $data )
                    {
                        $list[]=$data->id;
                    }
                    if(!empty($list))
                    {
                            $dispenseItem=  DispenseItems::model()->searchTypeNameDate($list,$model->first_date,$model->last_date);
                    }
                    else
                    {
                         $dispenseItem=  DispenseItems::model()->searchTypeNameDate($model->patient_id,$model->first_date,$model->last_date);
                    }
                }
            }
            if ($type == 1 && $date == 0) {
                
                $model->scenario = 'search_drug_name';
              
                if ($model->validate()) {
                    
                    $dispenseItem=  DispenseItems::model()->searchDrugName($model->name);
                }
            }
            if ($type == 1 && $date == 1) {
                $model->scenario = 'search_drug_name_date';
                if ($model->validate()) {
                    $dispenseItem=  DispenseItems::model()->searchTypeDrugDate($model->name,$model->first_date,$model->last_date);
                }
            }
        }
        $modelEnquiry=new DispenseItems();
        $this->render('enquiry', 
       array(
            'model' => $model,
            'type' => $type,
            'date' => $date,
            'result'=>$dispenseItem,
            
        ));
    }

    public function actionPrintSelected(){
        $printItems = $_POST['prescription-grid_c0'];
        $shouldPrint = implode(',', $printItems);
        if (!empty($shouldPrint))
        {
            $type = 'selected_prescription';
            $link = Yii::app()->createAbsoluteUrl('mpdfprint/index', compact('shouldPrint', 'type'));
            echo json_encode(array(
                'link' => $link,
                'code' => true,
            ));
            die;
        }
    }
    public function actionAddpatient()
    {
      $post=Yii::app()->request->getPost('patient');
      if($post)
      {
          Yii::app()->Session['patient']=$post;
      }
      Yii::app()->end();
      
      
    }
    public function actionUnpatient()
    {
       Yii::app()->Session['patient']=null;
       Yii::app()->end();
    }
    public function actionGetpatient()
    {
        $result=array();
        $data=Yii::app()->Session['patient'];
        if(!empty($data))
        {
             $result['status']=true;
             $result['data']=$data;
             
                     
        }
        else {
             $result['status']=false;
             $result['data']=$data;
        }
        echo CJSON::encode($result);
        Yii::app()->end();
        
    }
    
    public function actionSearch() {
        $this->pageTitle = 'Search Patients - ' . Yii::app()->params['defaultPageTitle'];
        $model = new Patient('search');
        $model->unsetAttributes();  // clear any default values
        
        $selectPatient = isset($_GET['patient-grid_c0']) ? $_GET['patient-grid_c0']: array();
        if (!empty($selectPatient))
        {
            $this->redirect(array('entry', 'id'=> $selectPatient[0]));
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
}

?>
