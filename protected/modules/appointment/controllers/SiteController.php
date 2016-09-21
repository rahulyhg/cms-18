<?php

class SiteController extends AppointmentController
{
	public function actionIndex()
	{
        $this->pageTitle = 'All Appointments - ' . Yii::app()->params['defaultPageTitle'];
        echo "to here";
        die;
        $c = new CDbCriteria;
        $c->with = array(
            'timeslot',
        );
        $c->addCondition("Date(timeslot.start) = '" . date('Y-m-d')."'");
        $c->compare('t.is_deleted', 0);
        $c->order = ' t.id desc';
        $model = Appointment::model()->findAll($c);
        $doctor = Doctor::model()->find();
        $modelSearch = new Appointment('search');
        if (isset($_POST['Appointment'])) {
            $startDate = $_POST['Appointment']['startDate'];
            $endDate = $_POST['Appointment']['endDate'];
            $time = $_POST['Appointment']['time'];
            $modelSearch->setAttributes($_POST['Appointment'], false);
            $modelSearch->doctor_id = $doctor->id;

            if ($startDate == '') $startDate = date('Y-m-d');
            else $startDate = HDateTime::formatDate($startDate);

            if ($endDate == '') {
                $endDate = $startDate;
            }
            else $endDate = HDateTime::formatDate($endDate);

            $modelSearch->startDate = date('Y-m-d', strtotime($startDate));
            $modelSearch->endDate = date('Y-m-d', strtotime($endDate));

            $modelSearch->time = $time;
            $model = Appointment::model()->searchAppointmentForPrint($modelSearch);
            $modelSearch->startDate = date('d-m-Y', strtotime($startDate));
            $modelSearch->endDate = date('d-m-Y', strtotime($endDate));
        }
		$this->render('index', array(
            'model' => $model,
            'modelSearch' => $modelSearch,
            'doctor' => $doctor,
        ));
	}
    
    
    public function actionDeletedAppointment()
	{
        $this->pageTitle = 'Deleted Appointments - ' . Yii::app()->params['defaultPageTitle'];
        $c = new CDbCriteria;
        $c->with = array(
            'timeslot',
        );
        $c->addCondition("Date(timeslot.start) = '" . date('Y-m-d')."'");
        $c->compare('t.is_deleted', 1);
        $c->order = ' t.id desc';
        $model = Appointment::model()->findAll($c);
        $doctor = Doctor::model()->find();
        $modelSearch = new Appointment('search');
        if (isset($_POST['Appointment'])) {
            $startDate = $_POST['Appointment']['startDate'];
            $endDate = $_POST['Appointment']['endDate'];
            $time = $_POST['Appointment']['time'];
            $modelSearch->setAttributes($_POST['Appointment'], false);
            $modelSearch->doctor_id = $doctor->id;

            if ($startDate == '') $startDate = date('Y-m-d');
            else $startDate = HDateTime::formatDate($startDate);

            if ($endDate == '') {
                $endDate = $startDate;
            }
            else $endDate = HDateTime::formatDate($endDate);

            $modelSearch->startDate = date('Y-m-d', strtotime($startDate));
            $modelSearch->endDate = date('Y-m-d', strtotime($endDate));

            $modelSearch->time = $time;
            $model = Appointment::model()->searchAppointmentForPrint($modelSearch);
            $modelSearch->startDate = date('d-m-Y', strtotime($startDate));
            $modelSearch->endDate = date('d-m-Y', strtotime($endDate));
        }
		$this->render('deletedappointment', array(
            'model' => $model,
            'modelSearch' => $modelSearch,
            'doctor' => $doctor,
        ));
	}
    
    public function autoBindPatient(&$model, $patientId)
    {
        $patient = Patient::model()->findByPk((int)$patientId);
            if ($patient) {
                $model->patientId = $patient->reference_no;
                $model->patient_name = $patient->name;
                $model->patient_id = $patient->id;
                if (!empty($patient->contact_number_1)) {
                    $model->patient_mobile = $patient->contact_number_1;
                    $model->area_code_id = $patient->contact_country_1;
                }
                if (!empty($patient->contact_number_2)) {
                    $model->patient_mobile = $patient->contact_number_2;
                    $model->area_code_id = $patient->contact_country_2;
                }
                if (!empty($patient->contact_number_3)) {
                    $model->patient_mobile = $patient->contact_number_3;
                    $model->area_code_id = $patient->contact_country_3;
                }
                $model->patient_email = $patient->contact_email;
            }
    }

