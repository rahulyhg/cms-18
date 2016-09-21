<?php

class AjaxController extends FrontController
{

     //GET DOCTOR TIME TABLE
    public function actionGetDoctorTimeByDay()
    {
        // $_POST['date'] = '2016-03-15';
        // $_POST['doctor_id'] = 12;
        if (isset($_POST['date']) && isset($_POST['doctor_id'])) {
            $date        = $_POST['date'];
            $doctorTimes = array();
            $day         = date('l', strtotime($date));
            $criteria    = new CDbCriteria;
            //$criteria->compare('doctor_id', $_POST['doctor_id']);
            $criteria->compare('day', $day);
            $criteria->order = 'time';
            //$doctor = Doctor::model()->findByPk($_POST['doctor_id']);
            $text = Yii::app()->params['doctorName'] . ': ';

            foreach (DoctorTime::model()->findAll($criteria) as $time):
                if ($time->clinic_id > 0):
                    $mClinic        = Clinic::model()->findByPK($time->clinic_id);
                    $text .=    $mClinic->name.' '.$time->time.' + ';
                endif;
            endforeach;

            echo json_encode(substr($text, 0, strlen($text) - 3));
        }
    }

    public function actionTurnUpAppointment()
    {
        if (isset($_POST['appointment_id']) && isset($_POST['status'])) {
            $model = Appointment::model()->findByPk($_POST['appointment_id']);
            if ($model)
            {
                $model->turn_up = $_POST['status'];
                $model->startDate = $model->timeslot->start;
                $model->endDate = $model->timeslot->end;
                $model->startTime_show =  date("H:i A", strtotime($model->timeslot->start));
                $model->endTime_show =  date("H:i A", strtotime($model->timeslot->end));
                if (!$model->save(array('turn_up')))
                {
                    var_dump($model->getErrors());
                }
                if ($model->patient_id != '')
                {
                    $patientInfo = Patient::model()->findByPk($model->patient_id);
                    $queue = new Queue('create');
                    $queue->time_in = date("H:i");
                    $queue->seen = 0;
                    $queue->dispense = 0;
                    $queue->patient_name = $patientInfo->name;
                    $queue->patient_id = $patientInfo->id;
                    $queue->bill = 0;
                    $queue->paid = 0;
                    $queue->doctor_id = Yii::app()->user->id;
                    $queue->save();
                    echo 1;
                    exit;
                }
            }
        }
        echo 0;
    }


    //AJX FUNCTIONS FOR ADD APPOINTMENT ==================================================
    public function actionCheckBlackoutDate()
    {
        if (isset($_REQUEST['doctor_id']) && isset($_REQUEST['starttime']) && isset($_REQUEST['endtime'])) {
            $starttime      = date('Y-m-d H:i',strtotime($_REQUEST['starttime']));
            $endtime      = date('Y-m-d H:i',strtotime($_REQUEST['endtime']));
            $doctor_id = $_REQUEST['doctor_id'];
            $hasLeave  = Blackout::model()->getLeaveBlackoutByDate($doctor_id, $starttime, $endtime);
            echo $hasLeave;
        }
    }
    
    public function actionCheckNotWorkingDate()
    {
        if (isset($_REQUEST['doctor_id']) && isset($_REQUEST['date'])) {
            $notworking_status = DoctorTime::model()->checkNotWorkingDate($_REQUEST['doctor_id'], $_REQUEST['date']);
            echo $notworking_status;
        }
    }

