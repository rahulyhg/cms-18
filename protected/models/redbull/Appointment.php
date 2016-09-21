<?php

/**
 * This is the model class for table "{{appointment}}".
 *
 * The followings are the available columns in table '{{appointment}}':
 * @property integer $id
 * @property integer $doctor_id
 * @property string $timeslot_id
 * @property string $patient_name
 * @property string $patientId
 * @property string $patient_email
 * @property integer $area_code_id
 * @property string $patient_mobile
 * @property integer $visit_reason
 * @property integer $is_new_patient
 * @property string $comments
 * @property integer $turn_up
 */
class Appointment extends GActiveRecord {

    public $startDate;
    public $startTime;
    public $startTime_show;
    public $endDate;
    public $endTime;
    public $endTime_show;
    public $date_list;
    public $app_time;
    public $time;
    public static $visit_reason = array('3' => 'New Consult', '0' => 'FU Consult', '1' => 'Chemotherapy', '2' => 'Others');
    public static $is_new_patient = array('0' => 'New Patient', '1' => 'Existing Patient');
    public $eventType;
    public $timeslotList;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{_appointment}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('doctor_id, patient_name, startDate, endDate, startTime_show, endTime_show', 'required'),//doctor_id, timeslot_id,
            array('doctor_id, area_code_id, visit_reason, is_new_patient, turn_up', 'numerical', 'integerOnly' => true),
            array('patient_mobile', 'length', 'max' => 20),
            array('endTime', 'checkDateAndTime'),
            array('startDate', 'checkValidDate','on'=>'print'),
            array('timeslot_id', 'length', 'max' => 36),
            array('patient_name', 'length', 'max' => 255),
            array('patientId', 'length', 'max' => 30),
            array('patient_email', 'length', 'max' => 100),
            array('patient_email', 'email'),
            array('comments', 'safe'),
            array('operation_id', 'required', 'on' => 'addOperation'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, doctor_id, timeslot_id, patient_name, patientId, patient_email, area_code_id, patient_mobile, visit_reason, is_new_patient, comments, turn_up', 'safe', 'on' => 'search'),
            
//            array('doctor_id, patient_name, startDate, endDate, startTime_show, endTime_show', 'required'),
//            array('doctor_id, area_code_id, visit_reason, is_new_patient, turn_up', 'numerical', 'integerOnly' => true),
//            array('patient_mobile', 'length', 'max' => 20),
//            array('endTime', 'checkDateAndTime'),
//            array('startDate', 'checkValidDate','on'=>'print'),
//            array('timeslot_id', 'length', 'max' => 36),
//            array('patient_name', 'length', 'max' => 255),
//            array('patientId', 'length', 'max' => 30),
//            array('patient_email', 'length', 'max' => 100),
//            array('comments', 'safe'),
//            array('operation_id', 'required', 'on' => 'addOperation'),
//            // The following rule is used by search().
//            // @todo Please remove those attributes that should not be searched.
//            array('id, doctor_id, timeslot_id, patient_name, patientId, patient_email, area_code_id, patient_mobile, visit_reason, is_new_patient, comments, turn_up', 'safe', 'on' => 'search'),
        );
    }
    
    public function checkValidDate($attribute, $params)
    {
            if (strtotime($this->$attribute )> strtotime( $this->endDate))
            {
                  
                   $this->addError($attribute, 'Start Date must be less than end date.');

            }
    }
   
    public function checkDateAndTime($attribute, $params)
	{
        if ($this->endDate != "" && $this->endTime != '' && $this->startDate != "" && $this->startTime != '')
        {
            $tempStart = strtotime($this->startDate . " " . $this->startTime);
            $tempEnd = strtotime($this->endDate . " " . $this->endTime);
            $now = strtotime("Y-m-d H:i:s");
            //echo $this->startDate . " " . $this->startTime . "--" . $this->endDate . " " . $this->endTime . "<br />";
    //        echo $tempStart . '--' . $tempEnd; die;
            if ($this->endDate != "" && $this->endTime != '' && $tempEnd <= $now)
            {
                $this->addError('endTime', "End time cannot be in the past"); 
            }

            if ($tempEnd <= $tempStart)
            {
                //$this->addError('endDate', "End date must be greater than start date");
                $this->addError('endTime', "End time must be greater than start time");
            }
        }
	}

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'timeslot' => array(self::BELONGS_TO, 'Timeslot', 'timeslot_id'),
            'doctor' => array(self::BELONGS_TO, 'Doctor', 'doctor_id'),
            'operation' => array(self::BELONGS_TO, 'Operation', 'operation_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'doctor_id' => 'Doctor',
            'timeslot_id' => 'Timeslot',
            'patient_name' => 'Patient Name',
            'patientId' => 'Patient Id',
            'patient_email' => 'Patient Email',
            'area_code_id' => 'Area Code',
            'patient_mobile' => 'Patient Mobile',
            'visit_reason' => 'Visit Reason',
            'is_new_patient' => 'Is New Patient',
            'comments' => 'Comments',
            'turn_up' => 'Turn Up',
            'startTime_show' => "Start Time", 
            'endTime_show' => 'End Time'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('doctor_id', $this->doctor_id);
        $criteria->compare('timeslot_id', $this->timeslot_id, true);
        $criteria->compare('patient_name', $this->patient_name, true);
        $criteria->compare('patientId', $this->patientId, true);
        $criteria->compare('patient_email', $this->patient_email, true);
        $criteria->compare('area_code_id', $this->area_code_id);
        $criteria->compare('patient_mobile', $this->patient_mobile, true);
        $criteria->compare('visit_reason', $this->visit_reason);
        $criteria->compare('is_new_patient', $this->is_new_patient);
        $criteria->compare('comments', $this->comments, true);
        $criteria->compare('turn_up', $this->turn_up);
        $criteria->compare('from_api', 0);
        $criteria->order = 'id desc';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Appointment the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeDelete() {
        $timeslot = new Timeslot;
        if (!empty($this->timeslot_id)) {
            $timeslot = $this->timeslot;
            $timeslot->delete();
            return true;
        }
        return false;
    }

    public function getPatientContact() {
        $contact = '';
        $area_code = AreaCode::model()->findByPk($this->area_code_id)->area_code;
        if (isset($area_code)) {
            $contact = '(+' . $area_code . ') ';
        }
        return $contact . $this->patient_mobile;
    }

    protected function afterSave() {
        if (!$this->isNewRecord) {//Update Log after Update
            $criteria = new CDbCriteria;
            $criteria->compare('type', 'appointment');
            $criteria->compare('appointment_id', $this->id);
            //$synLog = GoogleSyncLog::model()->findAll($criteria);

//            foreach ($synLog as $item) {
//                $item->action = 'update';
//                $item->updated_date = date('Y-m-d H:i:s');
//                $item->status = 1; //0: synched; 1: not sync yet
//                $item->update();
//            }
        }
        return parent::afterSave();
    }

    protected function afterDelete() {
        $criteria = new CDbCriteria;
        $criteria->compare('type', 'appointment');
        $criteria->compare('appointment_id', $this->id);
        //$synLog = GoogleSyncLog::model()->findAll($criteria);

//        foreach ($synLog as $item) {
//            $item->action = 'delete';
//            $item->updated_date = date('Y-m-d H:i:s');
//            $item->status = 1; //0: synched; 1: not sync yet
//            $item->update();
//        }
        parent::afterDelete();
    }

    public function checkExistTime($doctor_id, $date, $time, $update_id = 0) {
        $criteria = new CDbCriteria;
        $interval = 14; //15 minute
        $datetime = $date . ' ' . $time;

        if ($update_id > 0) { //Update Event Time is same -> ignore
            // echo $update_id;
            $criteria->addCondition("t.id != '" . $update_id . "'");
        }
        if ($date != '' && $time != '') {
            $criteria->addCondition("DATE_SUB(t.start,INTERVAL  " . $interval . " MINUTE) <= '" . $datetime . "' and DATE_ADD(t.start,INTERVAL  " . $interval . " MINUTE) >= '" . $datetime . "'");
        }
        if ($doctor_id != '') {
            $criteria->addCondition("t.doctor_id = '" . $doctor_id . "'");
        }
        $model = Timeslot::model()->find($criteria);
        if (count($model) > 0)
            return 1;
        return 0;
    }

    //Function fors calendar ================================================
    //for month calendar-----------

    public function getAppointmentDateList($month = '', $year = '') {//Get list of date have appointments for month calendar
        $criteria = new CDbCriteria;
        $criteria->with = array(
            'timeslot',
        );

        $criteria->select = array(
            "DATE_FORMAT(timeslot.start,'%Y-%m-%d') as date_list"
        );
        if ($month != '')
            $criteria->addCondition("MONTH(timeslot.start) = " . $month);
        if ($year != '')
            $criteria->addCondition("YEAR(timeslot.start) = " . $year);
        $criteria->group = "date_list";
        $criteria->order = 'date_list DESC';
        $model = Appointment::model()->findAll($criteria);

        $date_list = array();
        foreach ($model as $m) {
            $date_list[] = $m->date_list;
        }

        // $modelBooking    = Booking::model()->findAll($criteria);//For 65doctor appointment
        // foreach ($modelBooking as $m) {
        //     $date_list[] = $m->date_list;
        // }
        return array_unique($date_list);
    }

    public function countAppointmentByDate($doctor_id, $date) {
        $criteria = new CDbCriteria;
        $criteria->with = array(
            'timeslot',
        );

        if (empty($doctor_id) || empty($date)) {
            return 0;
        }

        //$criteria->addCondition("t.doctor_id = '" . $doctor_id . "'");
        $criteria->addCondition("Date(timeslot.start) = '" . $date . "'");

        $model = Appointment::model()->findAll($criteria); //For count Appointment

        $bo_criteria = new CDbCriteria;
        $bo_criteria->compare('type', array(
            'holiday',
            'leave'
        ));
        $blackout = Blackout::model()->findAll($bo_criteria);
        $sumary = array(
            'operation' => 0,
            'fuConsult' => 0,
            'newConsult' => 0,
            'chemotherapy' => 0,
            '_65doctor' => 0,
            'others' => 0,
            'date' => $date,
            'url' => Yii::app()->createUrl('#' . date('Y-m-d', strtotime($date)) . '|' . $doctor_id),
        );
        foreach ($model as $m) {
            $inBlack = false;
            foreach ($blackout as $itemBlack) {
                if ((int) $itemBlack->doctor_id != 0) {
                    if (strtotime($itemBlack->start) <= strtotime(date("Y-m-d", strtotime($m->timeslot->start))) && strtotime(date("Y-m-d", strtotime($m->timeslot->start))) <= strtotime($itemBlack->end) && $itemBlack->doctor_id == $m->timeslot->doctor_id) {
                        $inBlack = true;
                        break;
                    }
                } else {
                    if (strtotime($itemBlack->start) <= strtotime(date("Y-m-d", strtotime($m->timeslot->start))) && strtotime(date("Y-m-d", strtotime($m->timeslot->start))) <= strtotime($itemBlack->end)) {
                        $inBlack = true;
                        break;
                    }
                }
            }
            if (!$inBlack) {
                if ($m->is_operation == 0) {
                    if ($m->from_api) {
                        $sumary['_65doctor'] ++;
                    } else {
                        switch ($m->visit_reason) {
                            case 0:
                                $sumary['fuConsult'] ++;
                                break;
                            case 3:
                                $sumary['newConsult'] ++;
                                break;
                            case 1:
                                $sumary['chemotherapy'] ++;
                                break;
                            case 2:
                                $sumary['others'] ++;
                                break;
                        };
                    }
                } else {
                    $sumary['operation'] ++;
                }
            }
        }
        return $sumary;
    }

    //for week calendar
    public function getAppointmentByWeek($date = null, $month = null, $doctor_id) {
        if ($date == null) {
            $day = date('w');
            $week_start = date('Y-m-d', strtotime('-' . $day . ' days'));
            $week_end = date('Y-m-d', strtotime('+' . (6 - $day) . ' days'));
        } else {
            $day = date('w', strtotime($date));
            $week_start = date('Y-m-d', strtotime($date . '-' . $day . ' days'));
            $week_end = date('Y-m-d', strtotime($date . '+' . (6 - $day) . ' days'));
        }

        $retValues = array();
        $criteria = new CDbCriteria;
        $month = $month == null ? date('m') : $month;
        // $criteria->compare('t.is_operation', 0);
        $criteria->compare('t.doctor_id', $doctor_id);
        $criteria->addCondition('timeslot.start >= "' . $week_start . ' 00:00:00" and timeslot.start <= "' . $week_end . ' 23:59:59"');
        $criteria->with = array(
            'timeslot'
        );
        $criteria->order = 'timeslot.start';
        $result = $this->findAll($criteria);
        $bo_criteria = new CDbCriteria;
        $bo_criteria->compare('type', array(
            'holiday',
            'leave'
        ));
        $blackout = Blackout::model()->findAll($bo_criteria);
        foreach ($result as $item) {
            $inBlack = false;
            foreach ($blackout as $itemBlack) {
                if ((int) $itemBlack->doctor_id != 0) {
                    if (strtotime($itemBlack->start) <= strtotime(date("Y-m-d", strtotime($item->timeslot->start))) && strtotime(date("Y-m-d", strtotime($item->timeslot->start))) <= strtotime($itemBlack->end) && $itemBlack->doctor_id == $item->timeslot->doctor_id) {
                        $inBlack = true;
                        break;
                    }
                } else {
                    if (strtotime($itemBlack->start) <= strtotime(date("Y-m-d", strtotime($item->timeslot->start))) && strtotime(date("Y-m-d", strtotime($item->timeslot->start))) <= strtotime($itemBlack->end)) {
                        $inBlack = true;
                        break;
                    }
                }
            }
            if (!$inBlack) {
                $retValues[] = $item;
            }
        }

        return $retValues;
    }

    //for day calendar
    public function getAppointmentByDate($date, $doctorId) {
        $retValues = array();
        $bo_criteria = new CDbCriteria;
        $bo_criteria->compare('type', array(
            'holiday',
            'leave'
        ));
        $blackout = Blackout::model()->findAll($bo_criteria);

        $criteria = new CDbCriteria;
        // $criteria->compare('t.is_operation', 0);
        //$criteria->compare('t.doctor_id', $doctorId);
        $criteria->compare('date(timeslot.start)', $date);
        $criteria->with = array(
            'timeslot'
        );
        $criteria->order = 'timeslot.start';
        $result = Appointment::model()->findAll($criteria);
        foreach ($result as $item) {
            $inBlack = false;
//            foreach ($blackout as $itemBlack) {
//                if ((int) $itemBlack->doctor_id != 0) {
//                    if (strtotime($itemBlack->start) <= strtotime(date("Y-m-d", strtotime($item->timeslot->start))) && strtotime(date("Y-m-d", strtotime($item->timeslot->start))) <= strtotime($itemBlack->end) && $itemBlack->doctor_id == $item->timeslot->doctor_id) {
//                        $inBlack = true;
//                        break;
//                    }
//                } else {
//                    if (strtotime($itemBlack->start) <= strtotime(date("Y-m-d", strtotime($item->timeslot->start))) && strtotime(date("Y-m-d", strtotime($item->timeslot->start))) <= strtotime($itemBlack->end)) {
//                        $inBlack = true;
//                        break;
//                    }
//                }
//            }
            if (!$inBlack) {
                $retValues[] = $item;
            }
        }
        return $retValues;
    }

    public function searchAppointmentForPrint($modelSearch) {
        $criteria = new CDbCriteria;
        $criteria->with = array(
            'timeslot'
        );
        $criteria->compare('t.patient_name', $modelSearch->patient_name, true);
        $criteria->compare('t.patientId', $modelSearch->patientId, true);
        $criteria->compare('t.patient_mobile', $modelSearch->patient_mobile, true);
        $criteria->compare('t.patient_email', $modelSearch->patient_email, true);
//        $criteria->compare('t.from_api', 0);
        //$criteria->compare('t.doctor_id', $modelSearch->doctor_id, true);
        if ($modelSearch->turn_up > 0)
            $criteria->compare('t.turn_up', $modelSearch->turn_up);
        if ($modelSearch->time != '')
            $criteria->addCondition("RIGHT(DATE_FORMAT(timeslot.start,'%r'),2) = '" . $modelSearch->time . "'");

        if ($modelSearch->startDate != "" && $modelSearch->endDate != "") {
            $criteria->addBetweenCondition('timeslot.start', $modelSearch->startDate . ' ' . '00:00:00', $modelSearch->endDate . ' ' . '23:59:59');
        } elseif ($modelSearch->startDate == "" && $modelSearch->endDate != "") {
            $criteria->addBetweenCondition('timeslot.start', '1990-01-01 00:00:00', $modelSearch->endDate . ' ' . '23:59:59');
        } elseif ($modelSearch->startDate != "" && $modelSearch->endDate == "") {
            $criteria->addBetweenCondition('timeslot.start', $modelSearch->startDate . ' ' . '00:00:00', '2200-01-01 00:00:00');
        } else {
            $criteria->addBetweenCondition('timeslot.start', '1990-01-01 00:00:00', '2200-01-01 00:00:00');
        }
        $criteria->order = 'timeslot.start asc';
        return Appointment::model()->findAll($criteria);
    }
    
    public function getListBaseOnPatient($patient_id, $return = false) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria = new CDbCriteria;
        $criteria->compare('patient_id', $patient_id);
        $criteria->compare('is_deleted', STATUS_INACTIVE);

        if ($return) {
            return $this->findAll($criteria);
        } else {
            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => Yii::app()->params['defaultPageSize'],
                ),
            ));
        }
    }

}