    public function actionAddAppointment($d = null, $t = null, $doctor = null)
	{
        $this->pageTitle = 'Add Appointment - ' . Yii::app()->params['defaultPageTitle'];
		$model = new Appointment;
        $modelOperation = new Operation;
		$model->area_code_id = 229; //Set default area code is Singapore
        $patientId = isset($_GET['patient_id']) ? (int) $_GET['patient_id'] : 0;
        
        if (isset($_GET['patient_id']) && !empty($_GET['patient_id'])) {
            
            $this->autoBindPatient($model, (int)$_GET['patient_id']);
            
        }
        $queue = null;
        if (isset($_GET['queue_id']) && !empty($_GET['queue_id'])) {
            $queue = Queue::model()->findByPk((int)$_GET['queue_id']);
            if ($queue) {
                $model->patient_id = $queue->patient_id;
                $model->patient_name = $queue->patient_name;
                $model->startTime = date('h:i A', strtotime($queue->time_in));
                $model->startTime_show = date('h:i A', strtotime($queue->time_in));
                $model->endTime = date('h:i A', strtotime("+15 minutes", strtotime($queue->time_in)));
                $model->endTime_show = date('h:i A', strtotime("+15 minutes", strtotime($queue->time_in)));
                $this->autoBindPatient($model, $queue->patient_id);
            }
        }
        
		$c = new CDbCriteria;
        $c->order = 'name';
        $cd = new CDbCriteria;
        $cd->order = 'is_default desc, name';
        $doctorList = Doctor::model()->findAll($cd);

        if (isset($_POST['Appointment'])) {
            $model->setAttributes($_POST['Appointment'], false);
            $model->startDate = $_POST['Appointment']['startDate'];
            $model->startTime = $_POST['Appointment']['startTime_show'] != '' ? date('H:i',strtotime($_POST['Appointment']['startTime_show'])) : '';
            $model->startTime_show = $_POST['Appointment']['startTime_show'];
           
            $model->endDate = $_POST['Appointment']['endDate'];
            $model->endTime = isset($_POST['Appointment']['endTime_show']) ? date('H:i',strtotime($_POST['Appointment']['endTime_show'])) : '';
            $model->endTime_show = $_POST['Appointment']['endTime_show'];
            $model->doctor_id = Yii::app()->user->id;
            if ($model->validate())
            {
                $timeslot = new Timeslot; // Create new a timeslot for appointment
                $timeslot->doctor_id = $model->doctor_id;
                $timeslot->start = date('Y-m-d H:i:s', strtotime($model->startDate. ' ' . $model->startTime.':00'));
                $timeslot->end = date('Y-m-d H:i:', strtotime($model->endDate. ' ' . $model->endTime.':00'));
                $timeslot->save();
                
                if ($queue)
                {
                    $queue->follow_up = date("d/m/Y H:i A");
                    $queue->update(array('follow_up'));
                }

                $model->timeslot_id = $timeslot->id;
                $model->eventType = $_POST['Appointment']['eventType'];
                if ($model->eventType == 'op') {
                    if (isset($_POST['Operation'])) {
                        $modelOperation->setAttributes($_POST['Operation'], false);
                        $modelOperation->save();
                        $model->operation_id = $modelOperation->id;
                        $model->is_operation = 1;
                        $model->scenario = 'addOperation';
                    }
                }

                if ($model->save()) {
                    $this->redirect(Yii::app()->createAbsoluteUrl("appointment/site"));
                }
            }
        }
        else {
        	if (!empty($d)) {
                $model->startDate = Date('D M d, Y', $d);
                $model->endDate = Date('D M d, Y', $d);

            } else {
                $model->startDate = Date('D M d, Y');
                $model->endDate = Date('D M d, Y');
            }
            if (!empty($t)) {
                $model->startTime = date('h:i A', strtotime($t));
                $model->endTime = date('h:i A', strtotime($t) + (15 * 60));
            } 
            // else {
            //     $model->startTime_show = date('h:00 A',strtotime('+1 hours'));
            //     $model->endTime_show = date('h:i A', strtotime('+ 15 minutes', strtotime($model->startTime_show)));
            // }
            if (!empty($doctor)) {
                $model->doctor_id = $doctor;
            }
        }

		$this->render('addappointment', array(
			'model' => $model,
            'modelOperation' => $modelOperation,
			'doctorList' => $doctorList,
		));

	}

