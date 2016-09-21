<?php

class VisitController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
//			'accessControl', // perform access control for CRUD operations
//			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
//			array('allow',  // allow all users to perform 'index' and 'view' actions
//				'actions'=>array('index','view'),
//				'users'=>array('*'),
//			),
//			array('allow', // allow authenticated user to perform 'create' and 'update' actions
//				'actions'=>array('create','update'),
//				'users'=>array('@'),
//			),
//			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//				'actions'=>array('admin','delete'),
//				'users'=>array('admin'),
//			),
//			array('deny',  // deny all users
//				'users'=>array('*'),
//			),
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
		$model=new Visit;

		if(isset($_POST['Visit']))
		{
            $patient = null;
            $appointment = null;

            if (!empty($_POST['Visit']['patient_id'])) {
                $patient = Patient::model()->findByPk($_POST['Visit']['patient_id']);
            }
            else if (!empty($_POST['Visit']['appointment_id'])) {
                $appointment = Appointment::model()->findByPk($_POST['Visit']['appointment_id']);
                if ($appointment) {
                    if (!empty($appointment->patient))
                        $patient = $appointment->patient;
                    else {
                        Yii::app()->session['visit_name'] = $appointment->name;
                        Yii::app()->session['appointment_id'] = $appointment->event_id;
                        if (!empty($_POST['Visit']['time_in'])) {
                            Yii::app()->session['visit_timein'] = $_POST['Visit']['time_in'];
                        }
                        else {
                            Yii::app()->session['visit_timein'] = date('h:i');
                        }
                        $this->redirect(array('patient/create'),true);
                    }
                    $model->appointment_id = $appointment->id;
                    $model->walkin = 0;
                }
                else {
                    $model->walkin = 1;
                }
            }
            else {
                if (!empty($_POST['Visit']['time_in'])) {
                    Yii::app()->session['visit_timein'] = $_POST['Visit']['time_in'];
                }
                else {
                    Yii::app()->session['visit_timein'] = date('h:i');
                }

                if (!empty($_POST['patient'])) {
                    Yii::app()->session['visit_name'] = $_POST['patient'];
                }
                $this->redirect(array('patient/create'),true);
            }

            if ($patient) {
                $model->time_in = date('Y-m-d').' '.$_POST['Visit']['time_in'];
                $model->patient_id = $patient->id;
                if ($model->save()) {
                    $this->redirect(array('site/index'), true);
                }
                else {
                    $model->time_in = $_POST['Visit']['time_in'];
                }
            }
		}

        // patient list
        $_POST['patient'] = '';
        $patients = Patient::model()->findAll();
		$this->render('create',array(
			'model'=>$model,
            'patientlist'=>$patients,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
        $model->timein = date('H:i', strtotime($model->time_in));

        $this->performAjaxValidation($model);

		if(isset($_POST['Visit']))
		{
			$model->attributes=$_POST['Visit'];
            $model->time_in = date('Y-m-d').' '.$_POST['Visit']['timein'];
			if($model->save())
				$this->redirect(array('/site'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

    public function actionBill($id) {
        $model=$this->loadModel($id);
        $this->performAjaxValidation($model);

        if(isset($_POST['Visit']))
        {
            $model->attributes=$_POST['Visit'];
            if (isset($_POST['complete'])) {
                $model->status='complete';
            }
            else {
                $model->status='billed';
            }
            if($model->save()) {
                $this->redirect(array('/site'));
            }

        }

        $this->render('bill',array(
            'model'=>$model,
        ));
    }

    public function actionNote($id) {
        $model=$this->loadModel($id);
        $this->performAjaxValidation($model);

        if(isset($_POST['Visit']))
        {
            $model->attributes=$_POST['Visit'];
            if($model->save()) {
                $this->redirect(array('/site'));
            }

        }

        $this->render('note',array(
            'model'=>$model,
        ));
    }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Visit');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Visit('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Visit']))
			$model->attributes=$_GET['Visit'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Visit the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Visit::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Visit $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='visit-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
