<?php

class PatientsController extends FrontController {

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
    public function actionDetail($patient_id = null) {
        $this->pageTitle = 'Patient Detail - ' . Yii::app()->params['defaultPageTitle'];
        $patient_id = Yii::app()->request->getParam('patient_id', null);
        $model = $this->loadModel($patient_id);
        if (empty($model)) {
            $this->redirect(Yii::app()->createAbsoluteUrl('patients/index'));
        }
        $defaultInsurrance = PatientMedicalInsurrance::model()->getDefaultInsurrance($patient_id);
        $this->render("detail", array('model' => $model, 'type' => 'patient_registration', 'patient_id' => $patient_id, 'defaultInsurrance' => $defaultInsurrance));
    }

    public function handleCreate($model) {
        if (isset($_POST['Patient'])) {
            $model->attributes = $_POST['Patient'];
            $model->validate();
            if (!$model->hasErrors()) {

                $model->registration_date = date('Y-m-d');
                $model->dob = DateHelper::toDbDateFormat($model->dob);
                $model->spouse_dob = DateHelper::toDbDateFormat($model->spouse_dob);
                $model->first_char = strtolower(@$model->name[0]);

                $letter_file_description = $model->attach_referral_letter_description;
                $report_file_description = $model->attach_report_description;
                $attach_insurance_description = $model->attach_insurance_description;

                if ($model->save()) {

                    $model->updateAttributesMedicalInsurrance();
                    $model->updateAttributesPatientDrugAlert();

                    //save language
                    if (isset($_POST['languages']) && count($_POST['languages'] > 0)) {
                        $model->saveLanguage($_POST['languages']);
                    }

                    $model->saveFile('attach_referral_letter_file', 'attach_referral_letter_id', $letter_file_description, 'referral_letter', false);
                    $model->saveFile('attach_report_file', 'attach_report_file_id', $report_file_description, 'report', false);
                    $model->saveFile('attach_insurance_file', 'attach_insurance_file_id', $attach_insurance_description, 'insurrance_card', false);

//                    if (isset($_FILES['Patient_referal_letter']) && (!empty($_FILES['Patient_referal_letter']['name'][0]))) {
//                        $model->saveReferralLetter($model->id, $_FILES['Patient_referal_letter']);
//                    }
//
//                    //save report
//                    if (isset($_FILES['Patient_referal_report']) && (!empty($_FILES['Patient_referal_report']['name'][0]))) {
//                        $model->saveReport($model->id, $_FILES['Patient_referal_report']);
//                    }
//
//                    //save insurrance card
//                    if (isset($_FILES['Patient_medical_insurrance']) && (!empty($_FILES['Patient_medical_insurrance']['name'][0]))) {
//                        $model->saveInsurranceCard($model->patientmedicalinsurrance->id, $_FILES['Patient_medical_insurrance']);
//                    }

                    if (isset($_GET['add_queue']) && $_GET['add_queue'] != '') {
                        $queue = new Queue('create');
                        $queue->time_in = date("H:i");
                        $queue->seen = 0;
                        $queue->dispense = 0;
                        $queue->patient_name = $model->name;
                        $queue->patient_id = $model->id;
                        $queue->bill = 0;
                        $queue->paid = 0;
                        $queue->doctor_id = Yii::app()->user->id;
                        $queue->save();
                    }

                    //redirect to index page
                    Yii::app()->user->setFlash('message', 'Patient data have been created');
                    $this->redirect(Yii::app()->createAbsoluteUrl('patients/detail', array('patient_id' => $model->id)));
                }
            }
        } else {
            $appointmentId = isset($_GET['appointment_id']) ? (int) $_GET['appointment_id'] : 0;
            if ($appointmentId > 0) {
                $appointment = Appointment::model()->findByPk($appointmentId);
                if ($appointment) {
                    $model->registration_date = date('Y-m-d');
                    $model->name = $appointment->patient_name;
                    $model->contact_number_1 = $appointment->patient_mobile;
                    $model->contact_mobile_1 = $appointment->area_code_id;
                    $model->contact_email = $appointment->patient_email;
                    $model->identity = $appointment->patientId;
                }
            }
        }
    }

