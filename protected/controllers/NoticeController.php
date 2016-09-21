<?php

class NoticeController extends Controller
{

	public function actionIndex() {
		$c = new CDbCriteria;
        $c->compare('from_office',0);
        $c->order = 'start desc';
        $notice = Notice::model()->findAll($c);
		$this->render('index', array(
            'notice'=>$notice,
        ));
	}

	public function actionCreate()
	{

        $model=new Notice;
        if (isset($_POST['Notice'])) {
            $model->setAttributes($_POST['Notice'], false);
            $model->created=time();
            $model->user_id = Yii::app()->user->id;
            $model->startDate = $_POST['Notice']['startDate'];
            $model->endDate = $_POST['Notice']['endDate'];
            $model->start = date('Y-m-d', strtotime($model->startDate)). ' 00:00:00';
            $model->end = date('Y-m-d', strtotime($model->endDate)). ' 23:59:59';
            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }

        $this->render('create',array('model'=>$model));
	}

	public function actionUpdate($id)
	{
        $model= Notice::model()->findByPk($id);

        if (isset($_POST['Notice'])) {
            $model->setAttributes($_POST['Notice'], false);
            $model->created=time();
            $model->user_id = Yii::app()->user->id;
            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }
        $model->startDate = date('l M j, Y', strtotime($model->start));
        $model->endDate = date('l M j, Y', strtotime($model->end));

        $this->render('create',array('model'=>$model));
	}

    public function actionToggle() {
        $model=new Notice;
        if (isset($_POST['Notice'])) {
            $model=Notice::model()->findByPk($_POST['Notice']['id']);
            if ($model) {
                $model->saveAttributes(array('completed'=>$model->completed?0:1));
            }
        }
        $this->layout='blank';
        $this->render('_noticeboard',array('notice'=>$model));
    }

	public function actionDelete($id)
	{
        Notice::model()->deleteByPk($id);
		$this->redirect(array('notice/index'), true);
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}