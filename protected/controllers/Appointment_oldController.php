<?php

class AppointmentController extends FrontController {

    public function actionCreate($id = null, $d = null, $t = null, $doctor = null) {
        $model = new Appointment;

        if (isset($_POST['Appointment'])) {
            $model->setAttributes($_POST['Appointment'], false);
            $model->name = $_POST['Appointment']['name'];

            if (!empty($_POST['Appointment']['patient_id'])) {
                $patient = Patient::model()->findByPk($_POST['Appointment']['patient_id']);
                if ($patient) {
                    $model->patient_id = $patient->id;
                    $model->name = $patient->name;
                    if (empty($model->contact)) {
                        $model->contact = $patient->contact1;
                    }
                }
            }

            $model->eventType = $_POST['Appointment']['eventType'];
            $model->startDate = $_POST['Appointment']['startDate'];
            $model->startTime = $_POST['Appointment']['startTime'];
            $model->endDate = $_POST['Appointment']['startDate'];
            $model->endTime = $_POST['Appointment']['endTime'];
            $model->doctor_id = $_POST['Appointment']['doctor_id'];
            $model->clinic_id = $_POST['Appointment']['clinic_id'];

            if ($model->save()) {
                $this->redirect(array('appointment/calendar/#' . date('Y-m-d', strtotime($model->startDate)) . '|' . $model->doctor_id . '|' . $model->startTime));
            }
        } else {
            if (!empty($id)) {
                $patient = Patient::model()->findByPk($id);
                if ($patient) {
                    $model->patient_id = $patient->id;
                    $model->name = $patient->name;
                    $model->contact = $patient->contact1;
                }
            }
            if (!empty($d)) {
                $model->startDate = Date('M d, Y', $d);
                $model->endDate = Date('M d, Y', $d);

            } else {
                $model->startDate = Date('M d, Y');
                $model->endDate = Date('M d, Y');
            }
            if (!empty($t)) {
                $model->startTime = $t;
                $model->endTime = date('H:i', strtotime($t) + (15 * 60));
            }
            if (!empty($doctor)) {
                $model->doctor_id = $doctor;
            }
        }

        $c = new CDbCriteria;
        $c->order = 'name';
        $cd = new CDbCriteria;
        $cd->order = 'is_default desc, name';
        $doctorList = Doctor::model()->findAll($cd);
        $clinicList = Clinic::model()->findAll($c);
        $patients = Patient::model()->findAll($c);
        $data = DoctorTime::model()->getTableDataByDoctor($doctorList[0]->id);
        $this->render('create', array('model' => $model, 'doctorList' => $doctorList, 'clinicList' => $clinicList, 'patientlist' => $patients, 'data' => $data));
    }

    public function actionUpdate($id) {
        $model = Appointment::findEvent($id);
        if (isset($_POST['Appointment'])) {
            $model->setAttributes($_POST['Appointment'], false);
            $model->startDate = $_POST['Appointment']['startDate'];
            $model->startTime = $_POST['Appointment']['startTime'];
            $model->endDate = $_POST['Appointment']['startDate'];
            $model->endTime = $_POST['Appointment']['endTime'];

            if ($model->save()) {
                $this->redirect(array('appointment/view', 'id' => $model->event_id));
            }
        }

        $this->render('update', array('model' => $model));
    }

    public function actionDelete($id) {
        $model = Appointment::findEvent($id);
        $doctor_id = $model->event->doctor_id;

        if (isset($_POST['Appointment'])) {
            if ($model->delete()) {
                $this->redirect(array('appointment/calendar/#' . date('Y-m-d', strtotime($model->startDate)) . '|' . $doctor_id));
            }
        }

        $this->render('delete', array('model' => $model));
    }

    public function actionView($id) {
        $model = Appointment::model()->findByPk($id);
        if (!$model) {
            throw new CHttpException(404);
        }
        $this->render('view', array('model' => $model));
    }

