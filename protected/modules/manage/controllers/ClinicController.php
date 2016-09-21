<?php
class ClinicController extends Controller
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Clinic;
		$this->performAjaxValidation($model);

		if(isset($_POST['Clinic']))
		{
			$model->attributes=$_POST['Clinic'];

            $model->code = substr(md5(time()),0, 10);
            $model->salt = Controller::generateRandomString(15);

            if($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('message', 'New clinic has been created.'));
                $this->redirect(array('index'));
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
	public function actionUpdate($id)
	{
		if(isset($_POST['Clinic']))
		{
            $model=$this->loadModel($_POST['Clinic']['id']);
            if (!$model) {
                Yii::app()->user->setFlash('error', Yii::t('error', 'Clinic not found.'));
                $this->redirect(array('index'), true);
                return;
            }

            $this->performAjaxValidation($model);
            $model->attributes=$_POST['Clinic'];
			if($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('message', 'Clinic has been updated.'));
				$this->redirect(array('index'));
            }
		}
        else {
            $model=$this->loadModel($id);
            if (!$model) {
                Yii::app()->user->setFlash('error', Yii::t('error', 'Clinic not found.'));
                $this->redirect(array('index'), true);
                return;
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
	public function actionDelete($id)
	{
        if(isset($_POST['Clinic']))
        {
            $model=$this->loadModel($_POST['Clinic']['id']);
            if (!$model) {
                Yii::app()->user->setFlash('error', Yii::t('error', 'Clinic not found.'));
                $this->redirect(array('index'), true);
                return;
            }

            if ($model->delete()) {
                // todo: delete related data

                Yii::app()->user->setFlash('success', Yii::t('message', 'Clinic has been deleted.'));
                $this->redirect(array('index'));
            }
        }
        else {
            $model=$this->loadModel($id);
            if (!$model) {
                Yii::app()->user->setFlash('error', Yii::t('error', 'Clinic not found.'));
                $this->redirect(array('index'), true);
                return;
            }
        }

        $this->render('delete',array(
            'model'=>$model,
        ));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $model=new Clinic('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Clinic']))
            $model->attributes=$_GET['Clinic'];

        $this->render('index',array(
            'model'=>$model,
        ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Doctor the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Clinic::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Doctor $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='clinic-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
