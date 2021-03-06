<?php

class GlucoseController extends FrontController {

    public $singleTitle = 'Glucose';
    public $pluralTitle = 'Glucose Information';

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
        if (isset($_POST['PatientGlucose'])) {
            $model->attributes=$_POST['PatientGlucose'];
            $patient_id = Yii::app()->request->getParam('patient_id',null);
            $model->validate();
            if (!$model->hasErrors()) {
                $model->patient_id = $patient_id;
                $model->date = date('Y-m-d H:i:s');

                if($model->save()){
                    $this->redirect(Yii::app()->createAbsoluteUrl('patients/healthynotes', array('patient_id' => $patient_id, 'healthytype' => 'glucose')));
                }
            }
        }
    }

   public function actionCreate()
   {
        $this->pageTitle = 'Glucose  - '. Yii::app()->params['defaultPageTitle'];
        $model = new PatientGlucose();
        $this->handleCreate($model);
        $this->render('create', compact('model'));
   }
   public function actionIndex()
   {
        $this->pageTitle = 'Drug Alert - '. Yii::app()->params['defaultPageTitle'];
        $this->render('index');   
   }

    public function handleUpdate($model){
        if (isset($_POST['PatientGlucose'])) {
            $model->attributes=$_POST['PatientGlucose'];
            $model->validate();
            if (!$model->hasErrors()) {
                if($model->save()){
                    $this->redirect(Yii::app()->createAbsoluteUrl('patients/healthynotes', array('patient_id' => $model->patient_id, 'healthytype' => 'glucose')));
                }
            }
        }
    }

   public function actionUpdate()
   {
        $this->pageTitle = 'Update ' . $this->singleTitle . ' - '. Yii::app()->params['defaultPageTitle'];
        $id = Yii::app()->request->getParam('id',null);
        $model = PatientGlucose::model()->findByPk($id);

        $this->handleUpdate($model);
        $this->render('update', compact('model'));  
   }

    public function actionDelete(){
        $this->pageTitle = 'Delete - '.$this->singleTitle. ' - '. Yii::app()->params['defaultPageTitle'];
        $patient_id = Yii::app()->request->getParam('patient_id',null);
        $deleteItems = $_POST['glucose-grid_c0'];
        $shouldDelete = array_diff($deleteItems, array());
        var_dump($shouldDelete);
        if (!empty($shouldDelete))
        {
            PatientGlucose::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
            $this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted');
        }
        else
            $this->setNotifyMessage(NotificationType::Error, 'No records was deleted');
        echo "Done";
   }
}