    public function actionUpdate($id) {
        $this->pageTitle = 'Update Appointment - ' . Yii::app()->params['defaultPageTitle'];
        $model = Appointment::model()->findByPk($id);
        $modelOperation = array();
        if ($model->is_operation) {
            $model->eventType = 'op';
            $modelOperation = $model->operation;
        }
        else $model->eventType = 'appt';
        $c = new CDbCriteria;
        $c->order = 'name';
        $cd = new CDbCriteria;
        $cd->order = 'is_default desc, name';
        $doctorList = Doctor::model()->findAll($cd);

        $model->startDate = Date('D M d, Y',strtotime($model->timeslot->start));
        $model->endDate = Date('D M d, Y',strtotime($model->timeslot->end));
        $model->startTime = date('h:i A', strtotime($model->timeslot->start));
        $model->startTime_show = date('h:i A',strtotime($model->timeslot->start));
        $model->endTime = date('h:i A', strtotime($model->timeslot->end));
        $model->endTime_show = date('h:i A',strtotime($model->timeslot->end));
        
        if (isset($_POST['Appointment'])) {
            $old_startTime = $model->timeslot->start;
            $old_endTime = $model->timeslot->end;

            $model->setAttributes($_POST['Appointment'], false);
            $model->startDate = $_POST['Appointment']['startDate'];
            $model->startTime = $_POST['Appointment']['startTime_show'] != '' ? date('H:i',strtotime($_POST['Appointment']['startDate'] . ' ' . $_POST['Appointment']['startTime_show'])): '';
            $model->startTime_show = $_POST['Appointment']['startTime_show'];
            $model->endDate = $_POST['Appointment']['endDate'];
            $model->endTime = $_POST['Appointment']['endTime_show'] != '' ? date('H:i',strtotime($_POST['Appointment']['endDate'] . ' ' . $_POST['Appointment']['endTime_show'])): '';
            $model->endTime_show = $_POST['Appointment']['endTime_show'];
            
            if ($model->validate())
            {
                $timeslot = $model->timeslot;
                $timeslot->start = date('Y-m-d H:i:s', strtotime($model->startDate. ' ' . $model->startTime.':00'));
                $timeslot->end = date('Y-m-d H:i:', strtotime($model->endDate. ' ' . $model->endTime.':00'));
                $timeslot->save();

                if (isset($_POST['Operation'])) {
                    $modelOperation->setAttributes($_POST['Operation'], false);
                    $modelOperation->save();
                }

                if ($model->save()) {
                    $this->redirect(Yii::app()->createAbsoluteUrl("appointment/site"));
    //                $apiRecord = new APIActiveRecord;
    //                $params = array(//Active old TimeSlot
    //                    'doctor_id' => $model->doctor->_65doctor_id,
    //                    'start_time' => $old_startTime,
    //                    'end_time' => $old_endTime,
    //                );
    //                $url = '/redbull/activeTimeSlotStatus';
    //                $apiRecord->sentTo65doctor($params,$url);
    //
    //                $params = array(//DeActive new TimeSlot
    //                    'doctor_id' => $model->doctor->_65doctor_id,
    //                    'start_time' => $model->timeslot->start,
    //                    'end_time' => $model->timeslot->end,
    //                );
    //                $url = '/redbull/deactiveTimeSlotStatus';
    //                $apiRecord->sentTo65doctor($params,$url);

                    // $this->redirect(array('site/view', 'id' => $model->id));
    //                $this->redirect(array('calendar/#' . date('Y-m-d', strtotime($model->startDate)) . '|' . $model->doctor_id . '|' . $model->startTime));
                }
            }
        }


        $this->render('update', array(
            'model' => $model,
            'modelOperation' => $modelOperation,
            'doctorList' => $doctorList,
        ));
    }

    public function actionView($id) {
        $model = Appointment::model()->findByPk($id);
        $modelOperation = array();
        if ($model->is_operation) {
            $modelOperation = $model->operation;
        }
        $model->startDate = Date('D M d, Y',strtotime($model->timeslot->start));
        $model->endDate = Date('D M d, Y',strtotime($model->timeslot->end));
        $model->startTime_show = date('h:i A', strtotime($model->timeslot->start));
        $model->endTime_show = date('h:i A', strtotime($model->timeslot->end));


        $this->render('view', array(
            'model' => $model,
            'modelOperation' => $modelOperation,
        ));
    }

