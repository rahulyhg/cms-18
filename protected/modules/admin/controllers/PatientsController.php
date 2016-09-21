<?php

class PatientsController extends AdminController
{
    public $pluralTitle = 'Patient';
    public $singleTitle = 'Patient';
    public $cannotDelete = array();

    public function handleCreate($model){
        if (isset($_POST['Patient'])) {
            $model->attributes=$_POST['Patient'];
            $model->validate();
            if (!$model->hasErrors()) {
                $model->registration_date = date('Y-m-d');
                $model->dob = DateHelper::toDbDateFormat($model->dob);
                $model->spouse_dob = DateHelper::toDbDateFormat($model->spouse_dob);
                $model->first_char = strtolower(@$model->name[0]);
                              
                if($model->save()){
                    $model->updateAttributesMedicalInsurrance();
                    $model->updateAttributesPatientDrugAlert();
                    
                    //save language
                    if (isset($_POST['languages']) && count($_POST['languages'] > 0)) {
                        $model->saveLanguage($_POST['languages']);
                    }

                    if (isset($_FILES['Patient_referal_letter']) && (!empty($_FILES['Patient_referal_letter']['name'][0]))) {
                        $model->saveReferralLetter($model->id, $_FILES['Patient_referal_letter']);
                    }

                    //save report
                    if (isset($_FILES['Patient_referal_report']) && (!empty($_FILES['Patient_referal_report']['name'][0]))) {
                        $model->saveReport($model->id, $_FILES['Patient_referal_report']);
                    }

                    //save insurrance card
                    if (isset($_FILES['Patient_medical_insurrance']) && (!empty($_FILES['Patient_medical_insurrance']['name'][0]))) {
                        $model->saveInsurranceCard($model->patientmedicalinsurrance->id, $_FILES['Patient_medical_insurrance']);
                    }

                    // $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been created');
                    // $this->redirect(array('view', 'id'=> $model->id));

                    //redirect to index page
                    Yii::app()->user->setFlash('message', 'Patient data have been created');
                    // $this->redirect(Yii::app()->createAbsoluteUrl('admin/patient/index'));
                    $this->redirect(array('detail', 'patient_id'=> $model->id));
                }
                else{
                    $this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be created for some reasons');
                }
            }
        }
    }

    public function actionCreate(){
        try {
            $model = new Patient();
            $model->registration_date = date('d/m/Y');
            $model->reference_no = MyFunctionCustom::genUniqueCode('P');
            $model->nationality = 'Singaporean';
            $model->residential_country = DEFAULT_COUNTRY;
            $model->mailling_country = DEFAULT_COUNTRY;
            $model->contact_country_1 = DEFAULT_COUNTRY;
            $model->contact_country_2 = DEFAULT_COUNTRY;
            $model->contact_country_3 = DEFAULT_COUNTRY;
            $model->spouse_country = DEFAULT_COUNTRY;
            $model->nok_country_1 = DEFAULT_COUNTRY;
            $model->nok_country_2 = DEFAULT_COUNTRY;
                   
            $this->handleCreate($model);

    //         $model = new Patient('create');
    //         if (isset($_POST['Patient'])) {
    //             $model->attributes = $_POST['Patient'];
    //             if($model->save())
				// {
				// 	$this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been created');
    //                 $this->redirect(array('view', 'id'=> $model->id));
				// }
				// else
				// 	$this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be created for some reasons');
    //         }
            $this->render('create', array(
                'model' => $model,
                'actions' => $this->listActionsCanAccess,
            ));
        }catch (exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException($e);
        }
    }

    
    
    public function actionIndex() {
        try {
            $model=new Patient('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['Patient'])){
                $model->attributes=$_GET['Patient'];
            }

            $this->render('index',array(
                'model'=>$model, 'actions' => $this->listActionsCanAccess,
            ));
        } catch (Exception $e) {
            Yii::log("Exception ".  print_r($e, true), 'error');
            throw  new CHttpException($e);
        }
    }