    public function actionCalendar($dd = null) {
        $month = '';
        $model = Appointment::model()->getAllByWeek();
        $blackout = Blackout::model()->getCommonBlackout();
        $events = array();
        foreach ($model as $m) {
            if (!empty($events[$m->event->doctor_id])) {
                $events[$m->event->doctor_id][] = $m;
            } else {
                $events[$m->event->doctor_id] = array($m);
            }
        }
        foreach ($blackout as $bo) {
            if ($bo->type == 'leave') {
                if (!empty($events[$bo->doctor_id])) {
                    $events[$bo->doctor_id][] = $bo;
                } else {
                    $events[$bo->doctor_id] = array($bo);
                }
            }
        }

        $date = null;
        if (!empty($dd))
            $date = strtotime($dd);
        $c = new CDbCriteria;
        $c->order = 'is_default desc, name';
        $this->render('calendar', array(
            'events' => $events,
            'blackout' => $blackout,
            // 'doctorTimes'=>$doctorTimes,
            'date' => $date, 'doctors' => Doctor::model()->findAll($c)));
    }

    public function actionDoctor() {
        $model = Appointment::model()->getAllByDay(date('d'), date('m'));
        $c = new CDbCriteria;
        $c->order = 'is_default desc, name';
        $doctors = Doctor::model()->findAll($c);
        $blackout = Blackout::model()->getAllCoveringBlackout();

        $doctorTimes = array();
        $day = date('l');
        $criteria = new CDbCriteria;
        $criteria->compare('day', $day);
        foreach (DoctorTime::model()->findAll($criteria) as $time):
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
                $doctorTimes[] = array('doctor_id' => $time->doctor_id, 'starttime' => $starttime, 'endtime' => $endtime, 'color_code' => $color_code, 'color_code2' => $color_code2);
            endif;
        endforeach;
        $this->render('doctor', array('model' => $model, 'blackout' => $blackout, 'doctors' => $doctors, 'doctorTimes' => $doctorTimes));
    }

    public function actionAjaxGetDoctorTimeByDay() {
        if (isset($_POST['date'])) {
            $date = $_POST['date'];
            $doctorTimes = array();
            $day = date('l', strtotime($date));
            $criteria = new CDbCriteria;
            $criteria->compare('day', $day);
            foreach (DoctorTime::model()->findAll($criteria) as $time):
                if ($time->clinic_id > 0) :
                    $mClinic = Clinic::model()->findByPK($time->clinic_id);
                    $color_code = $mClinic->color_code;
                    $color_code2 = $mClinic->color_code2;
                    $starttime = $date . ' 08:00:00';
                    $endtime = $date . ' 12:30:00';
                    if ($time->time == 'PM') {
                        $starttime = $date . ' 13:00:00';
                        $endtime = $date . ' 17:45:00';
                    }
                    $doctorTimes[] = array('doctor_id' => $time->doctor_id, 'starttime' => $starttime, 'endtime' => $endtime, 'color_code' => $color_code, 'color_code2' => $color_code2);
                endif;
            endforeach;
            echo json_encode($doctorTimes);
        }
    }

