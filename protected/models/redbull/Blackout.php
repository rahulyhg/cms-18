<?php

class Blackout extends CActiveRecord {

    public $startDate;
    public $startTime;
    public $endDate;
    public $endTime;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{_blackout}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('type', 'length', 'max' => 8),
            array('comments', 'length', 'max' => 500),
            array('start, end', 'date', 'allowEmpty' => false, 'format' => 'yyyy-MM-dd H:m', 'message' => Yii::t('validation', 'Invalid date time value')),
            array('end', 'lessThanStart'),
            array('doctor_id', 'requiredForLeave'),
            array('doctor_id,covering_doctor_id', 'requiredForLeaveWithCovering'),
        );
    }

    public function lessThanStart($attribute, $params)
    {
        if (strtotime($this->end) < strtotime($this->start))
        {
            $this->addError('endDate', Yii::t('validation', 'End date must not be earlier than Start date'));
        }
    }

    public function requiredForLeave($attribute, $params)
    {
        if ($this->type == 'leave' && empty($this->doctor_id))
        {
            $this->addError('doctor_id', Yii::t('validation', 'Please select doctor'));
        }
    }

    public function requiredForLeaveWithCovering($attribute, $params)
    {
        if ($this->type == 'covering')
        {
            if (empty($this->doctor_id))
                $this->addError('doctor_id', Yii::t('validation', 'Please select doctor'));
            if (empty($this->covering_doctor_id))
                $this->addError('doctor_id', Yii::t('validation', 'Please select covering doctor'));
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'doctor' => array(self::BELONGS_TO, 'Doctor', 'doctor_id'),
            'covering_doctor' => array(self::BELONGS_TO, 'Doctor', 'covering_doctor_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'start' => Yii::t('model', 'Start Date'),
            'end' => Yii::t('model', 'End Date'),
            'doctor_id' => Yii::t('model', 'Doctor'),
            'comments' => Yii::t('model', 'Comments'),
            'type' => Yii::t('model', 'Black Out Type'),
            'covering_doctor_id' => Yii::t('model', 'Covering Doctor'),
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

        $criteria->compare('type', $this->type, true);
        $criteria->compare('start', $this->start, true);
        $criteria->compare('end', $this->end, true);
        $criteria->compare('comments', $this->comments, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Blackout the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCommonBlackout()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('type', array('holiday', 'other'));
        return $this->findAll($criteria);
    }

    public function getLeaveBlackout($doctor_id)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('doctor_id', $doctor_id);
        $criteria->compare('type', array('leave','covering'));
        return $this->findAll($criteria);
    }

    public function getAllCoveringBlackout() {
        $criteria = new CDbCriteria;
        $criteria->compare('type', array('covering'));
        return $this->findAll($criteria);
    }

    public function getCoveringBlackout($doctor_id)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'doctor_id ='.$doctor_id.' or covering_doctor_id='.$doctor_id;
//        $criteria->compare('doctor_id', $doctor_id);
//        $criteria->compare('covering_doctor_id', $doctor_id);
        $criteria->compare('type', array('covering'));
        return $this->findAll($criteria);
    }

    public function getLeaveBlackoutByDate($doctor_id, $starttime = '00:00:00', $endtime = '00:00:00')
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition('type = "leave"');
        $criteria->addCondition('doctor_id = :doctorId');
        $criteria->addCondition('(:starttime >= date(start) and :starttime <= date(end)) OR (:endtime >= date(start) and :endtime <= date(end))');
       
        $criteria->params = array(
            ':doctorId'=> $doctor_id,
            ':starttime'=> date('Y-m-d', strtotime($starttime)),
            ':endtime'=> date('Y-m-d', strtotime($endtime))
        );

        if (count(BlackOut::model()->findAll($criteria)) == 0)
        {
            $criteria = new CDbCriteria;
            $criteria->addCondition('type = "time"');
            $criteria->addCondition('doctor_id = :doctorId');
            $criteria->addCondition('(:starttime >= t.start and :starttime <= t.end) OR (:endtime >= t.start and :endtime <= t.end)');
            $criteria->params = array(
                ':doctorId'=> $doctor_id,
                ':starttime'=> $starttime,
                ':endtime'=> $endtime
            );
            if (count(BlackOut::model()->findAll($criteria)) == 0)
            {
                $criteria = new CDbCriteria;
                $criteria->addCondition('type = "holiday"');
                $criteria->addCondition('(:starttime >= date(t.start) and :starttime <= date(t.end)) OR (:endtime >= date(t.start) and :endtime <= date(t.end))');
                $criteria->params = array(
                    ':starttime'=> date('Y-m-d', strtotime($starttime)),
                    ':endtime'=> date('Y-m-d', strtotime($endtime))
                );
                if (count(BlackOut::model()->findAll($criteria)) > 0) {
                    return 1;
                }
                return 0;
            }
        }
        return 1;
    }

    public function checkHolidayTime($starttime,$endtime) {
        $criteria = new CDbCriteria;
        $criteria->with = array('timeslot');
        $criteria->addCondition('(:starttime <= date(timeslot.start) and :endtime >= date(timeslot.start))');
        $criteria->params = array(
            ':starttime'=> date('Y-m-d', strtotime($starttime)),
            ':endtime'=> date('Y-m-d', strtotime($endtime))
        );
        if (count(Appointment::model()->findAll($criteria)) == 0) {
                return 0;
        }
        return 1;

    }

    public function checkLeaveTime($doctor_id, $starttime,$endtime) {//Doctor Leave
        $criteria = new CDbCriteria;
        $criteria->with = array('timeslot');
        $criteria->addCondition('t.doctor_id = :doctorId');
        $criteria->addCondition('(:starttime <= date(timeslot.start) and :endtime >= date(timeslot.start))');
        $criteria->params = array(
            ':doctorId' => $doctor_id,
            ':starttime'=> date('Y-m-d', strtotime($starttime)),
            ':endtime'=> date('Y-m-d', strtotime($endtime))
        );
        if (count(Appointment::model()->findAll($criteria)) == 0) {
            return 0;
        }
        return 1;
    }

    public function checkBlackOutTime($doctor_id,$starttime,$endtime) {//Doctor Leave time
        $criteria = new CDbCriteria;
        $criteria->with = array('timeslot');
        $criteria->addCondition('t.doctor_id = :doctorId');
        $criteria->addCondition('(:starttime <= timeslot.start and :endtime >= timeslot.start) or (:starttime <= timeslot.end and :endtime >= timeslot.end)');
        $criteria->params = array(
            ':doctorId' => $doctor_id,
            ':starttime'=> date('Y-m-d H:i:s', strtotime($starttime)),
            ':endtime'=> date('Y-m-d H:i:s', strtotime($endtime))
        );
        if (count(Appointment::model()->findAll($criteria)) == 0) {
            return 0;
        }
        return 1;
    }

    public function checkCoveringTime($doctor_id,$covering_id,$starttime,$endtime,$updateid) {//Doctor Leave time
        $criteria = new CDbCriteria;
        $criteria->addCondition('type = "covering"');
        $criteria->addCondition('doctor_id = :doctorId');
        if ($updateid > 0)
            $criteria->addCondition('id <> :updateid');
        $criteria->addCondition('(:starttime <= date(start) and date(start) <= :endtime) OR (:starttime <= date(end) and date(end) <= :endtime)');
        $criteria->params = array(
            ':doctorId' => $doctor_id,
            ':updateid' => $updateid,
            ':starttime'=> date('Y-m-d', strtotime($starttime)),
            ':endtime'=> date('Y-m-d', strtotime($endtime))
        );
        if (count(Blackout::model()->findAll($criteria)) == 0) {
            // $criteria = new CDbCriteria;
            // $criteria->addCondition('type = "covering"');
            // $criteria->addCondition('covering_doctor_id = :doctorId');
            // $criteria->addCondition('(:starttime <= date(start) and date(start) <= :endtime) OR (:starttime <= date(end) and date(end) <= :endtime)');
            // $criteria->params = array(
            //     ':doctorId' => $covering_id,
            //     ':starttime'=> date('Y-m-d', strtotime($starttime)),
            //     ':endtime'=> date('Y-m-d', strtotime($endtime))
            // );
            // if (count(Blackout::model()->findAll($criteria)) == 0)
                return 0;
        }
        return 1;
    }

    protected function afterDelete() {
        $criteria = new CDbCriteria;
        $criteria->compare('type' , 'blackout');
        $criteria->compare('blackout_id' , $this->id);
        $synLog = GoogleSyncLog::model()->findAll($criteria);

        foreach ($synLog as $item) {
            $item->action = 'delete';
            $item->updated_date = date('Y-m-d H:i:s');
            $item->status = 1;//0: synched; 1: not sync yet
            $item->update();
        }
        parent::afterDelete();
    }

    protected function afterSave() {
        if (!$this->isNewRecord)//Update Log after Update
        {
            $criteria = new CDbCriteria;
            $criteria->compare('type' , 'blackout');
            $criteria->compare('blackout_id' , $this->id);
            $synLog = GoogleSyncLog::model()->findAll($criteria);

            foreach ($synLog as $item) {
                $item->action = 'update';
                $item->updated_date = date('Y-m-d H:i:s');
                $item->status = 1;//0: synched; 1: not sync yet
                $item->update();
            }
        }
        return parent::afterSave();
    }


}
