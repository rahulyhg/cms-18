<?php

class Ajax65doctorController extends Controller {

    public function actionGetDoctorAppointment()
    {

        if (isset($_POST['date']))
        {
            $apiRecord = new APIActiveRecord;
            $date = $_POST['date'];
            $doctorId = $_POST['doctor_id'];
            $_65id = Doctor::model()->findByPk($doctorId)->_65doctor_id;
            $search_params = array(
                "doctor_id" => $_65id,
                "created_from" => '',
                "created_to" => '',
                "appointment_from" => $_POST['date'],
                "appointment_to" => $_POST['date'],
                "patient_name" => '',
                "patient_email" => '',
                "patient_mobile" => '',
                "is_new_patient" => '',
                'pagesize' => '',
                'offset' => '',
            );
            $listBookedApp = $apiRecord->getBookedAppointments($search_params);
            $eventList = array();

            foreach ($listBookedApp as $item)
            {
                $eventItem = array();
                $time = date('H:i', strtotime($item->appointment_datetime));
                $eventItem['title'] = '[65doctor/Microsite] '. $item->patient_name . ' - ' . $item->patient_mobile;
                $eventItem['start'] = date('Y-m-d\TH:i:s', strtotime($item->appointment_datetime));
                $eventItem['end'] = date('Y-m-d\TH:i:s', strtotime($item->appointment_datetime) + (15 * 60));
                $eventItem['className'] = '65appt appt';
                $eventItem['resources'] = $doctorId;
                $eventItem['allDay'] = false;
                $eventItem['backgroundColor'] = 'none';
                $eventItem['url'] = '#';
                $eventList[] = $eventItem;
            }

            echo json_encode($eventList);
        }
    }

    public function actionGetAppointmentByDay()
    {
        if (isset($_POST['date']))
        {
            $apiRecord = new APIActiveRecord;
            $date = $_POST['date'];
            $search_params = array(
                "doctor_id" => '',
                "created_from" => '',
                "created_to" => '',
                "appointment_from" => $date,
                "appointment_to" => $date,
                "patient_name" => '',
                "patient_email" => '',
                "patient_mobile" => '',
                "is_new_patient" => '',
                'pagesize' => '',
                'offset' => '',
            );
            $listBookedApp = $apiRecord->getBookedAppointments($search_params);
            $eventList = array();
            foreach ($listBookedApp as $item)
            {
                $eventItem = array();
                $criteria = new CDbCriteria;
                $criteria->compare('_65doctor_id', $item->doctor_id);
                $mDoctor = Doctor::model()->find($criteria);

                if (isset($mDoctor)) {
                    $time = date('H:i', strtotime($item->appointment_datetime));
                    $eventItem['title'] = '[65doctor/Microsite] ' . $item->patient_name . ' - ' . $item->patient_mobile;
                    $eventItem['start'] = date('Y-m-d\TH:i:s', strtotime($item->appointment_datetime));
                    $eventItem['end'] = date('Y-m-d\TH:i:s', strtotime($item->appointment_datetime) + (15 * 60));
                    $eventItem['className'] = '65appt appt';
                    $eventItem['resources'] = $mDoctor->id;
                    $eventItem['allDay'] = false;
                    $eventItem['backgroundColor'] = 'none';
                    $eventItem['url'] = '#';
                    $eventList[] = $eventItem;
                }
            }
            echo json_encode($eventList);
        }
    }

    public function actionGetAppointmentByWeek()
    {
        if (isset($_POST['date']) && isset($_POST['doctor_id']))
        {
            $date = $_POST['date'];
            $doctor_id = $_POST['doctor_id'];
            $month = date('m', strtotime($date));
            $model = Appointment::model()->getAllByWeekAndDoctorId($date, $month, $doctor_id);
            $eventList = array();
            if (!empty($model))
            {
                //print_r($model);
                foreach ($model as $event):
                    $eventItem = array();
                    $eventFullComment = HString::correctCalendarText($event->comments);
                    $eventComment = HString::correctCalendarText($eventFullComment);
                    $eventName = HString::correctCalendarText($event->name);
                    $eventContact = HString::correctCalendarText($event->contact);
                    $eventFullComment != '' ? ' - Comments: ' . $eventFullComment : '';
                    $eventItem['title'] = $eventName . ' ' . $eventContact . ' ' . $eventFullComment;
                    $eventItem['start'] = date('Y-m-d\TH:i:s', strtotime($event->event->start));
                    $eventItem['end'] = date('Y-m-d\TH:i:s', strtotime($event->event->end));
                    $hightligthClass = $event->event->type == 'appt' ? ($event->visit_reason == 1 ? 'visit-highlight ' : '') : '';
                    $eventClass = $event->event->type == 'appt ' ? '' : '';
                    $eventItem['className'] = $eventClass . $hightligthClass . ' appt';
                    $eventItem['resources'] = $event->event->doctor_id;
                    if ($event->event->type == 'appt')
                    {
                        $eventItem['description'] = $eventName . ' ' . $event->contact . ' - ' . Appointment::$visit_reason[$event->visit_reason] . ' ' . $eventFullComment;
                    }
                    else
                    {
                        $eventItem['description'] = $eventName . ' ' . $event->contact . ' - Operation ' . $eventFullComment;
                    }
                    $eventItem['allDay'] = false;
                    $eventItem['backgroundColor'] = 'none';
                    $eventItem['url'] = Yii::app()->createUrl('appointment/view', array('id' => $event->event_id));
                    $eventList[] = $eventItem;
                endforeach;
            }
            echo json_encode($eventList);
        }
    }

}
