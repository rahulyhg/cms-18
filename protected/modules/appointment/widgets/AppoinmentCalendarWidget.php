<?php
class AppoinmentCalendarWidget extends DWidget
{
    public $htmlElementID ;

    public function registerClientFiles()
    {
        $clientScript = Yii::app()->clientScript;
        $assets = $this->getAssets();
        $base_url = Yii::app()->theme->baseUrl;

        $clientScript->registerCssFile($base_url . '/css/jquery-ui-1.10.3.custom.min.css');
        $clientScript->registerCssFile($base_url . '/css/jquery-ui.css');
        $clientScript->registerCssFile($base_url . '/js/fullcalendar/fullcalendar.css');
        $clientScript->registerCssFile($base_url . '/css/jquery.ui.timepicker.css');
        $clientScript->registerScriptFile($base_url . '/js/jquery-ui.custom.min.js', CClientScript::POS_END);
        $clientScript->registerScriptFile($base_url . '/js/jquery.ui.timepicker.js', CClientScript::POS_END);
        $clientScript->registerScriptFile($base_url. '/js/moment.min.js', CClientScript::POS_END);
        $clientScript->registerScriptFile($base_url . '/js/fullcalendar/fullcalendar.js', CClientScript::POS_END);
        $clientScript->registerScriptFile($base_url . '/js/jquery.multiselect.min.js', CClientScript::POS_END);
        $clientScript->registerScriptFile($base_url . '/scripts/fixcalendar.js', CClientScript::POS_END);

        $clientScript->registerScriptFile("{$assets}/scripts/calendar.js", CClientScript::POS_END);
        
        $clientScript->registerScriptFile("{$assets}/scripts/addappointment.js", CClientScript::POS_END);

    }

    function init () {
        parent::init();
        $this->registerClientFiles();
    }


    public function run()
    {
        $this->showCalendar();
    }
    public function showCalendar()
    {
        $date = time();
        $c = new CDbCriteria;
        $c->order = 'is_default desc, name';
        $doctors = Doctor::model()->findAll($c);
		$this->render('AppointmentCalendar', array(
            'date'=>$date,
            'doctors'=>$doctors,
        ));
    }
}
?>