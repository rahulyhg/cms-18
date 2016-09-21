<?php

class QueuesController extends FrontController {

    public $pluralTitle = 'Queue';
    public $singleTitle = 'Queue';
    public $cannotDelete = array();
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
    
    public function actionSearchPatient()
    {
        $this->pageTitle = 'Search Patients - ' . Yii::app()->params['defaultPageTitle'];
        $model = new Patient('search');
        $model->unsetAttributes();  // clear any default values
        $selectPatient = isset($_GET['patient-grid_c0']) ? $_GET['patient-grid_c0']: array();
        if (!empty($selectPatient))
        {
            $this->redirect(array('create', 'patientId'=> $selectPatient[0]));
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

    public function actionCreate($patientId) {
        try {
            $patientId = $_GET['patientId'];
            $loggedUser = Users::model()->findByPk(Yii::app()->user->id);
            $patientIdArr = explode(",", $patientId);
            foreach ($patientIdArr as $itemId)
            {
                $patientInfo = Patient::model()->findByPk($itemId);
                if (!empty($patientInfo))
                {
                    $model = new Queue('create');
                    $model->time_in = date("H:i");
                    $model->seen = 0;
                    $model->dispense = 0;
                    $model->patient_name = $patientInfo->name;
                    $model->patient_id = $itemId;
                    $model->bill = 0;
                    $model->paid = 0;
                    $model->doctor_id = Yii::app()->user->id;
                    if (!$model->save())
                    {
                        $allError = $model->getErrors();
                        $errorStr = '';
                        foreach($allError as $attr => $msg)
                        {
                            
                            $errorStr .= "- Patient $patientInfo->name - " . $msg[0] . "<br />";
                            $this->setNotifyMessage(NotificationType::Error, $errorStr);
                        }
                        
                    }
                   
                }
            }
            $this->redirect(array('/queues/queue')); 

        }catch (exception $e) {
            //Yii::log("Exception " . print_r($e, true), 'error');
            echo $e->getMessage();die;
            throw new CHttpException($e);
        }
    }
    
    public function actionQueue()
    {
       $this->pageTitle = 'Queues - ' . Yii::app()->params['defaultPageTitle'];
        if (isset($_POST['selectqueue']) && !empty($_POST['selectqueue']))
        {
            Queue::model()->deleteQueues($_POST['selectqueue']);
            $this->redirect(array('queue'));
        }

        $doctorList = Doctor::model()->getDoctorList();
        $this->render('list_queue', array('doctorList' => $doctorList));
    }

    public function actionSetasseen()
    {
        $queueId = isset($_GET['queueid']) ? $_GET['queueid'] : 0;
        $objQueue = Queue::model()->findByPk($queueId);
        if ($queueId)
        {
            $objQueue->seen = 1;
            $objQueue->update (array('seen'));
        }
        $this->redirect(array('queues/queue'));
    }
    
  

}
?>