    public function actionCreate() {
        $this->pageTitle = 'Add Patients - ' . Yii::app()->params['defaultPageTitle'];
        $patient_name = Yii::app()->request->getParam('patient_name', null);

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
        $model->doctor_id = Yii::app()->user->id;
        if (!empty($patient_name)) {
            $model->name = $patient_name;
        }
        $this->handleCreate($model);
        $this->render('create', compact('model'));
    }

    public function handleUpdate($model) {
        if (isset($_POST['Patient'])) {
            $model->attributes = $_POST['Patient'];
            $model->validate();
            if (!$model->hasErrors()) {

                $letter_file_description = $model->attach_referral_letter_description;
                $report_file_description = $model->attach_report_description;
                $attach_insurance_description = $model->attach_insurance_description;

                $model->dob = DateHelper::toDbDateFormat($model->dob);
                $model->spouse_dob = DateHelper::toDbDateFormat($model->spouse_dob);
                $model->registration_date = DateHelper::toDbDateFormat($model->registration_date);
                $model->first_char = strtolower(@$model->name[0]);
                if ($model->save()) {
                    $model->updateAttributesMedicalInsurrance();
                    $model->updateAttributesPatientDrugAlert();

                    //save language
                    $model->saveLanguage($_POST['languages']);

                    $model->saveFile('attach_referral_letter_file', 'attach_referral_letter_id', $letter_file_description, 'referral_letter', true);
                    $model->saveFile('attach_report_file', 'attach_report_file_id', $report_file_description, 'report', true);
                    $model->saveFile('attach_insurance_file', 'attach_insurance_file_id', $attach_insurance_description, 'insurrance_card', true);

                    //redirect to index page
                    Yii::app()->user->setFlash('message', 'Patient data have been saved');
                    $this->redirect(Yii::app()->createAbsoluteUrl('patients/detail', array('patient_id' => $model->id)));
                }
            }
        }
    }

    public function actionUpdate() {
        $this->pageTitle = 'Update Patients - ' . Yii::app()->params['defaultPageTitle'];
        $patient_id = Yii::app()->request->getParam('patient_id', null);

        $model = $this->loadModel($patient_id);

        $model->registration_date = !empty($model->registration_date) ? DateHelper::toDateFormat($model->registration_date) : null;
        $model->dob = !empty($model->dob) ? DateHelper::toDateFormat($model->dob) : null;
        $model->spouse_dob = !empty($model->spouse_dob) ? DateHelper::toDateFormat($model->spouse_dob) : null;

        //Get defaut Patient Medical Insurance
        $patientMedicalInsurrance = PatientMedicalInsurrance::model()->getDefaultInsurrance($patient_id);
        if (isset($patientMedicalInsurrance)) {
            $model->setAttributesMedicalInsurrance($patientMedicalInsurrance);
        }
        $this->handleUpdate($model);

        $this->render('update', compact('model'));
    }

    public function actionIndex() {
        $this->pageTitle = 'All Patients - ' . Yii::app()->params['defaultPageTitle'];
        $model = new Patient();
        
        if (isset($_GET['deleted']))
            $model->is_deleted = 1;
        else {
            $model->is_deleted = 0;
        }
        if (isset($_REQUEST['Patient']['first_char']) && ($_REQUEST['Patient']['first_char'] != 'all')) {
            $model->first_char = $_REQUEST['Patient']['first_char'];
        } else {
            $model->first_char = null;
        }
        $this->render('index', array('model' => $model));
    }

