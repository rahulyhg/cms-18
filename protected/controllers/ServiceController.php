<?php
class ServiceController extends CController {
	public $layout='/layouts/service';

	public function actionIndex() {
		$this->layout = '//layouts/plain';
		$this->render('index');
	}

	public function actionGetPatients() {
		if(isset($_POST['Service']) && isset($_POST['Service']['code']))
		{
            $clinic = Clinic::model()->findByAttributes(array('code'=>$_POST['Service']['code']));
            if (!$clinic) {
                $response = $this->buildResponse(-1, 'Invalid clinic code.');
            }
            else {
                $c=new CDbCriteria;
                if (!empty($clinic->patient_sync)) {
                    $c->compare('t.created','>= '.$clinic->patient_sync);
                }
                $patients = Patient::model()->findAll($c);
                $response = $this->buildResponse(1, '', $patients, array(
                    'salutation',
                    'name',
                    'identity',
                    'nationality',
                    'dob',
                    'race',
                    'religion',
                    'occupation',
                    'company',
                    'marital',
                    'gender',
                    'language',
                    'residential',
                    'mailing',
                    'contact1',
                    'contact2',
                    'contact3',
                    'contact4',
                    'singapore_contact',
                    'singapore_address',
                    'nok_name',
                    'nok_relationship',
                    'nok_dob',
                    'nok_identity',
                    'nok_contact',
                    'nok_occupation',
                    'nok_company',
                    'referring',
                    'allow_to_contact',
                    'nok_date',
                    'remarks',
                    'contact_type1',
                    'contact_type2',
                    'contact_type3',
                    'contact_type4',
                    'nok_contact_type',
                    'created'));
                $clinic->patient_sync=time();
                $clinic->save();
            }
		}
		else {
			$response = $this->buildResponse(-1, 'Invalid post data. Expecting Service.');
		}

		$this->render('json',array(
			'response'=>$response,
		));
	}

    public function actionGetEvents() {
        if(isset($_POST['Service']) && isset($_POST['Service']['code']))
        {
            $clinic = Clinic::model()->findByAttributes(array('code'=>$_POST['Service']['code']));
                if (!$clinic) {
                $response = $this->buildResponse(-1, 'Invalid clinic code.');
            }
            else {
                $c=new CDbCriteria;
                $c->compare('t.clinic_id',$clinic->id);
                if (!empty($clinic->event_sync)) {
                    $c2=new CDbCriteria;
                    $c2->compare('t.created',null);
                    $c2->compare('t.created','>= '.$clinic->event_sync,false,'OR');
                    $c=$c->mergeWith($c2);
                }
                $events = Event::model()->findAll($c);
                $response = $this->buildResponse(1, '', $events, array(
                    'id',
                    'type',
                    'start',
                    'end',
                    'remarks',
                    'doctor',
                    'deleted',
                    'created'), array(), array('doctor'=>array('name')));
                $clinic->event_sync=time();
                $clinic->save();
            }
        }
        else {
            $response = $this->buildResponse(-1, 'Invalid post data. Expecting Service.');
        }

        $this->render('json',array(
            'response'=>$response,
        ));
    }

    public function actionGetDoctors() {
        if(isset($_POST['Service']) && isset($_POST['Service']['code']))
        {
            $clinic = Clinic::model()->findByAttributes(array('code'=>$_POST['Service']['code']));
            if (!$clinic) {
                $response = $this->buildResponse(-1, 'Invalid clinic code.');
            }
            else {
                $doctors = Doctor::model()->findAll();
                $response = $this->buildResponse(1, '', $doctors, array(
                    'name',
                    'active',
                    'user_id'));
            }
        }
        else {
            $response = $this->buildResponse(-1, 'Invalid post data. Expecting Service.');
        }

        $this->render('json',array(
            'response'=>$response,
        ));
    }

    public function actionGetAppointment(){
        if(isset($_POST['Service']) && isset($_POST['Service']['code']))
        {
            $clinic = Clinic::model()->findByAttributes(array('code'=>$_POST['Service']['code']));
            if (!$clinic) {
                $response = $this->buildResponse(-1, 'Invalid clinic code.');
            }
            else {
                $c=new CDbCriteria;
                $c->compare('t.event_id',$_POST['Service']['event_id']);

                $model = Appointment::model()->find($c);
                $response = $this->buildResponse(1, '', array($model), array(
                    'name',
                    'contact',
                    'deleted',
                    'status',
                    'comments',
                    'patient',
                    'admission_hospital',
                    'where_in_hospital',
                    'bed_type',
                    'anaesthesia_type',
                    'anaesthetist',
                    'preparation',
                    'surgical_assistant',
                    'operation_type'), array(), array('patient'=>array('identity')));
            }
        }
        else {
            $response = $this->buildResponse(-1, 'Invalid post data. Expecting Service.');
        }

        $this->render('json',array(
            'response'=>$response,
        ));
    }

