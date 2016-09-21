<?php

/**
 * This is the model class for table "{{fcc_booking}}".
 *
 * The followings are the available columns in table '{{fcc_booking}}':
 * @property integer $id
 * @property string $uuid
 * @property string $data
 * @property string $updated_date
 */
class FccBooking extends GActiveRecord
{
    public $bookingDate;
    public $bookingTime;
    public $bookingTime_show;
    public $startDate;
    public $endDate;
    public $time;
    public $datetime_type;
    public $patient_name;
    public $patient_ncic;
    public $pregnancy_type;
    public $area_code_id;
    public $patient_contact;
    public $timeslot_id;
    public $created_date;
    public $dob;
    public $scan_type;
    public $g;
    public $p;
    public $turn_up;
    public $ultrasound_type;
    public $is_virggo_intacta;
    public $procedure;
    public $lmp;
    public $edd;
    public $medical_history;
    public $note;
    public $previous_scan;
    public $comments;
    public $ultrasound_text;
    public $referralDoctor;

    public $startTime_show;
    public $startTime;
    public $endTime_show;
    public $endTime;

    public $doctor_selected;

    public static $scanType = array(
        '0' => 'XYZ',
        '1' => 'RST',
    );
    public static $pregnancyType = array(
        '0' => 'Patient is not pregnant',
        '1' => 'Singleton pregnancy',
        '2' => 'Multiple pregnancy',
    );
    public static $ultrasoundType = array(
        '0' => 'Early FA scan (16 – 20 weeks)',
        '1' => 'FA scan (21 – 23 weeks)',
        '2' => 'Growth scan',
        '3' => 'AFI + doppler',
        '4' => 'Dating / Viability scan',
        '5' => 'Gynae Scan',
        '6' => 'NT + 1st Trimester Screening (11 – 13 +6 weeks)',
        '7' => 'Cervical length',
    );
    public static $ultrasoundType2 = array(
        '0' => 'Early FA scan',
        '1' => 'FA scan',
        '2' => 'Growth scan',
        '3' => 'AFI + doppler',
        '4' => 'Dating / Viability scan',
        '5' => 'Gynae Scan',
        '6' => 'NT + 1st Trimester Screening',
        '7' => 'Cervical length',
    );
    public static $ultrasoundWeek= array(
        '0' => '16',
        '1' => '21',
        '2' => '0',
        '3' => '0',
        '4' => '0',
        '5' => '0',
        '6' => '11',
        '7' => '0',
    );
    public static $ultrasoundEndWeek= array(
        '0' => '20',
        '1' => '23',
        '2' => '0',
        '3' => '0',
        '4' => '0',
        '5' => '0',
        '6' => '19',
        '7' => '0',
    );
    public static $procedureType = array(
        '0' => 'Amniocentesis (15 – 20 weeks)',
        '1' => 'FBS',
        '2' => 'CVS (10 +3 – 12 +3 weeks)',
        '3' => 'IAPG (16 – 24 weeks)',
        '4' => 'Fetal reduction',
    );
    public static $procedureType2 = array(
        '0' => 'Amniocentesis',
        '1' => 'FBS',
        '2' => 'CVS',
        '3' => 'IAPG ',
        '4' => 'Fetal reduction',
    );
    public static $procedureWeek = array(
        '0' => '15',
        '1' => '0',
        '2' => '10',
        '3' => '16',
        '4' => '0',
    );
    public static $procedureEndWeek = array(
        '0' => '20',
        '1' => '0',
        '2' => '15',
        '3' => '24',
        '4' => '0',
    );
    public static $datetimeType = array(
        '0' => 'No date and time preference',
        '1' => 'Earliest available appointment',
        '2' => 'Show calendar to select date and time',
    );
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{fcc_booking}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('uuid, data', 'required'),
            array('uuid', 'length', 'max' => 36),
            array('updated_date, start, end', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, uuid, data, updated_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'doctor' => array(self::BELONGS_TO, 'FccDoctor', 'fcc_doctor_uuid'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'           => 'ID',
            'uuid'         => 'Uuid',
            'data'         => 'Data',
            'updated_date' => 'Updated Date',
            'dob'	=>	'DOB',
            'comments'  => 'Reason for U/S scan OR procedure<br>Note to FCC doctor',
            'patient_ncic' => 'Patient’s ID / NRIC',
            'area_code_id' => 'Country Code',
            'patient_contact' => 'Patient Contact Number',
            'previous_scan' => 'Previous Scan Date',
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
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        // $criteria->compare('is_deleted',0);
        $criteria->compare('id', $this->id);
        $criteria->compare('uuid', $this->uuid, true);
        $criteria->compare('data', $this->data, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->order = 'id desc';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FccBooking the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function calculateAge()
    {
        $date     = new DateTime($this->bookingData->dob);
        $now      = new DateTime();
        $interval = $now->diff($date);
        return $interval->y;
    }
    public function getContact()
    {
        return '(+' . AreaCode::model()->findByPk($this->bookingData->area_code_id)->area_code . ') ' . HString::correctCalendarText($this->bookingData->patient_contact);
    }

    public function getScanType()
    {
        $scanText = '';

        if (!empty($this->bookingData->ultrasound_type)) {
            $scanText = self::$ultrasoundType2[$this->bookingData->ultrasound_type];
        } elseif (!empty($this->bookingData->procedure)) {
            $scanText = self::$procedureType2[$this->bookingData->procedure];
        }
        return $scanText;
    }

    public function getDoctorName() {
        $doctorName = 'No Doctor Preference';

        if (!empty($this->bookingData->fcc_doctor_uuid)) {
            $c            = new CDbCriteria;
            $c->compare('uuid', $this->bookingData->fcc_doctor_uuid);
            $doctor = FccDoctor::model()->find($c);
            $doctorName = $doctor->fullName;
            $doctorUUId = $doctor->uuid;
        }
        return $doctorName;
    }

    public function getAppointmentTime() {
        $appointmentDateText = '';
        if ($this->start == $this->end) {
            $appointmentDateText = date('l, d F Y, h:i A',strtotime($this->start));
        }
        else {
            $appointmentDateText = date('l, d F Y, h:i A',strtotime($this->start)).' - '.date('h:i A',strtotime($this->end));
        }
        return $appointmentDateText;
    }

    public function getBookingData()
    {
        return json_decode($this->data);
    }

    public function checkExistTime($doctor_id, $date, $time)
    {
        $criteria = new CDbCriteria;
        $datetime = $date . ' ' . $time;
        $datetime = date('Y-m-d H:i:s', strtotime($datetime));
        $criteria->compare('is_deleted',0);

        $today = strtotime('+ 2 days',strtotime(date('Y-m-d H:i:s')));
        if (strtotime($datetime) <= $today) {
            return 1;
        }//Buffer + 2 days

        if ($date != '' && $time != '') {
            $criteria->addCondition("t.start <= '" . date('Y-m-d H:i:s', strtotime($datetime)) . "' and '" . $datetime . "' <= t.end");
        }
        // if ($doctor_id != '') {
        //     $criteria->addCondition("t.fcc_doctor_uuid = '" . $doctor_id . "'");
        // }
        $model = self::model()->findAll($criteria);
        if (count($model) > 0) {
            return 1;
        }

        return 0;
    }

    public function checkDeleteButton() {
        $allow = 1;
        $endDate = date('Y-m-d H:i:s',strtotime($this->end));
        $toDate = date('Y-m-d H:i:s');
        if (($endDate <= $toDate) || $this->is_deleted == 1) {
            $allow = 0;
        }
        return $allow;
    }
}
