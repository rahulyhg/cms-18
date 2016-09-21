<?php

class GoogleSyncController extends Controller
{

    public $calendar_id;

    function init()
    {
        parent::init();
    }

    public function actionIndex()
    {
        $start   = date(DATE_ATOM, strtotime('2015-07-10'));
        $end     = date(DATE_ATOM, strtotime('2015-07-11'));
        $event   = new Google_Service_Calendar_Event(array(
            'summary' => 'Google I/O 2015',
            'location' => '800 Howard St., San Francisco, CA 94103',
            'description' => 'A chance to hear more about Google\'s developer products.',
            'start' => array(
                'dateTime' => $start,
                'timeZone' => 'Asia/Singapore'
            ),
            'end' => array(
                'dateTime' => $end,
                'timeZone' => 'Asia/Singapore'
            ),
            'colorId' => 2 //colorID 1->11
        ));
        $service = new Google_Service_Calendar($this->client);
        $event   = $service->events->insert($calendar_id, $event);
        print_r($event->getId());
    }

    public function actionRun()
    {
        Yii::app()->background->start(array(
            'googleSync/Syncall/',
            'backjobMethod' => 'POST',
            'backjobPostdata' => array()
        ));

    }

    public function actionSyncAll() {
        $criteria = new CDbCriteria;
        $criteria->addCondition("_65doctor_id <> '' ");
        $doctors = Doctor::model()->findAll($criteria);
        $sync = new GSync($this->client);
        foreach ($doctors as $doctor) {
            $sync->syncBlackOut($doctor->id, $doctor->google_calendar_id);
            $sync->syncAppointments($doctor->id, $doctor->google_calendar_id);
        }

        Yii::app()->end();
    }
}
