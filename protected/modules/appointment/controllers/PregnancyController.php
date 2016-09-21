<?php
class PregnancyController extends AppointmentController
{

    public function actionIndex($dd = null) {
        $model = new FccBooking;
        $model->unsetAttributes();
         // clear any default values
        if (isset($_GET['FccBooking'])) $model->attributes = $_GET['FccBooking'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionBook($step = 1)
    {
        $mBooking = new FccBooking;
        $cd = new CDbCriteria;
        $cd->order = 't.order';
        $doctorList = FccDoctor::model()->findAll($cd);

        $cd = new CDbCriteria;
        $cd->order = 'id asc';
        $doctorTime = FccTimetable::model()->findAll($cd);

        if ($step == 1) {
            if (isset($_POST['FccBooking'])) {
                unset($_SESSION['Booking']);
                $_POST['FccBooking']['lmp'] = HDateTime::formatDate($_POST['FccBooking']['lmp']);
                $_POST['FccBooking']['edd'] = HDateTime::formatDate($_POST['FccBooking']['edd']);
                if ($_POST['FccBooking']['pregnancy_type'] == 0) {
                    $_POST['FccBooking']['edd'] = '';
                }
                $_SESSION['Booking'] = $_POST['FccBooking'];
                $this->redirect(array('pregnancy/book/step/2'));
            }
            if (isset($_SESSION['Booking'])) {
                $booking = $_SESSION['Booking'];
                $mBooking->doctor_selected = $booking['doctor_selected'];
                $mBooking->lmp = date('d-m-Y', strtotime($booking['lmp']));
                $mBooking->edd = date('d-m-Y', strtotime($booking['edd']));
                $mBooking->pregnancy_type = $booking['pregnancy_type'];
                $mBooking->ultrasound_type = $booking['ultrasound_type'];
                $mBooking->procedure = $booking['procedure'];

            }
            $this->render('step1', array(
                'mBooking' => $mBooking,
                'doctorList' => $doctorList,
                'doctorTime' => $doctorTime,
            ));
            return;
        }

        if ($step == 2) {
            $booking = $_SESSION['Booking'];
            // print_r($booking);

            $scanText = '';
            $scantype = 0;
            $additionalweek = 0;
            $additionalendweek = 0;

            if ($booking['ultrasound_type'] != '') {
                $scanText = ' + ' . FccBooking::$ultrasoundType[$booking['ultrasound_type']];
                $additionalweek = FccBooking::$ultrasoundWeek[$booking['ultrasound_type']];
                $additionalendweek = FccBooking::$ultrasoundEndWeek[$booking['ultrasound_type']];
                $scantype = 1;
            } elseif ($booking['procedure'] != '') {
                $scanText = ' + ' . FccBooking::$procedureType[$booking['procedure']];
                $additionalweek = FccBooking::$procedureWeek[$booking['procedure']];
                $additionalendweek = FccBooking::$procedureEndWeek[$booking['procedure']];
                $scantype = 2;
            }

            $lmp = $booking['lmp'];
            $startDate = date('Y-m-d');
            if ($lmp == '' || $additionalweek == 0) {
                $startDate = date('Y-m-d');
            } else {
                $startDate = date('Y-m-d', strtotime('+ ' . (int)$additionalweek . ' weeks', strtotime($lmp)));
            }
            $endDate = date('Y-m-d', strtotime('+7 days', strtotime($startDate)));

            if (isset($_REQUEST['startDate'])) {
                $startDate = date('Y-m-d', strtotime($_REQUEST['startDate']));
                $endDate = date('Y-m-d', strtotime('+7 days', strtotime($startDate)));
            }
            $prev_week = date('Y-m-d', strtotime($startDate . '-7 days'));
            $next_week = date('Y-m-d', strtotime($startDate . '+7 days'));

            if ($additionalweek == 0 || $lmp == '') {
                $startTimeslot = $startDate;
                $endTimeslot = $endDate;
            } else {
                $startTimeslot = date('Y-m-d', strtotime('+ ' . (int)$additionalweek . ' weeks', strtotime($lmp)));
                $endTimeslot = date('Y-m-d', strtotime('+ ' . (int)$additionalendweek . ' weeks', strtotime($lmp)));
                $endTimeslot = date('Y-m-d', strtotime('+ 1 days', strtotime($endTimeslot)));
            }

            $startDate = new DateTime($startDate);
            $endDate = new DateTime($endDate);

            if (isset($_POST['FccBooking'])) {
                $_SESSION['Booking']['fcc_doctor_uuid'] = $_POST['FccBooking']['fcc_doctor_uuid'];
                $_SESSION['Booking']['startDate'] = $_POST['FccBooking']['startDate'];
                $_SESSION['Booking']['startTime'] = $_POST['FccBooking']['startTime'];
                $_SESSION['Booking']['endDate'] = $_POST['FccBooking']['endDate'];
                $_SESSION['Booking']['endTime'] = $_POST['FccBooking']['endTime'];
                $this->redirect(array('pregnancy/book/step/3'));
            }

            $this->render('step2', array(
                'mBooking' => $mBooking,
                'booking' => $booking,
                'scanText' => $scanText,
                'scantype' => $scantype,
                'startTimeslot' => $startTimeslot,
                'endTimeslot' => $endTimeslot,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'prev_week' => $prev_week,
                'next_week' => $next_week,
                'doctorList' => $doctorList,
            ));
            return;

        }

        if ($step == 3) {
            $booking = $_SESSION['Booking'];
            $mBooking->start = date('Y-m-d H:i:s', strtotime($_SESSION['Booking']['startDate'] . ' ' . $_SESSION['Booking']['startTime']));
            $mBooking->end = date('Y-m-d H:i:s', strtotime($_SESSION['Booking']['endDate'] . ' ' . $_SESSION['Booking']['endTime']));

            $mBooking->area_code_id = 229; //Set default area code is Singapore

            if (isset($_POST['FccBooking'])) {
                $_POST['FccBooking']['dob'] = HDateTime::formatDate($_POST['FccBooking']['dob']);
                $_POST['FccBooking']['previous_scan'] = HDateTime::formatDate($_POST['FccBooking']['previous_scan']);
                $_SESSION['Booking'] = array_merge($_POST['FccBooking'], $booking);
                $_SESSION['Booking']['referralDoctor'] = Yii::app()->params['doctorName'];
                $mBooking->fcc_doctor_uuid = $booking['fcc_doctor_uuid'];
                $mBooking->data = json_encode($_SESSION['Booking']);

                if ($mBooking->save()) {
                    $apiRecord = new APIActiveRecord;
                    $params = array(
                        'uuid' => $mBooking->uuid,
                        'fcc_doctor_uuid' => $mBooking->fcc_doctor_uuid,
                        'data' => $mBooking->data,
                        'updated_date' => $mBooking->updated_date,
                        'start' => $mBooking->start,
                        'end' => $mBooking->end,
                        'is_deleted' => $mBooking->is_deleted,
                        'action' => 'create',
                        'clinic_name' => Yii::app()->params['doctorName'],
                    );
                    $url = '/redbull/uploadFccBooking';
                    $rs = $apiRecord->sentTo65doctor($params, $url);
                    $this->redirect(array('pregnancy/booksuccess/booking_uuid/' . $mBooking->uuid));
                }
            }

            $scanText = '';
            if (!empty($booking['ultrasound_type'])) {
                $scanText = ' ' . FccBooking::$ultrasoundType[$booking['ultrasound_type']];
            } elseif (!empty($booking['procedure'])) {
                $scanText = ' ' . FccBooking::$procedureType[$booking['procedure']];
            }

            $this->render('step3', array(
                'booking' => $booking,
                'mBooking' => $mBooking,
                'scanText' => $scanText,
            ));
            return;
        }
    }

    public function actionBookSuccess($booking_uuid) {
        unset($_SESSION['Booking']);
        $c            = new CDbCriteria;
        $c->compare('uuid', $booking_uuid);
        $booking = FccBooking::model()->find($c);

        $data = json_decode($booking->data);

        $scanText = '';
        $scantype = 0;
        if (!empty($data->ultrasound_type)) {
            $scanText = FccBooking::$ultrasoundType[$data->ultrasound_type];
            $scantype = 1;
        }
        elseif (!empty($data->procedure)) {
            $scanText = FccBooking::$procedureType[$data->procedure];
            $scantype = 2;
        }

        $c            = new CDbCriteria;
        $c->compare('uuid', $booking['fcc_doctor_uuid']);
        $doctor = FccDoctor::model()->find($c);
        $this->render('book_success', array(
            'booking' => $booking,
            'scanText' => $scanText,
            'doctor'    => $doctor,
            'data'  => $data,
        ));
    }

    public function actionMyAppointment() {
        if (!isset(Yii::app()->user_main->id)) throw new CHttpException(404, 'The requested page does not exist.');

        $model = new Booking('search');
        $model->unsetAttributes();

        // clear any default values
        if (isset($_GET['Booking'])) $model->attributes = $_GET['Booking'];

        $this->render('my_appointment', array(
            'model' => $model,
        ));
    }

    public function actionView($id) {
        if (!isset($id)) throw new CHttpException(404, 'The requested page does not exist.');
        $c            = new CDbCriteria;
        $c->compare('uuid', $id);
        $booking = FccBooking::model()->find($c);
        if ($booking === null) throw new CHttpException(404, 'The requested page does not exist.');

        $data = json_decode($booking->data);
        $scanText = '';
        $scantype = 0;
        if (!empty($data->ultrasound_type)) {
            $scanText = FccBooking::$ultrasoundType[$data->ultrasound_type];
            $scantype = 1;
        }
        elseif (!empty($data->procedure)) {
            $scanText = FccBooking::$procedureType[$data->procedure];
            $scantype = 2;
        }

        $c            = new CDbCriteria;
        $c->compare('uuid', $booking['fcc_doctor_uuid']);
        $doctor = FccDoctor::model()->find($c);
        $this->render('viewbooking', array(
            'booking' => $booking,
            'scanText' => $scanText,
            'doctor'    => $doctor,
            'data'  => $data,
        ));
    }


    public function actionViewPopup($id) {
        $this->layout = 'plain';
        $c            = new CDbCriteria;
        $c->compare('uuid', $id);
        $booking = FccBooking::model()->find($c);
        if ($booking === null) throw new CHttpException(404, 'The requested page does not exist.');

        $data = json_decode($booking->data);
        $scanText = '';
        $scantype = 0;
        if (!empty($data->ultrasound_type)) {
            $scanText = FccBooking::$ultrasoundType[$data->ultrasound_type];
            $scantype = 1;
        }
        elseif (!empty($data->procedure)) {
            $scanText = FccBooking::$procedureType[$data->procedure];
            $scantype = 2;
        }

        $c            = new CDbCriteria;
        $c->compare('uuid', $booking['fcc_doctor_uuid']);
        $doctor = FccDoctor::model()->find($c);
        $this->render('viewpopup', array(
            'booking' => $booking,
            'scanText' => $scanText,
            'doctor'    => $doctor,
            'data'  => $data,
        ));
    }

     public function actionPrintBooking($id) {
        $this->layout = 'plain';
        if (!isset(Yii::app()->user_main->id)) throw new CHttpException(404, 'The requested page does not exist.');
        $model = Booking::model()->findByPk($id);
        if ($model === null || $model->fccmember_id != Yii::app()->user_main->id) throw new CHttpException(404, 'The requested page does not exist.');
        $this->render('print_booking', array(
            'mBooking' => $model,
        ));
    }

    public function actionCancelBookingPopUp($id) {
        $this->layout = 'plain';
        $model = FccBooking::model()->findByPk($id);
        if ($model === null) throw new CHttpException(404, 'The requested page does not exist.');
        $c            = new CDbCriteria;
        $c->compare('uuid', $model->fcc_doctor_uuid);
        $doctor = FccDoctor::model()->find($c);
        $data = json_decode($model->data);

        $scanText = '';
        if ($data->ultrasound_type != '') {
            $scanText = FccBooking::$ultrasoundType[$data->ultrasound_type];
        }
        elseif ($data->procedure != '') {
            $scanText = FccBooking::$procedureType[$data->procedure];
        }

        $this->render('cancel_booking_popup', array(
            'model' => $model,
            'doctor' => $doctor,
            'data' => $data,
            'scanText' => $scanText,
        ));
    }

    public function actionCancelBooking($id) {
        $model = FccBooking::model()->findByPk($id);
        if ($model === null) throw new CHttpException(404, 'The requested page does not exist.');
        if (isset($_POST['delete_confirm'])) {
            $model->is_deleted = 1;
            if ($model->save()) {
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
                $this->redirect(array('index'));
            }
        }
        $c            = new CDbCriteria;
        $c->compare('uuid', $model->fcc_doctor_uuid);
        $doctor = FccDoctor::model()->find($c);
        $data = json_decode($model->data);

        $scanText = '';
        if ($data->ultrasound_type != '') {
            $scanText = FccBooking::$ultrasoundType[$data->ultrasound_type];
        }
        elseif ($data->procedure != '') {
            $scanText = FccBooking::$procedureType[$data->procedure];
        }

        $this->render('cancel_booking', array(
            'model' => $model,
            'doctor' => $doctor,
            'data' => $data,
            'scanText' => $scanText,
        ));
    }


    public function actionSuccess() {
        $this->layout = '//layouts/plain';
        $this->render('success', array());
    }

    public function actionTest() {
        print_r(Blackout::checkAppointmentTime(8, "2015-11-24 13:05:00"));
    }

    public function actionGetLmpEdd() {
        if (isset($_REQUEST['date'])) {
        //     LMP = 8 May 2009
        // +1 year = 8 May 2010
        // −3 months = 8 February 2010
        // +7 days = 15 February 2010
            $gest = 24192000;
            $date = strtotime($_REQUEST['date']);
            if ($_REQUEST['getType'] == 'edd') {
                $date = $date+$gest;
            }
            else {
                $date = $date-$gest;
            }
            echo date('d-m-Y',$date);
        }
    }

    public function actionEdd() {
        $mBooking = new FccBooking;
        //     LMP = 8 May 2009
        // +1 year = 8 May 2010
        // −3 months = 8 February 2010
        // +7 days = 15 February 2010
        if (isset($_POST['FccBooking'])) {
            $mBooking->attributes = $_POST['FccBooking'];
            $mBooking->lmp = $_POST['FccBooking']['lmp'];
            $date = strtotime($_POST['FccBooking']['lmp']);
            $date = strtotime('+1 years', $date);
            $date = strtotime('-3 months',$date);
            $date = strtotime('+7 days',$date);
            $mBooking->edd = date('Y-m-d',$date);

        }
        $this->render('edd', array('mBooking'=>$mBooking));
    }
}
