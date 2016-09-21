<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class PatientsAppointmentHistoryController extends FrontController
{
    public $singleTitle = 'Appointment History';
    public $pluralTitle = 'Appointment History Information';

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
  
    public function handleCreate($model){
        if (isset($_POST['PatientAppointmentHistory'])) {
            $model->attributes=$_POST['PatientAppointmentHistory'];
            $patient_id = Yii::app()->request->getParam('patient_id',null);
            $model->validate();
            if (!$model->hasErrors()) {
                $model->patient_id = $patient_id;
                $model->appointment_date = date('Y-m-d');

                if($model->save()){
                    if ( Yii::app()->user->isAdmin ) {
                        $this->redirect(Yii::app()->createAbsoluteUrl('admin/patients/appointmenthistory', array('patient_id' => $patient_id)));
                    }
                    else{
                        $this->redirect(Yii::app()->createAbsoluteUrl('patients/appointmenthistory', array('patient_id' => $patient_id)));
                    }
                }
            }
        }
    }

   public function actionCreate()
   {
        $this->pageTitle = 'Appointment History  - '. Yii::app()->params['defaultPageTitle'];
        $model = new PatientAppointmentHistory();
        $this->handleCreate($model);
        $this->render('create', compact('model'));
   }
   public function actionIndex()
   {
        $this->pageTitle = 'Drug Alert - '. Yii::app()->params['defaultPageTitle'];
        $this->render('index');   
   }

   public function actionUpdate()
   {
        
   }

   public function actionDelete()
   {
        $this->pageTitle = 'Delete - '.$this->singleTitle. ' - '. Yii::app()->params['defaultPageTitle'];
        $deleteItems = $_POST['appointment-history-grid_c0'];
        $shouldDelete = array_diff($deleteItems, array());
                
        if (!empty($shouldDelete))
        {
            Appointment::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
            $this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted');
        }
        else
            $this->setNotifyMessage(NotificationType::Error, 'No records was deleted');
   }
}
?>
