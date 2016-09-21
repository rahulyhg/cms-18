<?php

class StaticBlockController extends AdminController
{
	public function actionCreate()
	{
        try {
            $model = new StaticBlock('create');
            if (isset($_POST['StaticBlock'])) {
                $model->attributes = $_POST['StaticBlock'];
                if($model->save())
                    $this->redirect(array('index'));
            }
            $this->render('create', array(
                'model' => $model,
                'actions' => $this->listActionsCanAccess,
            ));
        }catch (exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException("Exception " . print_r($e->getMessage(), true));
        }
	}

	public function actionDelete()
	{
		$this->render('delete');
	}

	public function actionIndex()
	{
        try {
            $model = new StaticBlock('search');
            if(isset($_GET['StaticBlock'])){
                $model->attributes=$_GET['StaticBlock'];
            }
            $this->render('index', array(
                'model'     => $model,
                'actions'   => $this->listActionsCanAccess,
            ));
        } catch (Exception $e) {
            Yii::log("Exception ".  print_r($e, true), 'error');
            throw  new CHttpException("Exception ".  print_r($e, true));
        }
	}

	public function actionUpdate($id)
	{
        $model=$this->loadModel($id);
        if(isset($_POST['StaticBlock']))
        {
            $model->attributes=$_POST['StaticBlock'];
            $model->save();
            $this->redirect(array('index'));
        }
        //$model->beforeRender();
        $this->render('update',array(
            'model' => $model,
            'actions' => $this->listActionsCanAccess,
        ));
	}

	public function actionView($id)
	{
        try {
            $model = StaticBlock::model()->findByPk($id);
            $this->render('view', array(
                'model'=> $model,
                'actions' => $this->listActionsCanAccess,
            ));
        } catch (Exception $exc) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
	}

	public function loadModel($id)
	{
        $model=StaticBlock::model()->findByPk($id);
        if($model===null)
                throw new CHttpException(404,'The requested page does not exist.');
        return $model;
	}
}