    public function handleUpdate($model){
        if (isset($_POST['Patient'])) {
            $model->attributes=$_POST['Patient'];
            $model->validate();
            if (!$model->hasErrors()) {
                $model->dob = DateHelper::toDbDateFormat($model->dob);
                $model->spouse_dob = DateHelper::toDbDateFormat($model->spouse_dob);
                $model->registration_date = DateHelper::toDbDateFormat($model->registration_date);
                $model->first_char = strtolower(@$model->name[0]);
                if($model->save()){
                    $model->updateAttributesMedicalInsurrance();
                    $model->updateAttributesPatientDrugAlert();
                    
                    //save language
                    $model->saveLanguage($_POST['languages']);
                              
                    //save referral letter
                    if (isset($_FILES['Patient_referal_letter']) && (!empty($_FILES['Patient_referal_letter']['name'][0]))) {
                        $model->saveReferralLetter($model->id, $_FILES['Patient_referal_letter']);
                    }

                    //save report
                    if (isset($_FILES['Patient_referal_report']) && (!empty($_FILES['Patient_referal_report']['name'][0]))) {
                        $model->saveReport($model->id, $_FILES['Patient_referal_report']);
                    }

                    //save insurrance card
                    if (isset($_FILES['Patient_medical_insurrance']) && (!empty($_FILES['Patient_medical_insurrance']['name'][0]))) {
                        $model->saveInsurranceCard($model->patientmedicalinsurrance->id, $_FILES['Patient_medical_insurrance']);
                    }
                    //redirect to index page
                    Yii::app()->user->setFlash('message', 'Patient data have been saved');
                    // $this->redirect(Yii::app()->createAbsoluteUrl('admin/patient/index'));
                    $this->redirect(array('detail', 'patient_id'=> $model->id));
                }
            }
        }
    }
    
