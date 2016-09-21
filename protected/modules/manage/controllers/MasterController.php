<?php
class MasterController extends Controller
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
			'postOnly + delete', // we only allow deletion via POST request
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
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		if(isset($_POST['Master']))
		{
            $model=$this->loadModel($_POST['Master']['id']);
            if (!$model) {
                $this->redirect(array('site/index'), true);
                return;
            }

            $this->performAjaxValidation($model);
            $model->attributes=$_POST['Master'];
			if($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('message', 'Item has been updated.'));
				$this->redirect(array($model->type=='race'?'races':($model->type=='language'?'languages':($model->type=='religion'?'religions':'referrings'))));
            }
		}
        else {
            $model=$this->loadModel($id);
            if (!$model) {
                $this->redirect(array('site/index'), true);
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
        $model = $this->loadModel($id);
        if ($model->delete()) {
            $this->redirect(array($model->type=='race'?'races':($model->type=='language'?'languages':($model->type=='religion'?'religions':'referrings'))));
        }
	}

	/**
	 * Lists all models.
	 */
	public function actionRaces()
	{
        if(isset($_POST['Master']))
        {
            $race = new Master;
            $race->type = 'race';
            $race->value=$_POST['Master']['value'];

            if($race->save()) {
                Yii::app()->user->setFlash('success', Yii::t('message', 'New race has been created.'));
                $this->redirect(array('races'));
            }
        }

        $model=new Master('search');
        $model->type = 'race';

        $this->render('index',array(
            'model'=>$model,
        ));
	}

    public function actionReligions()
    {
        if(isset($_POST['Master']))
        {
            $race = new Master;
            $race->type = 'religion';
            $race->value=$_POST['Master']['value'];

            if($race->save()) {
                Yii::app()->user->setFlash('success', Yii::t('message', 'New religion has been created.'));
                $this->redirect(array('religions'));
            }
        }

        $model=new Master('search');
        $model->type = 'religion';

        $this->render('index',array(
            'model'=>$model,
        ));
    }

    public function actionLanguages()
    {
        if(isset($_POST['Master']))
        {
            $race = new Master;
            $race->type = 'language';
            $race->value=$_POST['Master']['value'];

            if($race->save()) {
                Yii::app()->user->setFlash('success', Yii::t('message', 'New language has been created.'));
                $this->redirect(array('languages'));
            }
        }

        $model=new Master('search');
        $model->type = 'language';

        $this->render('index',array(
            'model'=>$model,
        ));
    }

    public function actionReferrings()
    {
        if(isset($_POST['Master']))
        {
            $race = new Master;
            $race->type = 'referring';
            $race->value=$_POST['Master']['value'];

            if($race->save()) {
                Yii::app()->user->setFlash('success', Yii::t('message', 'New referring has been created.'));
                $this->redirect(array('referrings'));
            }
        }

        $model=new Master('search');
        $model->type = 'referring';

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
		$model=Master::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='master-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
