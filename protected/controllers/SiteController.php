<?php

class SiteController extends FrontController {

    public $attempts = MAX_TIME_TO_SHOW_CAPTCHA;
    public $counter;

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
    public function actionIndex() {
        error_reporting(1);
        if(!isset(Yii::app()->user->id))
            $this->redirect(Yii::app()->createAbsoluteUrl('/login'));
        
        $c = new CDbCriteria;
        $c->with = array(
            'timeslot',
        );
        $c->addCondition("Date(timeslot.start) = '" . date('Y-m-d')."'");
//        $c->compare('t.from_api', 0);
        $c->order = ' t.id desc';
        $model = Appointment::model()->findAll($c);
        $doctor = Doctor::model()->find();
        $modelSearch = new Appointment('search');
        if (isset($_POST['Appointment'])) {
            $startDate = $_POST['Appointment']['startDate'];
            $endDate = $_POST['Appointment']['endDate'];
            $time = $_POST['Appointment']['time'];
            $modelSearch->setAttributes($_POST['Appointment'], false);
            $modelSearch->doctor_id = $doctor->id;

            if ($startDate == '') $startDate = date('Y-m-d');
            else $startDate = HDateTime::formatDate($startDate);

            if ($endDate == '') {
                $endDate = $startDate;
            }
            else $endDate = HDateTime::formatDate($endDate);

            $modelSearch->startDate = date('Y-m-d', strtotime($startDate));
            $modelSearch->endDate = date('Y-m-d', strtotime($endDate));

            $modelSearch->time = $time;
            $model = Appointment::model()->searchAppointmentForPrint($modelSearch);
            $modelSearch->startDate = date('d-m-Y', strtotime($startDate));
            $modelSearch->endDate = date('d-m-Y', strtotime($endDate));
        }
		$this->render('index', array(
            'model' => $model,
            'modelSearch' => $modelSearch,
            'doctor' => $doctor,
        ));
    }

    public function actionRegister() {
        try {
            $model = new Users('createMemberFE');
            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model);
            if (isset($_POST['Users'])) {
                $model->attributes = $_POST['Users'];
                // if ok validate then send sms or email
                if ($model->validate()) {
                    $model->status = STATUS_ACTIVE;
                    $model->role_id = ROLE_MEMBER;
                    $model->application_id = FE;
                    $model->password_hash = md5($model->temp_password);
                    $model->verify_code = Users::model()->checkVerifyCode(rand(100000, 1000000)); // Gen verify code and send qua mail or sms
                    if ($model->save()) {
                        //recieve Newsletter
                        if (isset($_POST['Users']['recieveNewsletter'])) {
                            Subscriber::addSubscriber($model->full_name, $model->email);
                        }
                        //registering successfully, send email to User
                        SendEmail::registerSucceedMailToUser($model);
                        //registering successfully, send email to Administrator
                        SendEmail::registerSucceedMailToAdmin($model);

                        $nextPage = Cms::getModelById(THANK_SIGN_UP_PAGE);
                        Yii::app()->user->setFlash('success', $nextPage);
                        $this->redirect(Yii::app()->createAbsoluteUrl('site/thankYou'));
                    }
                }
            }
            $this->render('register', array(
                'model' => $model
            ));
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException("Exception " . print_r($e, true));
        }
    }

    private function captchaRequired() {
        return Yii::app()->session->itemAt('captchaRequired') >= $this->attempts;
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $this->layout = 'plain';

        $model = $this->captchaRequired() ? new LoginForm('captchaRequired') : new LoginForm();
        $returnUrl = '';
        if (isset($_GET['returnUrl'])) {
            $returnUrl = urldecode($_GET['returnUrl']);
        }
        
        $isCookie = isset(Yii::app()->request->cookies['redbullcredentials'])?Yii::app()->request->cookies['redbullcredentials']:null;
        $isCookie = $isCookie != null ? json_decode($isCookie, true) : null;
        
        // collect user input data
        if (isset($_POST['LoginForm']) || $isCookie) {
            if (isset($_POST['LoginForm']))
                $model->attributes = $_POST['LoginForm'];
            elseif ($isCookie) {
                $model->username = $isCookie['key'];
                $model->password = $isCookie['value'];
            }
            //if($model->validate() && $model->login())
            if ($model->validate()) {
                switch (Yii::app()->user->role_id) {
                    case ROLE_MEMBER:
                        $this->redirect(Yii::app()->createAbsoluteUrl('queues/queue'));
                        break;
                    case ROLE_ADMIN:
                        $this->redirect(Yii::app()->createAbsoluteUrl('queues/queue'));
                        break;

                    default :$this->redirect(Yii::app()->createAbsoluteUrl('queues/queue'));
                }
                Yii::app()->session->add('captchaRequired', 0);
                Yii::app()->end();
            } else {
                $this->counter = Yii::app()->session->itemAt('captchaRequired') + 1;
                Yii::app()->session->add('captchaRequired', $this->counter);
            }
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        unset(Yii::app()->request->cookies['redbullcredentials']);
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->createAbsoluteUrl('/login'));
    }

    /**
     * This is the action reset password member
     */
    public function actionForgotPassword() {
        $model = new Users();
        $model->scenario = 'forgotPassword';
        if (isset($_POST['Users'])) {
            $userM = Users::model()->find('email="' . trim($_POST['Users']['email']) . '"');
            if (!is_null($userM)) {
                $newPassw = StringHelper::getRandomString(6);
                $userM->password_hash = md5($newPassw);
                $userM->temp_password = $newPassw;
                $userM->update();

                SendEmail::forgetPassMailToUser($userM);
            } else {
                $errorNotice = 'Your typed email does not existed. Please check it again.';
                $model->addError('email', $errorNotice);
            }
        }
        $this->render('forgot_password', array('model' => $model));
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
