<?php

class ImportController extends Controller
{

    public function actionIndex()
    {
        $apiRecord = new APIActiveRecord;
        $params    = array(
            'abc' => 1,
            'test' => 'this is a test',
        );
        $abc       = $apiRecord->test($params);
        print_r($abc);
    }

    public function actionImportBookingBG()
    {
        $doctors = Doctor::model()->findAll();
        foreach ($doctors as $doctor) {
            $jobId = Yii::app()->background->start(array(
                'import/importBooking/',
                'backjobMethod' => 'POST',
                'backjobPostdata' => array(
                    'id' => $doctor->id,
                )
            ));
        }
        $jobId = Yii::app()->background->start(array(
            'import/syncGoogleCalendar/',
        ));
//        $this->actionSyncGoogleCalendar();
    }

    public function actionImportBooking()
    {
//        $_POST['id'] = 12;
        if (isset($_POST['id'])) {
            $id       = $_POST['id'];
            $doctor   = Doctor::model()->findByPk($id);
            $criteria = new CDbCriteria;
            $criteria->compare('doctor_id', $id);
            $bookings  = Appointment::model()->findAll($criteria);
            $notin_ids = '';
            foreach ($bookings as $booking) {
                if ($booking->_65doctor_id != '')
                    $notin_ids .= $booking->_65doctor_id . ',';
            }
            $apiRecord = new APIActiveRecord;
            $params    = array(
                'doctor_id' => $doctor->_65doctor_id,
                'booking_notin_ids' => trim($notin_ids, ",")
            );
            $url = '/redbull/listBookedAppointment';
            $rs        = $apiRecord->sentTo65doctor($params,$url);
            foreach ($rs as $apiBooking) {
                $model                 = new Appointment;
                $model->_65doctor_id             = $apiBooking->booking_id;
                $model->patient_name   = $apiBooking->patient_name;
                $model->patient_email  = $apiBooking->patient_email;
                $model->patient_mobile = $apiBooking->mobile_number;
                $model->area_code_id   = $apiBooking->area_code_id;
                $model->is_new_patient = $apiBooking->is_new_patient;
                $model->doctor_id      = $doctor->id;
                $model->app_time       = $apiBooking->appointment_datetime;

                $timeslot = new Timeslot; // Create new a timeslot for appointment
                $timeslot->doctor_id = $doctor->id;
                $timeslot->start = date('Y-m-d H:i', strtotime($apiBooking->appointment_datetime));
                $timeslot->end = date('Y-m-d H:i', strtotime($apiBooking->appointment_datetime) + (15 * 60));
                $timeslot->from_api      = 1;
                $timeslot->save();
                $model->timeslot_id = $timeslot->id;
                $model->from_api = 1;

                $model->comments         = $apiBooking->remark;
                $model->is_cancelled   = $apiBooking->book_status;
                $model->save();
                UnreadAppointment::addUnreadAppointments($model->id);
            }
            //Update cancelled appointment
            $criteria = new CDbCriteria;
            $criteria->compare('doctor_id', $id);
            $criteria->compare('is_cancelled', 1);
            $bookings  = Appointment::model()->findAll($criteria);
            $notin_ids = '';
            foreach ($bookings as $booking) {
                $notin_ids .= $booking->_65doctor_id . ',';
            }
            $params    = array(
                'doctor_id' => $doctor->_65doctor_id,
                'booking_notin_ids' => trim($notin_ids, ",")
            );
            $url = '/redbull/listCancelledAppointment';
            $rs        = $apiRecord->sentTo65doctor($params,$url);
            foreach ($rs as $apiBooking) {
                $criteria = new CDbCriteria;
                $criteria->compare('id', $apiBooking->booking_id);
                $model  = Appointment::model()->find($criteria);
                $model->is_cancelled   = 1;
                $model->save();
            }
        }
        Yii::app()->end();
    }

    public function actionSyncGoogleCalendar() {
        $criteria = new CDbCriteria;
        $criteria->addCondition("_65doctor_id <> '' ");
        $doctors = Doctor::model()->findAll($criteria);
        $sync = new GSync($this->client);
        foreach ($doctors as $doctor) {
            $sync->syncBlackOut($doctor->id, $doctor->google_calendar_id);
            $sync->syncAppointments($doctor->id, $doctor->google_calendar_id);
            $sync->updateAppointment();
        }
    }
}