    public function actionBlackOutCheckExistTime()
    {
        if (isset($_REQUEST['type'])) {
            switch ($_REQUEST['type']) {
                case 'holiday':
                    $starttime      = $_REQUEST['starttime'];
                    $endtime      = $_REQUEST['endtime'];
                    $isExist   = Blackout::model()->checkHolidayTime($starttime,$endtime);
                    break;
                case 'leave':
                    $doctor_id = $_REQUEST['doctor_id'];
                    $starttime      = $_REQUEST['starttime'];
                    $endtime      = $_REQUEST['endtime'];
                    $isExist   = Blackout::model()->checkLeaveTime($doctor_id,$starttime,$endtime);
                    break;
                case 'time':
                    $doctor_id = $_REQUEST['doctor_id'];
                    $starttime      = $_REQUEST['starttime'];
                    $endtime      = $_REQUEST['endtime'];
                    $isExist   = Blackout::model()->checkBlackOutTime($doctor_id,$starttime,$endtime);
                    break;
                case 'covering':
                    $doctor_id = $_REQUEST['doctor_id'];
                    $covering_id = $_REQUEST['covering_id'];
                    $updateid = $_REQUEST['updateid'];
                    $starttime      = $_REQUEST['starttime'];
                    $endtime      = $_REQUEST['endtime'];
                    $isExist   = Blackout::model()->checkCoveringTime($doctor_id,$covering_id,$starttime,$endtime,$updateid);
                    break;

                default:
                    $isExist = 0;
                    break;
            }
            echo $isExist;
        }
    }
    
    public function actionCheckExistTime()
    {
        // $_REQUEST['doctor_id'] = 12;
        // $_REQUEST['date'] = '2016-03-16';
        // $_REQUEST['time'] = '15:20:00';
        // $_REQUEST['update_id'] = 130;

        if (isset($_REQUEST['doctor_id']) && isset($_REQUEST['date']) && isset($_REQUEST['time'])) {
            $date      = date('Y-m-d', strtotime($_REQUEST['date']));
            $time      = $_REQUEST['time'];
            $doctor_id = $_REQUEST['doctor_id'];
            $update_id = isset($_REQUEST['update_id']) ? $_REQUEST['update_id'] : 0;
            $isExist   = Appointment::model()->checkExistTime($doctor_id, $date, $time, $update_id);
            echo 0;
        }
    }

    //AJAX FUNCTIONS FOR CALENDAR ===========================================================
    public function actionGetMonthEvent()//For month calendar
    {
        if (isset($_POST['month']) && isset($_POST['year']) && isset($_POST['doctor_id'])) {
            $month      = $_POST['month'];
            $year       = $_POST['year'];
            $doctor_id  = $_POST['doctor_id'];
            $dateList   = Appointment::getAppointmentDateList($month,$year);
            $sumaryList = array();
            foreach ($dateList as $date) {
                $sumaryList[] = Appointment::countAppointmentByDate($doctor_id, $date);
            }
            echo json_encode($sumaryList);
        }
    }
    public function actionGetWeekEvent() {//For week calendar
        if (isset($_POST['date']) && isset($_POST['doctor_id'])) {
            $date      = $_POST['date'];
            $doctor_id = $_POST['doctor_id'];
            $month     = date('m', strtotime($date));
            $model     = Appointment::model()->getAppointmentByWeek($date, $month, $doctor_id);
            $eventList = array();
            if (!empty($model)) {
                $eventList = $this->getAppointmentEvents($model);
            }
            echo json_encode($eventList);
        }

    }
    public function actionGetDayEvent() {//For day calendar
        // $_POST['date'] = '2016-03-15';
        // $_POST['doctor_id'] = 12;
        if (isset($_POST['date']) && isset($_POST['doctor_id'])) {
            $date      = $_POST['date'];
            $doctorId  = $_POST['doctor_id'];
            $model     = Appointment::model()->getAppointmentByDate($date, $doctorId);
            $eventList = array();
            if (!empty($model)) {
                $eventList = $this->getAppointmentEvents($model);
            }
            echo json_encode($eventList);
        }

    }
    