    public function actionSearch() {
        $this->pageTitle = 'Search Patients - ' . Yii::app()->params['defaultPageTitle'];
        $model = new Patient('search');
        $model->unsetAttributes();  // clear any default values

        $selectPatient = isset($_GET['patient-grid_c0']) ? $_GET['patient-grid_c0'] : array();
        $name = isset($_GET['Patient']['name']) ? trim($_GET['Patient']['name']) : '';
        if (!empty($selectPatient)) {
            $this->redirect(array('queues/create', 'patientId' => $selectPatient[0]));
        }
        if (!empty($name) && !Patient::isExist($name)) {
            $model->is_popup = true;
        }

        if (isset($_GET['Patient'])) {
            $model->attributes = $_GET['Patient'];
            $model->name = trim($_GET['Patient']['name']);
            $model->identity = trim($_GET['Patient']['identity']);
            $model->reference_no = trim($_GET['Patient']['reference_no']);
            $model->contact_number_1 = trim($_GET['Patient']['contact_number_1']);
            $model->contact_country_1 = trim($_GET['Patient']['contact_country_1']);
        } else {
            $model->id = -1;
        }

        if (isset($_GET['Patient']['first_char']) && ($_GET['Patient']['first_char'] != 'all')) {
            $model->first_char = $_GET['Patient']['first_char'];
        } else {
            $model->first_char = null;
        }
        $this->render('search', compact('model'));
    }

    public function actionDrugAlert($patient_id = null) {
        $this->pageTitle = 'Patient Detail - Drug Alert - ' . Yii::app()->params['defaultPageTitle'];
        $patient_id = Yii::app()->request->getParam('patient_id', null);
        $dataProvider = PatientDrugAlert::model()->getListBaseOnPatient($patient_id);

        $this->render("detail", array(
            'type' => 'drugalert',
            'patient_id' => $patient_id,
            'dataProvider' => $dataProvider
        ));
    }

    public function actionAppointmentHistory($patient_id = null) {
        $this->pageTitle = 'Patient Detail - Appointment History - ' . Yii::app()->params['defaultPageTitle'];
        $patient_id = Yii::app()->request->getParam('patient_id', null);
        $dataProvider = Appointment::model()->getListBaseOnPatient($patient_id);

        $this->render("detail", array('type' => 'appointment_history',
            'patient_id' => $patient_id,
            'dataProvider' => $dataProvider
        ));
    }

    public function actionDispensingHistory($patient_id = null) {
        $this->pageTitle = 'Patient Detail - Dispensing History - ' . Yii::app()->params['defaultPageTitle'];
        $patient_id = Yii::app()->request->getParam('patient_id', null);
        $prescription = Prescription::model()->getAll($patient_id);
        $depensing = Dispense::model()->getAll($patient_id);
        // $depensing = Dispense::model()->getAll($patient_id);
        $this->render("detail", array('type' => 'dispensing_history',
            'prescription' => $prescription,
            'patient_id' => $patient_id,
            'depensing' => $depensing
        ));
    }

    public function actionPaymentHistory($patient_id = null) {
        $this->pageTitle = 'Patient Detail - Payment History - ' . Yii::app()->params['defaultPageTitle'];
        $patient_id = Yii::app()->request->getParam('patient_id', null);

        $model = new Dispense('search');
        $model->unsetAttributes();
        if (isset($_GET['Dispense']))
            $model->setAttributes($_GET['Dispense']);

        return $this->render('detail', array('dataProvider' => $model, 'type' => 'payment_history', 'patient_id' => $patient_id,));
    }

    public function actionMedicalRecord($patient_id = null) {
        $this->pageTitle = 'Patient Detail - Medical Record - ' . Yii::app()->params['defaultPageTitle'];
        $patient_id = Yii::app()->request->getParam('patient_id', null);
        $dataProvider = PatientMedicalRecord::model()->getListBaseOnPatient($patient_id);

        $this->render("detail", array('type' => 'medical_record',
            'patient_id' => $patient_id,
            'dataProvider' => $dataProvider
        ));
    }