    public function actionUpdate($id) {
        $model=$this->loadModel($id);

        $model->registration_date = !empty( $model->registration_date ) ? DateHelper::toDateFormat($model->registration_date) : null;
        $model->dob = !empty( $model->dob ) ? DateHelper::toDateFormat($model->dob) : null;
        $model->spouse_dob = !empty( $model->spouse_dob ) ? DateHelper::toDateFormat($model->spouse_dob) : null;

        //Get defaut Patient Medical Insurance
        $patientMedicalInsurrance = PatientMedicalInsurrance::model()->getDefaultInsurrance($patient_id);
        if (isset($patientMedicalInsurrance)) {
            $model->setAttributesMedicalInsurrance($patientMedicalInsurrance);    
        }
        $this->handleUpdate($model);


   //      if(isset($_POST['Patient']))
   //      {
   //          $model->attributes=$_POST['Patient'];
   //          if ($model->save())
			// {
			// 					$this->setNotifyMessage(NotificationType::Success, $this->singleTitle . ' has been updated');
			// 	$this->redirect(array('view', 'id'=> $model->id));
			// }
			// else
			// 	$this->setNotifyMessage(NotificationType::Error, $this->singleTitle . ' cannot be updated for some reasons');
   //      }
        //$model->beforeRender();
        $this->render('update',array(
            'model' => $model,
            'actions' => $this->listActionsCanAccess,
            'title_name' => $model->name        ));
    }

    
    public function actionDetail($patient_id) {
        try {
            $model = $this->loadModel($patient_id);
            $defaultInsurrance = PatientMedicalInsurrance::model()->getDefaultInsurrance($patient_id);
            $this->render('detail', array(
                'model'=> $model,
                'actions' => $this->listActionsCanAccess,
                'type' => 'patient_registration',
                'patient_id' => $patient_id,
                'defaultInsurrance' => $defaultInsurrance,
                'title_name' => $model->name            ));
        } catch (Exception $exc) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

	/*
	* Bulk delete
	* If you don't want to delete some specified record please configure it in global $cannotDelete variable
	*/
	public function actionDeleteAll()
	{
		$deleteItems = $_POST['patient-grid_c0'];
		$shouldDelete = array_diff($deleteItems, $this->cannotDelete);

		if (!empty($shouldDelete))
		{
						Patient::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
			$this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted');
		}
		else
			$this->setNotifyMessage(NotificationType::Error, 'No records was deleted');

		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}
	
		
    public function loadModel($id){
		//need this define for inherit model case. Form will render parent model name in control if we don't have this line
		$initMode = new Patient();
        $model=$initMode->findByPk($id);
        if($model===null)
                throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    public function actionDrugAlert($patient_id = null) {
        $this->pageTitle = 'Patient Detail - Drug Alert - ' . Yii::app()->params['defaultPageTitle'];
        $patient_id = Yii::app()->request->getParam('patient_id',null);
        $dataProvider = PatientDrugAlert::model()->getListBaseOnPatient($patient_id);
                
        $this->render("detail", 
            array(
                'type' => 'drugalert', 
                'patient_id' => $patient_id,
                'dataProvider' => $dataProvider
        ));
    }

    public function actionAppointmentHistory($patient_id = null) {
        $this->pageTitle = 'Patient Detail - Appointment History - ' . Yii::app()->params['defaultPageTitle'];
        $patient_id = Yii::app()->request->getParam('patient_id',null);
        $dataProvider = Appointment::model()->getListBaseOnPatient($patient_id);
                
        $this->render("detail", 
            array('type' => 'appointment_history',
                'patient_id' => $patient_id,
                'dataProvider' => $dataProvider
        ));
    }

    public function actionDispensingHistory($patient_id = null) {
        $this->pageTitle = 'Patient Detail - Dispensing History - ' . Yii::app()->params['defaultPageTitle'];
        $patient_id = Yii::app()->request->getParam('patient_id',null);
        $prescription = Prescription::model()->getAll($patient_id);
        $depensing = Dispense::model()->getAll($patient_id);
        // $depensing = Dispense::model()->getAll($patient_id);
        $this->render("detail", 
            array('type' => 'dispensing_history', 
                'prescription' => $prescription, 
                'patient_id' => $patient_id,
                'depensing' => $depensing
            ));
    }

    public function actionPaymentHistory($patient_id = null) {
        $this->pageTitle = 'Patient Detail - Payment History - ' . Yii::app()->params['defaultPageTitle'];
        $patient_id = Yii::app()->request->getParam('patient_id',null);
       //$dataProvider = PayItems::model()->getAll($patient_id);
        $dataProvider= Pay::model()->getAll($patient_id);
        $this->render("detail", 
            array('type' => 'payment_history', 
                'dataProvider' => $dataProvider,
                'patient_id' => $patient_id,
            ));
    }

    public function actionMedicalRecord($patient_id = null) {
        $this->pageTitle = 'Patient Detail - Medical Record - ' . Yii::app()->params['defaultPageTitle'];
        $patient_id = Yii::app()->request->getParam('patient_id',null);
        $dataProvider = PatientMedicalRecord::model()->getListBaseOnPatient($patient_id);

        $this->render("detail", 
            array('type' => 'medical_record',
                'patient_id' => $patient_id,
                'dataProvider' => $dataProvider
        ));
    }

    public function actionCompanyMedical($patient_id = null) {
        $this->pageTitle = 'Patient Detail - Company Medical Insurrance - ' . Yii::app()->params['defaultPageTitle'];
        $patient_id = Yii::app()->request->getParam('patient_id',null);
        $dataProvider = PatientMedicalInsurrance::model()->getListBaseOnPatient($patient_id);
        $this->render("detail", 
            array('type' => 'company_medical',
                'patient_id' => $patient_id,
                'dataProvider' => $dataProvider
            )
        );
    }
   

    public function actionHealthyNotes($patient_id = null) {
        $this->pageTitle = 'Patient Detail - Healthy Notes - ' . Yii::app()->params['defaultPageTitle'];
        $patient_id = Yii::app()->request->getParam('patient_id',null);
        $healthytype = Yii::app()->request->getParam('healthytype', 'height_weight');

        $heightweight = PatientHeightWeight::model()->getListBaseOnPatient($patient_id);
        $blood_pressure = PatientBloodPressure::model()->getListBaseOnPatient($patient_id);
        $glucose = PatientGlucose::model()->getListBaseOnPatient($patient_id);
                
        $this->render("detail", array(
            'type' => 'healthy_notes', 
            'heightweight' => $heightweight, 
            'healthytype' => $healthytype,
            'blood_pressure' => $blood_pressure,
            'glucose' => $glucose,
            'patient_id' => $patient_id,
        ));
    }    

    // public function actionDelete($id) {
    //     try {
    //         if(Yii::app()->request->isPostRequest) {
    //             // we only allow deletion via POST request
    //             if (!in_array($id, $this->cannotDelete))
    //             {
    //                 if($model = $this->loadModel($id)){
    //                     // if($model->delete())
    //                     $model->comment_deleted = $_POST['Patient']['comment_deleted'];
    //                     $model->is_deleted = 1;
    //                     $model->date_deleted = date('Y-m-d H:i:s');
    //                     if($model->update(array('is_deleted', 'date_deleted', 'comment_deleted')))
    //                     Yii::log("Delete record ".  print_r($model->attributes, true), 'info');
    //                 }

    //                 // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    //                 if(!isset($_GET['ajax']))
    //                     // $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    //                     $this->redirect(array('admin/index'));
    //             }
    //         } else {
    //             Yii::log("Invalid request. Please do not repeat this request again.");
    //             throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    //         }
    //     } catch (Exception $e) {
    //         Yii::log("Exception ".  print_r($e, true), 'error');
    //         throw  new CHttpException($e);
    //     }
    // }      

    public function actionDelete() {
        $patient_id = Yii::app()->request->getParam('patient_id', null);
        $url = Yii::app()->createAbsoluteUrl('admin/patients/detail', compact('patient_id'));
        $urlOk = Yii::app()->createAbsoluteUrl('admin/patients/index');
        if (is_null($patient_id)) {
            $this->redirect($url);
        }
        else{
            $model = $this->loadModel($patient_id);
            $model->comment_deleted = $_POST['Patient']['comment_deleted'];
            $model->is_deleted = 1;
            $model->date_deleted = date('Y-m-d H:i:s');
            if($model->update(array('is_deleted', 'date_deleted', 'comment_deleted'))){
                $this->redirect($urlOk);
            }
            else{
                $this->redirect($url);
            }
        }
    }
     
    public function actionExport() {
        $patient = new Patient('search');
        $cmsFormatter = new BaseFormatter(); 

        if (isset($_SESSION['data-excel-patient']) && count($_SESSION['data-excel-patient']) > 0) {
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
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Name', true);
            $objPHPExcel->getActiveSheet()->setCellValue('C1', 'ID', true);
            $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Preferred Contact No', true);
            $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Speaks', true);
            $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Date of birth', true);
            $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Gender', true);
            $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Address', true);
            $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Important Comment To Notes', true);

            $objPHPExcel->getActiveSheet()->getStyle("A1:I1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("A1:I1")->getFont()
                            ->setBold(true);
            
            $i = 1;
            $dataAll = $_SESSION['data-excel-patient']->data;
            foreach ($dataAll as $item) {
                $i++;
                $language = str_replace("<br>", PHP_EOL, $cmsFormatter->formatLanguagename($item->id));
                $address = str_replace("<br>", PHP_EOL, $cmsFormatter->formatAddress($item));
                $note = str_replace("<br>", PHP_EOL, $item->important_comment_to_notes);

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $i, true);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $item->name, true);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $item->identity, true);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $item->contact_no, true);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $language, true);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $cmsFormatter->formatDate($item->dob), true);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $item->gender, true);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $address, true);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $note, true);
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

            $objPHPExcel->getActiveSheet()->getColumnDimension()->setAutoSize(true); //Scott, set column 
            $objPHPExcel->getActiveSheet()->getStyle("A1:I1")->getFont()->setSize(13)->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("A1:I1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyle("A1:I1")->getFill()->getStartColor()->setRGB('DBEAF9');
            $objPHPExcel->getActiveSheet()->getStyle("A1:I1")->getFont()->getColor()->setRGB('000000');

            $objPHPExcel->getActiveSheet()->getStyle("B1:I$i")
            ->getAlignment()->setWrapText(true);
            
            $objPHPExcel->getActiveSheet()->getStyle("A1:I$i")
                    ->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);        

            $objPHPExcel->getActiveSheet()->getStyle("A2:I$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);       

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

    public function actionPrint() {
        $c = new CDbCriteria;
        $c->order = 'is_default desc, name';
        $model = new Appointment('search');
        $doctorList = Doctor::model()->findAll($c);
        $modelPreview = new Appointment();
        $doctorPreview = new Doctor();
        $startDate = '';
        $endDate = '';
        
        if (isset($_REQUEST['Appointment']['doctor_id'])){
            $model->attributes = $_REQUEST['Appointment'];

            $doctor_id = $_POST['Appointment']['doctor_id'];
            $startDate = HDateTime::formatDate($_POST['Appointment']['startDate']);
            $endDate = HDateTime::formatDate($_POST['Appointment']['endDate']);
            $time = $_POST['Appointment']['time'];

            $model->doctor_id = $doctor_id;
            $model->startDate = HDateTime::format($startDate, 'd-m-Y');
            $model->endDate = HDateTime::format($endDate, 'd-m-Y');
            $model->time = $time;

            $modelPreview = Appointment::searchAppointmentForPrint($doctor_id, $startDate, $endDate, $time);
            $doctorPreview = Doctor::model()->findByPk($doctor_id);
        }
        
        $this->render('print', array(
            'model' => $model,
            'doctorList' => $doctorList,
            'modelPreview' => $modelPreview,
            'doctorPreview' => $doctorPreview,
            'startDate' => $startDate,
            'endDate' => $endDate
        ));
    }

    public function actionPrint_Appointment_Result() {
        if (isset($_GET['doctor_id'])) {
            $doctor_id = $_GET['doctor_id'];
            $startDate = HDateTime::formatDate($_GET['start']);
            $endDate = HDateTime::formatDate($_GET['end']);
            $time = $_GET['time'];
            $type = $_GET['type'];
            $ids = $_GET['turnup'];
            $patients = $_GET['patients'];
            $model = Appointment::searchAppointmentForPrint($doctor_id, $startDate, $endDate, $time, $type, $ids, $patients);
            $doctor = Doctor::model()->findByPk($doctor_id);
            if (count($model) == 0) {
                echo 'No result found';
                return;
            }
            $this->renderPartial('print_template', array('model' => $model, 'doctor' => $doctor, 'startDate' => $startDate, 'endDate' => $endDate, 'ids' => $ids, 'time' => $time));
        } else {
            echo 'No result found';
        }
    }      

    public function actionUnderConstruction() {
        $this->render('underconstruction');
    }

    public function actionDownloadDocument() {
        try {
            $type = Yii::app()->request->getParam('type', null);
            if ($type == 'insurrance_card') {
                $model = PatientInsurranceCard::model()->findByPk((int) $_GET['id']);
            }
            elseif($type == 'report') {
                $model = PatientReport::model()->findByPk((int) $_GET['id']);
            }
            else{
                $model = PatientReferralLetter::model()->findByPk((int) $_GET['id']);
            }

            if (is_null($model))
                throw new Exception('No document found.');

            //get file
            if(empty($model->name))
                throw new Exception("Invalid request. No $name_field found.");
            $src = "upload/patient/".$model->patient_id."/".$type."/".$model->name;
            $fileHelper = new FileHelper();
            $fileHelper->forceDownload($src);  
        } catch (Exception $exc) {
            throw new CHttpException(403, $exc->getMessage());
        }
    }

    public function actionDeleteDocument() {
        $id = Yii::app()->request->getParam('id', null);
        $type = Yii::app()->request->getParam('type', null);

        if ($type == 'insurrance_card') {
            $model=PatientInsurranceCard::model()->findByPk($id);
        }
        elseif($type == 'referral_letter'){
            $model=PatientReferralLetter::model()->findByPk($id);
        }
        else{
            $model=PatientReport::model()->findByPk($id);
        }
        if($model){
            $model->delete();
            echo json_encode(array('code'=>true, 'id'=>$id, 'type'=>$type));
        }
        else{
            echo json_encode(array('code'=>false, 'id'=>$id, 'type'=>$type));
        }
    }     
}