    public function actionSetPatient() {
        if(isset($_POST['Service']) && isset($_POST['Service']['code']))
        {
            $clinic = Clinic::model()->findByAttributes(array('code'=>$_POST['Service']['code']));
            if (!$clinic) {
                $response = $this->buildResponse(-1, 'Invalid clinic code.');
            }
            else {
                $model=Patient::model()->findByAttributes(array('identity'=>$_POST['Patient']['identity']));
                if (empty($model)) $model=new Patient;

                $model->setAttributes($_POST['Patient'], false);

                if ($model->save()) {
                    // question and answers
                    $questions = Question::model()->findAll();
                    if ($_POST['question']) {
                        foreach ($questions as $q) {
                            if (isset($_POST['question'][$q->id])) {
                                $pq = new PatientQuestion;
                                $pq->patient_id = $model->id;
                                $pq->question_id = $q->id;
                                $pq->answer = $_POST['question'][$q->id];

                                $pq->save();
                            }
                        }
                    }

                    $response = $this->buildResponse(0, '');
                }
                else {
                    $response = $this->buildResponse(-2, 'Validation failed', array(), array(), array('errors'=>$model->getErrors()));
                }
            }
        }
        else {
            $response = $this->buildResponse(-1, 'Invalid post data. Expecting Service.');
        }

        $this->render('json',array(
            'response'=>$response,
        ));
    }

    public function actionSetAppointment() {
        if(isset($_POST['Service']) && isset($_POST['Service']['code']))
        {
            $clinic = Clinic::model()->findByAttributes(array('code'=>$_POST['Service']['code']));
            if (!$clinic) {
                $response = $this->buildResponse(-1, 'Invalid clinic code.');
            }
            else {
                $model=new Appointment;
                $model->setAttributes($_POST['Appointment'], false);

                if (!empty($_POST['Patient'])) {
                    $patient = Patient::model()->findByAttributes(array('identity'=>$_POST['Patient']['identity']));
                    if ($patient) {
                        $model->patient_id = $patient->id;
                        $model->name = $patient->name;
                        if (empty($model->contact)) {
                            $model->contact = $patient->contact1;
                        }
                    }
                    else {
                        $model->name = $_POST['Patient']['name'];
                    }
                }
                $doctor=Doctor::model()->findByAttributes(array('name'=>$_POST['Doctor']['name']));
                if (!empty($doctor)) {
                    $model->doctor_id=$doctor->id;

                    $model->eventType=$_POST['Appointment']['eventType'];
                    $model->startDate=$_POST['Appointment']['startDate'];
                    $model->startTime=$_POST['Appointment']['startTime'];
                    $model->endDate=$_POST['Appointment']['startDate'];
                    $model->endTime=$_POST['Appointment']['endTime'];

                    $model->clinic_id=$clinic->id;

                    if ($model->save()) {
                        $response = $this->buildResponse(0, '');
                    }
                    else {
                        $response = $this->buildResponse(-2, 'Validation failed', array(), array(), array('errors'=>$model->getErrors()));
                    }
                }
                else {
                    $response = $this->buildResponse(-4, 'Invalid doctor.');
                }
            }
        }
        else {
            $response = $this->buildResponse(-1, 'Invalid post data. Expecting Service.');
        }

        $this->render('json',array(
            'response'=>$response,
        ));
    }

	private function buildResponse($result, $message, $data=array(), $fields=array(), $options=array(), $assoc=array()) {
		$response = array();
		$response['result'] = $result;
		$response['message'] = $message;

        $list = array();
        foreach ($data as $p) {
            $item = array();
            foreach ($fields as $f) {
                if (array_key_exists($f, $assoc)) {
                    $as=array();
                    foreach ($assoc[$f] as $ak) {
                        $as[$ak]=$p->$f->$ak;
                    }
                    $item[$f]=$as;
                } else {
                    $item[$f]=$p->$f;
                }
            }
            $list[]=$item;
        }

		$response['data'] = $list;
        $response['options']=$options;

		return $response;
	}
}
?>
