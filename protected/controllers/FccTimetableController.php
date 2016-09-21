<?php

class FccTimetableController extends Controller
{
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionIndex()
    {
        $c        = new CDbCriteria;
        $c->order = 't.order';
        $doctors  = FccDoctor::model()->findAll($c);

        $model = new FccTimetable;
        if (isset($_POST['FccTimetable'])) {
        	$model = $this->loadModel($_POST['FccTimetable']['id']);
            $model->attributes = $_POST['FccTimetable'];
            $model->save();
        	// print_r($_POST['FccTimetable']);
        }
        $c        = new CDbCriteria;
        $c->order = 'id asc';
        $data     = FccTimetable::model()->findAll($c);
        $this->render('index', array(
            'data'     => $data,
            'model'    => $model,
            'daysWeek' => HDateTime::model()->dayOfWeeks2(),
            'doctors'  => $doctors,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return FccTimetable the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = FccTimetable::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param FccTimetable $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'fcc-timetable-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