    public function getAppointmentEvents($model) {
        $eventList = array();
        foreach ($model as $event):
            $eventItem        = array();
            $eventFullComment = HString::correctCalendarText($event->comments);
            $eventComment     = HString::correctCalendarText($eventFullComment);
            $eventName        = HString::correctCalendarText($event->patient_name);
            $eventContact     = '(+'. AreaCode::model()->findByPk($event->area_code_id)->area_code.') '.HString::correctCalendarText($event->patient_mobile);
            $eventFullComment != '' ? ' - Comments: ' . $eventFullComment : '';
            $eventItem['start']     = date('Y-m-d\TH:i:s', strtotime($event->timeslot->start));
            $eventItem['end']       = date('Y-m-d\TH:i:s', strtotime($event->timeslot->end));
            $hightligthClass        = $event->visit_reason == 1 ? ' visit-highlight ' : '';
            $eventItem['className'] = $hightligthClass . ' appt';
            $eventItem['resources'] = $event->doctor_id;
            if ($event->from_api == 0) {
                $visitReason = Appointment::$visit_reason[$event->visit_reason] . ($event->visit_reason_text != '' ? ': ' . $event->visit_reason_text : '');
                if (!$event->is_operation) {
                    $eventItem['title']     = $eventName . ' #' . $eventContact . '. ' . ($event->is_new_patient == 0 ? 'New Patient' : 'Existing Patient').'. '.$visitReason;
                    $eventItem['description'] = $eventName . '. ' . 'Contact: ' . $eventContact . '. ' . $visitReason . '. ' . 'Comments: ' . $eventFullComment . '. ' . ($event->is_new_patient == 0 ? 'This is a New Patient' : 'This is a Existing Patient');
                }
                else {
                    // $nric               = $event->nric != '' ? 'NRIC: ' . $event->nric : '';
                    $admission_hospital = $event->operation->admission_hospital != '' ? ' Admission Hospital: ' . $event->operation->admission_hospital . '.' : '';
                    $where_in_hospital  = $event->operation->where_in_hospital != '' ? ' Where in Hospital: ' . $event->operation->where_in_hospital . '.' : '';
                    $bed_type           = $event->operation->bed_type != '' ? ' Bed type: ' . $event->operation->bed_type . '.' : '';
                    $anaesthesia_type   = $event->operation->anaesthesia_type != '' ? ' Type of anaesthesia: ' . $event->operation->anaesthesia_type . '.' : '';
                    $anaesthetist       = $event->operation->anaesthetist != '' ? ' Anaesthetist doctor: ' . $event->operation->anaesthetist : '';
                    $preparation        = $event->operation->preparation != '' ? ' Preparation: ' . $event->operation->preparation . '.' : '';
                    $admission_hospital = $event->operation->admission_hospital != '' ? ' Admission Hospital: ' . $event->operation->admission_hospital . '.' : '';
                    $surgical_assistant = $event->operation->surgical_assistant != '' ? ' Surgical Assistant: ' . $event->operation->surgical_assistant . '.' : '';
                    $operation_type     = $event->operation->operation_type != '' ? ' Type: ' . ($event->operation->operation_type == 'in' ? Yii::t('model', 'In Patient') : Yii::t('model', 'Day Surgery')) . '.' : '';
                    $eventItem['title']     = '[Operation] '.$eventName . ' #' . $eventContact . '. ' . ($event->is_new_patient == 0 ? 'New Patient' : 'Existing Patient');
                    $eventItem['description'] = '[Operation]' . $eventName . '. Contact: ' . $eventContact . '. ' . $admission_hospital . $where_in_hospital . $bed_type . $anaesthesia_type . $anaesthetist . $preparation . $admission_hospital . $surgical_assistant . $operation_type;
                }

                $eventItem['fullTitle']       = $eventItem['description'];
                $eventItem['url']             = Yii::app()->createUrl('appointment/site/update', array(
                    'id' => $event->id,
                ));
            }
            else {
                $eventItem['title']     = '[65doctor] '. $eventName . ' #' . $eventContact . '. ' . ($event->is_new_patient == 0 ? 'New Patient' : 'Existing Patient');
                $eventItem['description'] = '[65doctor] '. $eventName . '. ' . 'Contact: ' . $eventContact . '. ' . 'Comments: ' . $eventFullComment . '. ' . ($event->is_new_patient == 0 ? 'This is a New Patient' : 'This is a Existing Patient');
                $eventItem['fullTitle']       = '[65doctor] '. $eventItem['description'];
                $eventItem['url'] = '#';
            }
            $eventItem['allDay']          = false;
            $eventItem['backgroundColor'] = 'none';

            $eventList[]                  = $eventItem;
        endforeach;
        return $eventList;
    }