    public function actionDelete($id) {
        $this->pageTitle = 'Delete Appointment - ' . Yii::app()->params['defaultPageTitle'];
        $model = Appointment::model()->findByPk($id);
        $doctor_id = $model->doctor_id;

        if (isset($_POST['Appointment'])) {

            $model->is_deleted = 1;
            if (!$model->update(['is_deleted']))
            {
                var_dump($model->getErrors());
                //die;
            }
                
            $this->redirect(array('/appointment/site'));
        }

        $this->render('delete', array('model' => $model));
    }
    
    public function actionRestore($id) {
        $this->pageTitle = 'Delete Appointment - ' . Yii::app()->params['defaultPageTitle'];
        $model = Appointment::model()->findByPk($id);
        $doctor_id = $model->doctor_id;

        if (isset($_POST['Appointment'])) {

            $model->is_deleted = 0;
            if (!$model->update(['is_deleted']))
            {
                var_dump($model->getErrors());
                //die;
            }
                
            $this->redirect(array('/appointment/site'));
        }

        $this->render('delete', array('model' => $model));
    }

    public function actionNew65doctorAppointment() {
//        $this->layout = '/layouts/plain';

        $criteria=new CDbCriteria;
        $criteria->compare('user_id',Yii::app()->user->id);
        $unread = UnreadAppointment::model()->findAll($criteria);
        $ids = array();
        foreach ($unread as $item) {
            $ids[] = $item->appointment_id;
        }

        $criteria=new CDbCriteria;
        $criteria->compare('id',$ids);
        $model = Appointment::model()->findAll($criteria);

        $this->renderPartial('new65appointment', array(
            'model' => $model,
        ));
    }

    public function actionDeleteUnread65doctorAppointment() {
        $criteria=new CDbCriteria;
        $criteria->compare('user_id',Yii::app()->user->id);
        $unread = UnreadAppointment::model()->deleteAll($criteria);
    }

    public function actionCheckNew65doctorAppointment() {
//        $this->layout = '/layouts/plain';

        $criteria=new CDbCriteria;
        $criteria->compare('user_id',Yii::app()->user->id);
        $unread = UnreadAppointment::model()->findAll($criteria);
        if (count($unread) > 0) {
            echo 1;
            return;
        }
        echo 0;
    }

    public function actionAjaxSaveAppointment() {
        if (isset($_POST['Appointment'])) {
            $model = new Appointment;
            $modelOperation = new Operation;
            $model->setAttributes($_POST['Appointment'], false);
            $model->startDate = $_POST['Appointment']['startDate'];
            $model->startTime = date('H:i',strtotime($_POST['Appointment']['startTime']));
            $model->endDate = $_POST['Appointment']['startDate'];
            $model->endTime = date('H:i',strtotime($_POST['Appointment']['endTime']));

            $model->doctor_id = $_POST['Appointment']['doctor_id'];

            $timeslot = new Timeslot; // Create new a timeslot for appointment
            $timeslot->doctor_id = $model->doctor_id;
            $timeslot->start = date('Y-m-d H:i:s', strtotime($model->startDate. ' ' . $model->startTime.':00'));
            $timeslot->end = date('Y-m-d H:i:', strtotime($model->endDate. ' ' . $model->endTime.':00'));
            $timeslot->save();

            $model->timeslot_id = $timeslot->id;
            $model->eventType = $_POST['Appointment']['eventType'];
            if ($model->eventType == 'op') {
                if (isset($_POST['Operation'])) {
                    $modelOperation->setAttributes($_POST['Operation'], false);
                    $modelOperation->save();
                    $model->operation_id = $modelOperation->id;
                    $model->is_operation = 1;
                    $model->scenario = 'addOperation';
                }
            }

            if ($model->save()) {
                $apiRecord = new APIActiveRecord;
                $params = array(
                    'doctor_id' => $model->doctor->_65doctor_id,
                    'start_time' => $model->timeslot->start,
                    'end_time' => $model->timeslot->end,
                );
                $url = '/redbull/deactiveTimeSlotStatus';
                $apiRecord->sentTo65doctor($params,$url);//Hide 65doctor timeslot
                // $this->redirect(array('calendar/#' . date('Y-m-d', strtotime($model->startDate)) . '|' . $model->doctor_id . '|' . $model->startTime));
                echo 1;
                return;
            }
        }
        echo 0;
    }
}

