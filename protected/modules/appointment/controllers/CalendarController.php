<?php
class CalendarController extends AppointmentController
{
	public function actionIndex()
	{
		$modelSearch = new Appointment('search');
        $model = new Appointment;
        $modelOperation = new Operation;
        $model->area_code_id = 229; //Set default area code is Singapore
        $c = new CDbCriteria;
        $c->order = 'name';
        $cd = new CDbCriteria;
        $cd->order = 'is_default desc, name';
        $doctorList = Doctor::model()->findAll($cd);
        if (!empty($d)) {
            $model->startDate = Date('D M d, Y', $d);
            $model->endDate = Date('D M d, Y', $d);
        } else {
            $model->startDate = Date('D M d, Y');
            $model->endDate = Date('D M d, Y');
        }

        if (!empty($t)) {
            $model->startTime = $t;
            $model->endTime = date('H:i', strtotime($t) + (15 * 60));
            $model->startTime_show = date('h:i A', strtotime($model->startTime.':00'));
            $model->endTime_show = date('h:i A', strtotime($model->endTime));
        }

        if (!empty($doctor)) {
            $model->doctor_id = $doctor;
        }

		$this->render('index', array(
			'modelSearch' => $modelSearch,
            'model' => $model,
            'modelOperation' => $modelOperation,
            'doctorList' => $doctorList,
		));

	}

}