    public function actionPrint_Appointment() {
        $c = new CDbCriteria;
        $c->order = 'is_default desc, name';
        $model = new Appointment('search');
        $doctorList = Doctor::model()->findAll($c);
        $modelPreview = new Appointment();
        $doctorPreview = new Doctor();
        $startDate = '';
        $endDate = '';
        if (isset($_POST['Appointment']['doctor_id'])) {
            $doctor_id = $_POST['Appointment']['doctor_id'];
            $startDate = HDateTime::formatDate($_POST['Appointment']['startDate']);
            $endDate = HDateTime::formatDate($_POST['Appointment']['endDate']);
            $time = $_POST['Appointment']['time'];

            $model->doctor_id = $doctor_id;
            $model->startDate = HDateTime::format($startDate, 'd-m-Y');
            $model->endDate = HDateTime::format($endDate, 'd-m-Y');
            $model->time = $time;

            $modelPreview = Appointment::searchAppointmentForPrint($doctor_id, $startDate, $endDate, $time);
            $doctorPreview = Doctor::model()->findByPk($doctor_id);
        }

        $this->render('print_appointment', array(
            'model' => $model,
            'doctorList' => $doctorList,
            'modelPreview' => $modelPreview,
            'doctorPreview' => $doctorPreview,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }

    public function actionPrint_Appointment_Result() {
        if (isset($_GET['doctor_id'])) {
            $doctor_id = $_GET['doctor_id'];
            $startDate = HDateTime::formatDate($_GET['start']);
            $endDate = HDateTime::formatDate($_GET['end']);
            $time = $_GET['time'];
            $type = $_GET['type'];
            $ids = $_GET['turnup'];
            $model = Appointment::searchAppointmentForPrint($doctor_id, $startDate, $endDate, $time, $type, $ids);
            $doctor = Doctor::model()->findByPk($doctor_id);
            if (count($model) == 0) {
                echo 'No result found';
                return;
            }
            $this->renderPartial('print_template', array('model' => $model, 'doctor' => $doctor, 'startDate' => $startDate, 'endDate' => $endDate, 'ids' => $ids, 'time' => $time));
        } else {
            echo 'No result found';
        }
    }

    public function renderTimeRow($data, $timeKey) {
        ob_start();
        ?>
        <?php foreach ($data as $key => $day): ?>
            <td <?php echo empty($day[$timeKey]) ? '' : 'class="has-data"'; ?> >
            <?php if (!empty($day[$timeKey])) : ?>
                <?php foreach ($day[$timeKey] as $item):
                    if ($item->clinic_id > 0) :
                        ?>
                            <section class="cell-time" clinicid="<?php echo $item->clinic_id; ?>" style="background: <?php echo $item->getColorCode(); ?>">
                                <div class="cell-time-content" ><?php echo $item->getContent(); ?></div>
                            <?php if (!empty($item->comment)) : ?>
                                    <div class="cell-time-comment"><?php echo Yii::t('static', 'Comments: '); ?><i><?php echo $item->comment; ?></i></div>
                        <?php endif; ?>
                                <input type="hidden" name="DoctorTime[id]" value="<?php echo $item->id; ?>">
                            </section>
                            <?php else : ?>
                            <div timeid="<?php echo $item->id; ?>" class="cell-time-empty" style="background: #FFFFAA;"><?php echo Yii::t('static', 'Not working '); ?></div>
                        <?php if (!empty($item->comment)) : ?>
                                <div class="cell-time-comment" style="background: #FFFFAA;"><?php echo Yii::t('static', 'Comments: '); ?><i><?php echo $item->comment; ?></i></div>
                            <?php endif;
                        endif;
                    endforeach ?>
                <?php else: ?>
                    <div class="cell-time-empty" style="background: #D7FFFF;"><?php echo DoctorTime::model()->getEmptyContent(); ?></div>
                <?php endif; ?>
            </td>
            <?php endforeach ?>
        <script type="text/javascript">
        // $(function(){
        //     $('.cell-time').click(function(event) {
        //          //alert($(this).attr('timeid'));
        //          $('.cell-time').parent('td').removeClass('active');
        //          $(this).parent('td').addClass('active');
        //          clinicid = $(this).attr('clinicid');
        //          $('#Appointment_clinic_id').val(clinicid);
        //      });
        // });
        </script>
        <?php
        $html = ob_get_clean();
        return $html;
    }

    public function actionAjaxGetTableTemplate() {
        if (isset($_POST['doctor_id'])) {
            $data = DoctorTime::model()->getTableDataByDoctor($_POST['doctor_id']);
            $this->renderPartial('table_template', array('data' => $data));
        }
    }
    
    public function actionAllAppointments()
    {
        $visit = new Visit('today');
        $notice = new Notice('listData');
        $date = time();
        //$appointments=Appointment::model()->getAll();
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
        foreach (DoctorTime::model()->findAll($criteria) as $time):
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
		$this->render('allappointment', array(
            'visit'=>$visit,
            'notice'=>$notice,
            'date'=>$date,
            'model'=>$model, 'blackout'=>$blackout, 'doctors'=>$doctors,
            'doctorTimes' => $doctorTimes,
        ));
    }

    // Uncomment the following methods and override them if needed
    /*
      public function filters()
      {
      // return the filter configuration for this controller, e.g.:
      return array(
      'inlineFilterName',
      array(
      'class'=>'path.to.FilterClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }

      public function actions()
      {
      // return external action classes, e.g.:
      return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
      'class'=>'path.to.AnotherActionClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }
     */
}
