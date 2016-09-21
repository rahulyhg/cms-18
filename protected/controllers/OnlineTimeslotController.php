<?php

class OnlineTimeslotController extends Controller
{

    public function actionIndex()
    {
        $model = new FccDoctor('search');
        $model->unsetAttributes();
        // clear any default values
        if (isset($_GET['Doctor'])) {
            $model->attributes = $_GET['Doctor'];
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionEditTimeSlot($doctor_id)
    {
        $model = FccDoctor::model()->findByPk($doctor_id);
        $this->render('timslot_template', array(
            'model' => $model,
        ));
    }

    public function actionSaveTemplate()
    {
        if (isset($_POST['doctor_id']) && isset($_POST['data'])) {
            $doctor_id    = $_POST['doctor_id'];
            $timeslotData = $_POST['data'];
            $c            = new CDbCriteria;
            $c->compare('fcc_doctor_uuid', $doctor_id);
            $model = FccTimeslotTemplate::model()->find($c);
            if ($model === null) {
                $model                  = new FccTimeslotTemplate;
                $model->fcc_doctor_uuid = $doctor_id;
            }
            $model->data = $timeslotData;
            if ($model->save()) {
                $apiRecord = new APIActiveRecord;
                $params    = array(
                	'uuid'	=> $model->uuid,
                	'fcc_doctor_uuid' => $model->fcc_doctor_uuid,
                	'data' => $model->data,
                	'updated_date' => $model->updated_date,
                );
                $url = '/redbull/updateFccTimeslot';
                $rs = $apiRecord->sentTo65doctor($params,$url);
                echo 1;
                return;
            }
        }
        echo 0;
    }

    public function actionLoadTemplate()
    {
        if (isset($_POST['doctor_id'])) {
            $doctor_id = $_POST['doctor_id'];
            $c         = new CDbCriteria;
            $c->compare('fcc_doctor_uuid', $doctor_id);
            $template = FccTimeslotTemplate::model()->find($c);
            echo $template->data;
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

    }

}
