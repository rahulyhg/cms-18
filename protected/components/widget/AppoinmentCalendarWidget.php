<?php
class AppoinmentCalendarWidget extends CWidget
{
    public $htmlElementID ;

    public function run()
    {
        $this->showCalendar();
    }
    public function showCalendar()
    {
        //$visit = new Visit('today');
        $notice = new Notice('listData');
        $date = time();
        $appCriteria = new CDbCriteria;
        $appCriteria->order='name';
        $model=Appointment::model()->getAllByDay(date('d'), date('m'));

        $c = new CDbCriteria;
        $c->order='is_default desc, name';
        $doctors=Doctor::model()->findAll($c);

        $blackout=Blackout::model()->findAll();

        $doctorTimes = array();
        $day = date('l');
        $criteria = new CDbCriteria;
        $criteria->compare('day', $day);
        $doctorTime = DoctorTime::model()->findAll($criteria);
        foreach ($doctorTime as $time):
            if ($time->clinic_id > 0) :
                $mClinic = Clinic::model()->findByPK($time->clinic_id);
                $color_code = $mClinic->color_code;
                $color_code2 = $mClinic->color_code2;
                $starttime = date('Y-m-d 08:00:00');
                $endtime = date('Y-m-d 12:30:00');
                if ($time->time == 'PM') {
                    $starttime = date('Y-m-d 13:00:00');
                    $endtime = date('Y-m-d 17:45:00');
                }
                $doctorTimes[] = array('doctor_id'=>$time->doctor_id,'starttime'=> $starttime, 'endtime' => $endtime, 'color_code' => $color_code, 'color_code2' => $color_code2);
            endif;
        endforeach;

		$this->render('AppointmentCalendar', array(
            'date'=>$date,
            'model'=>$model, 'blackout'=>$blackout, 'doctors'=>$doctors,
            'doctorTimes' => $doctorTimes,
        ));
   }
}
?>