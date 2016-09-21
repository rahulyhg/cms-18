<?php

class PatientmedicalinsurranceController extends FrontController
{
    public $singleTitle = 'Company Medical Insurrance';
    public $pluralTitle = 'Company Medical Insurrance';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
    public function accessRules() {
        return array(
            array('allow',
                'users' => array('*'),
            ),
        );
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new PatientMedicalInsurrance;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PatientMedicalInsurrance']))
		{
			$model->attributes=$_POST['PatientMedicalInsurrance'];
			$patient_id = Yii::app()->request->getParam('patient_id',null);
			$model->validate();
            if (!$model->hasErrors()) {
                $model->patient_id = $patient_id;
                //set default if not exist at least a medical insurrance
                $exist = PatientMedicalInsurrance::model()->checkExist($patient_id);
                if (!$exist) {
                	$model->default = 1;
                }
                if($model->save()){
                	//save insurrance card
                    if (isset($_FILES['PatientMedicalInsurrance_card']) && count($_FILES['PatientMedicalInsurrance_card']['name'] > 0)) {
                        $model->saveInsurranceCard($model->id, $_FILES['PatientMedicalInsurrance_card']);
                    }

                    if ( Yii::app()->user->isAdmin ) {
                        $this->redirect(Yii::app()->createAbsoluteUrl('admin/patients/companymedical', array('patient_id' => $patient_id)));
                    }
                    else{
                        $this->redirect(Yii::app()->createAbsoluteUrl('patients/companymedical', array('patient_id' => $patient_id)));
                    }
                }
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
        $id = Yii::app()->request->getParam('id',null);
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PatientMedicalInsurrance']))
		{
			$model->attributes=$_POST['PatientMedicalInsurrance'];
            $patient_id = Yii::app()->request->getParam('patient_id',null);
            $model->validate();
            if (!$model->hasErrors()) {
                $model->patient_id = $patient_id;
                //set default if not exist at least a medical insurrance
                $exist = PatientMedicalInsurrance::model()->checkExist($patient_id);
                if (!$exist) {
                    $model->default = 1;
                }
                if($model->save()){
                    //save insurrance card
                    if (isset($_FILES['PatientMedicalInsurrance_card']) && count($_FILES['PatientMedicalInsurrance_card']['name'] > 0)) {
                        $model->saveInsurranceCard($model->id, $_FILES['PatientMedicalInsurrance_card']);
                    }

                    if ( Yii::app()->user->isAdmin ) {
                        $this->redirect(Yii::app()->createAbsoluteUrl('admin/patients/companymedical', array('patient_id' => $patient_id)));
                    }
                    else{
                        $this->redirect(Yii::app()->createAbsoluteUrl('patients/companymedical', array('patient_id' => $patient_id)));
                    }
                }
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		// $this->loadModel($id)->delete();
		$patient_id = Yii::app()->request->getParam('patient_id', 0);
        $id = Yii::app()->request->getParam('id',null);
        $model=$this->loadModel($id);

        if ( isset( $model ) ) {
            if ( $model->delete() ) {
                $this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted');
            }
            else{
                $this->setNotifyMessage(NotificationType::Error, 'No records was deleted');
            }
        }

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

    public function actionDeleteInsurrance()
    {
        $patient_id = Yii::app()->request->getParam('patient_id', 0);
        $id = Yii::app()->request->getParam('id',null);
        $model=$this->loadModel($id);
        if ( isset( $model ) ) {
            if ( $model->delete() ) {
                $this->setNotifyMessage(NotificationType::Success, 'Your selected records have been deleted');
            }
            else{
                $this->setNotifyMessage(NotificationType::Error, 'No records was deleted');
            }
        }

        if ( Yii::app()->user->isAdmin ) {
            $this->redirect(Yii::app()->createAbsoluteUrl('admin/patients/companymedical', array('patient_id' => $patient_id)));
        }
        else{
            $this->redirect(Yii::app()->createAbsoluteUrl('patients/companymedical', array('patient_id' => $patient_id)));
        }
    }    

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('PatientMedicalInsurrance');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new PatientMedicalInsurrance('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PatientMedicalInsurrance']))
			$model->attributes=$_GET['PatientMedicalInsurrance'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return PatientMedicalInsurrance the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=PatientMedicalInsurrance::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param PatientMedicalInsurrance $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='patient-medical-insurrance-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
