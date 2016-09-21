<?php

class UserController extends Controller
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
		$model=new User;
		$this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
            $model->doctor = 0;

            if (!empty($_POST['User']['password'])) {
                $model->password = md5($_POST['User']['password']);
                $model->password2 = md5($_POST['User']['password2']);
            }

			if($model->save()) {

                Yii::app()->user->setFlash('success', Yii::t('message', 'New user has been created.'));
                $this->redirect(array('index'));
            }
		}

        $model->password = '';
        $model->password2 = '';
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
        if(isset($_POST['User']))
        {
            $model=$this->loadModel($_POST['User']['id']);
            if (!$model) {
                Yii::app()->user->setFlash('error', Yii::t('error', 'User not found.'));
                $this->redirect(array('index'), true);
                return;
            }

            $oldpwd = $model->password;
            $this->performAjaxValidation($model);
            $model->attributes=$_POST['User'];

            if (!empty($_POST['User']['password'])) {
                $model->password = md5($_POST['User']['password']);
                $model->password2 = md5($_POST['User']['password2']);
            }
            else {
                $model->password = $oldpwd;
                $model->password2 = $oldpwd;
            }

            if($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('message', 'User has been updated.'));
                $this->redirect(array('index'));
            }
        }
        else {
            $model=$this->loadModel($id);
            if (!$model) {
                Yii::app()->user->setFlash('error', Yii::t('error', 'User not found.'));
                $this->redirect(array('index'), true);
                return;
            }
        }

        $model->password = '';
        $model->password2 = '';
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
        if(isset($_POST['User']))
        {
            $model=$this->loadModel($_POST['User']['id']);
            if (!$model) {
                Yii::app()->user->setFlash('error', Yii::t('error', 'User not found.'));
                $this->redirect(array('index'), true);
                return;
            }

            if ($model->delete()) {
                Yii::app()->user->setFlash('success', Yii::t('message', 'User has been deleted.'));
                $this->redirect(array('index'));
            }
        }
        else {
            $model=$this->loadModel($id);
            if (!$model) {
                Yii::app()->user->setFlash('error', Yii::t('error', 'User not found.'));
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
        $model=new User('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['User']))
            $model->attributes=$_GET['User'];

        $this->render('index',array(
            'model'=>$model,
        ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