    //For blackout events
    public function actionGetDoctorLeaveByDoctor()//Get doctor leave event
    {
        if (isset($_POST['doctor_id'])) {
            $doctor_id   = $_POST['doctor_id'];
            $blackout    = Blackout::model()->getLeaveBlackout($doctor_id);
            $leaveEvents = array();
            foreach ($blackout as $e) {
                $leaveEvents[] = array(
                    'start' => $e->start,
                    'end' => date('Y-m-d', strtotime('+1 day', strtotime($e->end))),
                    'title' => 'Leave: ' . $e->comments,
                    'type' => 'leave',
                    'url' => Yii::app()->createAbsoluteUrl('/blackout/update',array('id'=>$e->id)),
                );
            }
            echo json_encode($leaveEvents);
        }
    }

    public function actionGetCommonBlackout() {//Get common black out | Holiday   Other
        $blackout    =  Blackout::model()->getCommonBlackout();
        $events = array();
        foreach ($blackout as $e) {
            $events[] = array(
                'start' => $e->start,
                'end' => date('Y-m-d', strtotime('+1 day', strtotime($e->end))),
                'title' => ($e->type == 'holiday' ? 'Holiday: ' : 'Other') . $e->comments ,
                'type' => $e->type,
                'url' => Yii::app()->createAbsoluteUrl('/blackout/update',array('id'=>$e->id)),
            );
        }

        $c = new CDbCriteria;
        $c->compare('from_office',0);
        $c->order = 'start desc';
        $notice = Notice::model()->findAll($c);
        foreach ($notice as $e) {
            $events[] = array(
                'start' => $e->start,
                'end' => date('Y-m-d', strtotime('+1 day', strtotime($e->end))),
                'title' => 'Notice: '. $e->title,
                'type' => 'notice',
                'url' => Yii::app()->createAbsoluteUrl('/notice/update',array('id'=>$e->id)),
            );
        }
        //Notice
        echo json_encode($events);
    }
    
    
    //Notice board
    public function actionLoadNoticeBoard() {
        if (isset($_POST['date'])) {
            $date = $_POST['date'];
            $c = new CDbCriteria;
            $c->addCondition('(:date >= date(start) and :date <= date(end))');
            $c->params = array(
                ':date'=> date('Y-m-d', strtotime($date)),
            );
            $c->order = 'start asc';
            $notice = Notice::model()->findAll($c);
            $rs = array();
            foreach ($notice as $nt) {
                $rs[] = array(
                    'id' => $nt->id,
                    'title' => $nt->title,
                    'content' => $nt->content,
                );
            }
            echo json_encode($rs);
        }
    }

    //Because PHP of 65doctor is php 5.2

    public function actionGetBookingTimeslot() {
        //Check from 65doctor
        $apiRecord = new APIActiveRecord;
        $params    = array(
            'startDate'  => $_POST['startDate'],
            'endDate' => $_POST['endDate'],
            'doctor_uuid' => $_POST['doctor_uuid'],
        );
        $url = '/redbull/getBookingTimeslot';
        $tiemslotData = $apiRecord->sentTo65doctor($params,$url);
        echo json_encode($tiemslotData);

    }

    public  function actionCancelAppointment() {
        if (isset($_POST['id'])) {
            $model = FccBooking::model()->findByPk($_POST['id']);
            $model->is_deleted = 1;
            if ($model->save()) {
                $apiRecord = new APIActiveRecord;
                $apiRecord = new APIActiveRecord;
                $params    = array(
                    'uuid'  => $model->uuid,
                    'fcc_doctor_uuid' => $model->fcc_doctor_uuid,
                    'data' => $model->data,
                    'updated_date' => $model->updated_date,
                    'start' => $model->start,
                    'end' => $model->end,
                    'is_deleted' => $model->is_deleted,
                    'action' => 'cancel',
                    'clinic_name' => Yii::app()->params['doctorName'],
                );
                $url = '/redbull/uploadFccBooking';
                $rs = $apiRecord->sentTo65doctor($params,$url);
                echo 'Success';
            }
            else echo 'Fail';
        }
    }

    public function actionChangeClinicName() {
        Yii::app()->settings->setDbItem('clinic_name', $_REQUEST['name']);
        echo json_encode(Yii::app()->settings->getItem('clinic_name'));
    }
}