    public function actionCompanyMedical($patient_id = null) {
        $this->pageTitle = 'Patient Detail - Company Medical Insurrance - ' . Yii::app()->params['defaultPageTitle'];
        $patient_id = Yii::app()->request->getParam('patient_id', null);
        $dataProvider = PatientMedicalInsurrance::model()->getListBaseOnPatient($patient_id);
        $this->render("detail", array('type' => 'company_medical',
            'patient_id' => $patient_id,
            'dataProvider' => $dataProvider
            )
        );
    }

    public function actionHealthyNotes($patient_id = null) {
        $this->pageTitle = 'Patient Detail - Healthy Notes - ' . Yii::app()->params['defaultPageTitle'];
        $patient_id = Yii::app()->request->getParam('patient_id', null);
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

    public function loadModel($id) {

        $initMode = new Patient();
        $model = $initMode->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionDelete() {
        $patient_id = Yii::app()->request->getParam('patient_id', null);
        $url = Yii::app()->createAbsoluteUrl('patients/detail', compact('patient_id'));
        $urlOk = Yii::app()->createAbsoluteUrl('patients/index');
        if (is_null($patient_id)) {
            $this->redirect($url);
        } else {
            $model = $this->loadModel($patient_id);
            $model->comment_deleted = $_POST['Patient']['comment_deleted'];
            $model->is_deleted = 1;
            $model->date_deleted = date('Y-m-d H:i:s');
            if ($model->update(array('is_deleted', 'date_deleted', 'comment_deleted'))) {
                $this->redirect($urlOk);
            } else {
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

        if (isset($_REQUEST['Appointment']['doctor_id'])) {
            $model->attributes = $_REQUEST['Appointment'];

            $doctor_id = $_POST['Appointment']['doctor_id'];
            $startDate = HDateTime::formatDate($_POST['Appointment']['startDate']);
            $endDate = HDateTime::formatDate($_POST['Appointment']['endDate']);
            $time = $_POST['Appointment']['time'];

            $model->doctor_id = $doctor_id;
            $model->startDate = HDateTime::format($startDate, 'd-m-Y');
            $model->endDate = HDateTime::format($endDate, 'd-m-Y');
            $model->time = $time;
            $model->scenario = 'print';
            $modelPreview = Appointment::searchAppointmentForPrint($model);
            $doctorPreview = Doctor::model()->findByPk($doctor_id);
            if ($model->validate()) {
                $modelPreview = Appointment::searchAppointmentForPrint($model);
                $doctorPreview = Doctor::model()->findByPk($doctor_id);
            }
        }
        $this->pageTitle = 'Print Patients - ' . Yii::app()->params['defaultPageTitle'];

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
        $this->pageTitle = 'Print patient  - ' . Yii::app()->params['defaultPageTitle'];
        $model = new Appointment('search');
        if (isset($_GET['doctor_id'])) {
            $model->attributes = $_GET;

            $doctor_id = $_GET['doctor_id'];
            $startDate = HDateTime::formatDate($_GET['start']);
            $endDate = HDateTime::formatDate($_GET['end']);
            $time = $_GET['time'];
            $type = $_GET['type'];
            $ids = $_GET['turnup'];
            $patients = $_GET['patients'];
            $timeslotList = explode('-', $patients);

            $model->doctor_id = $doctor_id;
            $model->startDate = $startDate;
            $model->endDate = $endDate;
            $model->time = $time;
            $model->timeslotList = $timeslotList;

            $model = Appointment::searchAppointmentForPrint($model);
            $doctor = Doctor::model()->findByPk($doctor_id);
            if (count($model) == 0) {
                echo '<title>Print Patients</title> No result found';
                return;
            }
            $this->title = '';
            $this->renderPartial('print_template', array('model' => $model, 'doctor' => $doctor, 'startDate' => $startDate, 'endDate' => $endDate, 'ids' => $ids, 'time' => $time));
        } else {
            die;
            echo 'No result found';
        }
    }

}
