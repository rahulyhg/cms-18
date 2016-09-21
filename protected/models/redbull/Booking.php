<?php

/**
 * This is the model class for table "{{booking}}".
 *
 * The followings are the available columns in table '{{booking}}':
 * @property integer $id
 * @property string $uuid
 * @property integer $patient_id
 * @property string $comment
 * @property string $patient_name
 * @property string $paitent_mobile
 * @property string $patient_email
 * @property integer $is_new_patient
 * @property integer $doctor_id
 * @property integer $email_reminded
 * @property integer $area_code_id
 * @property string $created_date
 * @property string $remark
 * @property integer $is_cancelled
 * @property integer $is_deleted
 */
class Booking extends CActiveRecord
{
    public $date_list;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{booking}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array(
                'is_new_patient, doctor_id, area_code_id, is_cancelled, is_deleted',
                'numerical',
                'integerOnly' => true
            ),
            array(
                'patient_name',
                'length',
                'max' => 255
            ),
            array(
                'paitent_mobile',
                'length',
                'max' => 20
            ),
            array(
                'patient_email',
                'length',
                'max' => 100
            ),
            array(
                'comment, created_date, remark, app_time',
                'safe'
            ),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array(
                'id, patient_id, comment, patient_name, paitent_mobile, patient_email, is_new_patient, doctor_id, area_code_id, created_date, remark, is_cancelled, is_deleted',
                'safe',
                'on' => 'search'
            )
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
            'timeslot' => array(
                self::BELONGS_TO,
                'Timeslot',
                'timeslot_id'
            ),
            'area_code' => array(
                self::BELONGS_TO,
                'AreaCode',
                'area_code_id'
            )
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'patient_id' => 'Patient',
            'comment' => 'Comment',
            'patient_name' => 'Patient Name',
            'paitent_mobile' => 'Paitent Mobile',
            'patient_email' => 'Patient Email',
            'is_new_patient' => 'Is New Patient',
            'doctor_id' => 'Doctor',
            'area_code_id' => 'Area Code',
            'created_date' => 'Created Date',
            'remark' => 'Remark',
            'is_cancelled' => 'Is Cancelled',
            'is_deleted' => 'Is Deleted'
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

        $criteria->compare('id', $this->id);
        $criteria->compare('patient_id', $this->patient_id);
        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('patient_name', $this->patient_name, true);
        $criteria->compare('paitent_mobile', $this->paitent_mobile, true);
        $criteria->compare('patient_email', $this->patient_email, true);
        $criteria->compare('is_new_patient', $this->is_new_patient);
        $criteria->compare('doctor_id', $this->doctor_id);
        $criteria->compare('area_code_id', $this->area_code_id);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('remark', $this->remark, true);
        $criteria->compare('is_cancelled', $this->is_cancelled);
        $criteria->compare('is_deleted', $this->is_deleted);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Booking the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        $timeslot            = new Timeslot;
        $timeslot->from_api      = 1;
        $timeslot->doctor_id = $this->doctor_id;

        $start = $this->app_time;

        $timeslot->start = date('Y-m-d H:i', strtotime($start));
        $timeslot->end   = date('Y-m-d H:i', strtotime($start) + (15 * 60));
        $timeslot->save();
        if ($timeslot->save()) {
            $this->timeslot_id = $timeslot->id;
            return true;
        }
    }

    protected function afterSave() {
        if (!$this->isNewRecord)//Update Log after Update
        {
            $criteria = new CDbCriteria;
            $criteria->compare('type' , '65doctor');
            $criteria->compare('booking_id' , $this->id);
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

    public function getAllByDayAndDoctorId($date, $doctorId)
    {
        $retValues   = array();
        $bo_criteria = new CDbCriteria;
        $bo_criteria->compare('type', array(
            'holiday',
            'leave'
        ));
        $blackout = Blackout::model()->findAll($bo_criteria);

        $criteria = new CDbCriteria;
        $criteria->compare('t.is_cancelled', 0);
        $criteria->compare('event.doctor_id', $doctorId);
        $criteria->compare('date(event.start)', $date);
        $criteria->with  = array(
            'event'
        );
        $criteria->order = 'event.start';
        $result          = $this->findAll($criteria);

        $bo_criteria = new CDbCriteria;
        $bo_criteria->compare('type', array(
            'covering'
        ));
        $covering = Blackout::model()->findAll($bo_criteria);

        foreach ($result as $item) {
            $inBlack = false;
            foreach ($blackout as $itemBlack) {
                if ((int) $itemBlack->doctor_id != 0) {
                    if (strtotime($itemBlack->start) <= strtotime(date("Y-m-d", strtotime($item->event->start))) && strtotime(date("Y-m-d", strtotime($item->event->start))) <= strtotime($itemBlack->end) && $itemBlack->doctor_id == $item->event->doctor_id) {
                        $inBlack = true;
                        break;
                    }
                } else {
                    if (strtotime($itemBlack->start) <= strtotime(date("Y-m-d", strtotime($item->event->start))) && strtotime(date("Y-m-d", strtotime($item->event->start))) <= strtotime($itemBlack->end)) {
                        $inBlack = true;
                        break;
                    }
                }
            }
            if (!$inBlack) {
                $inCovering = false;
                foreach ($covering as $itemCovering) {
                    if (strtotime($itemCovering->start) <= strtotime(date("Y-m-d", strtotime($item->event->start))) && strtotime(date("Y-m-d", strtotime($item->event->start))) <= strtotime($itemCovering->end) && $itemCovering->doctor_id == $item->event->doctor_id) {
                        $inCovering = true;
                        $doctor     = Doctor::model()->findByPk($itemCovering->covering_doctor_id);
                        $item->name = 'Covering is ' . $doctor->salutation . ' ' . $doctor->name . ': ' . $item->name;
                        break;
                    }
                }
                $retValues[] = $item;
            }
        }
        $coveringResult = $this->getAppointmentForCoveringDoctorByDay($date, $doctorId); //Get appointment for Covering Doctor
        foreach ($coveringResult as $item) {
            $retValues[] = $item;
        }
        return $retValues;
    }

    public function getAppointmentForCoveringDoctorByDay($date, $doctorId)
    {
        $retValues   = array();
        $bo_criteria = new CDbCriteria;
        $bo_criteria->compare('type', array(
            'covering'
        ));
        $bo_criteria->compare('covering_doctor_id', $doctorId);
        $bo_criteria->compare('date(start)', '<=' . $date);
        $bo_criteria->compare('date(end)', '>=' . $date);
        $covering       = Blackout::model()->find($bo_criteria);
        $coveringDoctor = Doctor::model()->findByPk($doctorId);
        if (isset($covering->doctor_id)) {
            $criteria = new CDbCriteria;
            $criteria->compare('t.is_cancelled', 0);
            $criteria->compare('event.doctor_id', $covering->doctor_id);
            $criteria->compare('date(event.start)', $date);
            $criteria->with  = array(
                'event'
            );
            $criteria->order = 'event.start';
            $result          = Booking::model()->findAll($criteria);

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
                        if (strtotime($itemBlack->start) <= strtotime(date("Y-m-d", strtotime($item->event->start))) && strtotime(date("Y-m-d", strtotime($item->event->start))) <= strtotime($itemBlack->end) && $itemBlack->doctor_id == $item->event->doctor_id) {
                            $inBlack = true;
                            break;
                        }
                    } else {
                        if (strtotime($itemBlack->start) <= strtotime(date("Y-m-d", strtotime($item->event->start))) && strtotime(date("Y-m-d", strtotime($item->event->start))) <= strtotime($itemBlack->end)) {
                            $inBlack = true;
                            break;
                        }
                    }
                }
                if (!$inBlack) {
                    $item->name  = 'Covering is ' . $coveringDoctor->salutation . ' ' . $coveringDoctor->name . ': ' . $item->name;
                    $retValues[] = $item;
                }
            }
        }
        return $retValues;
    }

    public function getAllByDay($date)
    {
        $retValues   = array();
        $bo_criteria = new CDbCriteria;
        $bo_criteria->compare('type', array(
            'holiday',
            'leave'
        ));
        $blackout = Blackout::model()->findAll($bo_criteria);

        $criteria = new CDbCriteria;
        $criteria->compare('t.is_cancelled', 0);
        $criteria->compare('date(event.start)', $date);
        $criteria->with  = array(
            'event'
        );
        $criteria->order = 'event.start';
        $result          = $this->findAll($criteria);

        $bo_criteria = new CDbCriteria;
        $bo_criteria->compare('type', array(
            'covering'
        ));
        $covering = Blackout::model()->findAll($bo_criteria);


        foreach ($result as $item) {
            $inBlack = false;
            foreach ($blackout as $itemBlack) {
                if ((int) $itemBlack->doctor_id != 0) {
                    if (strtotime($itemBlack->start) <= strtotime(date("Y-m-d", strtotime($item->event->start))) && strtotime(date("Y-m-d", strtotime($item->event->start))) <= strtotime($itemBlack->end) && $itemBlack->doctor_id == $item->event->doctor_id) {
                        $inBlack = true;
                        break;
                    }
                } else {
                    if (strtotime($itemBlack->start) <= strtotime(date("Y-m-d", strtotime($item->event->start))) && strtotime(date("Y-m-d", strtotime($item->event->start))) <= strtotime($itemBlack->end)) {
                        $inBlack = true;
                        break;
                    }
                }
            }
            if (!$inBlack) {
                foreach ($covering as $itemCovering) {
                    if (strtotime($itemCovering->start) <= strtotime(date("Y-m-d", strtotime($item->event->start))) && strtotime(date("Y-m-d", strtotime($item->event->start))) <= strtotime($itemCovering->end) && $itemCovering->doctor_id == $item->event->doctor_id) {
                        $doctor     = Doctor::model()->findByPk($itemCovering->covering_doctor_id);
                        $item->name = 'Covering is ' . $doctor->salutation . ' ' . $doctor->name . ': ' . $item->name;
                        break;
                    }
                }
                $retValues[] = $item;
            }
        }

        $coveringResult = $this->getAllCoveringByDay($date); //Get appointment for Covering Doctor
        foreach ($coveringResult as $item) {
            $retValues[] = $item;
        }
        return $retValues;
    }

    public function getAllCoveringByDay($date)
    {
        $retValues   = array();
        $bo_criteria = new CDbCriteria;
        $bo_criteria->compare('type', array(
            'covering'
        ));
        $bo_criteria->compare('date(start)', '<=' . $date);
        $bo_criteria->compare('date(end)', '>=' . $date);
        $covering = Blackout::model()->findAll($bo_criteria);
        foreach ($covering as $itemCovering) {
            $doctorId = $itemCovering->doctor_id;
            $criteria = new CDbCriteria;
            $criteria->compare('t.is_cancelled', 0);
            $criteria->compare('event.doctor_id', $doctorId);
            $criteria->compare('date(event.start)', $date);
            $criteria->with  = array(
                'event'
            );
            $criteria->order = 'event.start';
            $result          = Booking::model()->findAll($criteria);

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
                        if (strtotime($itemBlack->start) <= strtotime(date("Y-m-d", strtotime($item->event->start))) && strtotime(date("Y-m-d", strtotime($item->event->start))) <= strtotime($itemBlack->end) && $itemBlack->doctor_id == $item->event->doctor_id) {
                            $inBlack = true;
                            break;
                        }
                    } else {
                        if (strtotime($itemBlack->start) <= strtotime(date("Y-m-d", strtotime($item->event->start))) && strtotime(date("Y-m-d", strtotime($item->event->start))) <= strtotime($itemBlack->end)) {
                            $inBlack = true;
                            break;
                        }
                    }
                }
                if (!$inBlack) {
                    $inCovering             = true;
                    $doctor                 = Doctor::model()->findByPk($itemCovering->covering_doctor_id);
                    $item->name             = 'Covering is ' . $doctor->salutation . ' ' . $doctor->name . ': ' . $item->name;
                    $item->event->doctor_id = $itemCovering->covering_doctor_id;
                    $retValues[]            = $item;
                }
            }
        }
        return $retValues;
    }

    public function getAllByWeekAndDoctorId($date = null, $month = null, $doctor_id)
    {
        if ($date == null) {
            $day        = date('w');
            $week_start = date('Y-m-d', strtotime('-' . $day . ' days'));
            $week_end   = date('Y-m-d', strtotime('+' . (6 - $day) . ' days'));
        } else {
            $day        = date('w', strtotime($date));
            $week_start = date('Y-m-d', strtotime($date . '-' . $day . ' days'));
            $week_end   = date('Y-m-d', strtotime($date . '+' . (6 - $day) . ' days'));
        }

        $retValues = array();
        $criteria  = new CDbCriteria;
        $month     = $month == null ? date('m') : $month;
        $criteria->compare('t.is_cancelled', 0);
        $criteria->compare('event.doctor_id', $doctor_id);
        $criteria->addCondition('event.start >= "' . $week_start . ' 00:00:00" and event.start <= "' . $week_end . ' 23:59:59"');
        $criteria->with  = array(
            'event'
        );
        $criteria->order = 'event.start';
        $result          = $this->findAll($criteria);
        $bo_criteria     = new CDbCriteria;
        $bo_criteria->compare('type', array(
            'holiday',
            'leave'
        ));
        $blackout    = Blackout::model()->findAll($bo_criteria);
        $bo_criteria = new CDbCriteria;
        $bo_criteria->compare('type', array(
            'covering'
        ));
        $bo_criteria->addCondition('start >= "' . $week_start . ' 00:00:00" and start <= "' . $week_end . ' 23:59:59"');
        $covering = Blackout::model()->findAll($bo_criteria);
        foreach ($result as $item) {
            $inBlack = false;
            foreach ($blackout as $itemBlack) {
                if ((int) $itemBlack->doctor_id != 0) {
                    if (strtotime($itemBlack->start) <= strtotime(date("Y-m-d", strtotime($item->event->start))) && strtotime(date("Y-m-d", strtotime($item->event->start))) <= strtotime($itemBlack->end) && $itemBlack->doctor_id == $item->event->doctor_id) {
                        $inBlack = true;
                        break;
                    }
                } else {
                    if (strtotime($itemBlack->start) <= strtotime(date("Y-m-d", strtotime($item->event->start))) && strtotime(date("Y-m-d", strtotime($item->event->start))) <= strtotime($itemBlack->end)) {
                        $inBlack = true;
                        break;
                    }
                }
            }
            if (!$inBlack) {
                $inCovering = false;
                foreach ($covering as $itemCovering) {
                    if (strtotime($itemCovering->start) <= strtotime(date("Y-m-d", strtotime($item->event->start))) && strtotime(date("Y-m-d", strtotime($item->event->start))) <= strtotime($itemCovering->end) && $itemCovering->doctor_id == $item->event->doctor_id) {
                        $inCovering = true;
                        $doctor     = Doctor::model()->findByPk($itemCovering->covering_doctor_id);
                        $item->name = 'Covering is ' . $doctor->salutation . ' ' . $doctor->name . ': ' . $item->name;
                        break;
                    }
                }
                $retValues[] = $item;
            }
        }
        $coveringResult = $this->getAppointmentForCoveringDoctorByWeek($date, $month, $doctor_id); //Get appointment for Covering Doctor
        foreach ($coveringResult as $item) {
            $retValues[] = $item;
        }

        return $retValues;
    }

    public function getAppointmentForCoveringDoctorByWeek($date = null, $month = null, $doctor_id)
    {
        if ($date == null) {
            $day        = date('w');
            $week_start = date('Y-m-d', strtotime('-' . $day . ' days'));
            $week_end   = date('Y-m-d', strtotime('+' . (6 - $day) . ' days'));
        } else {
            $day        = date('w', strtotime($date));
            $week_start = date('Y-m-d', strtotime($date . '-' . $day . ' days'));
            $week_end   = date('Y-m-d', strtotime($date . '+' . (6 - $day) . ' days'));
        }

        $retValues = array();
        $criteria  = new CDbCriteria;
        $month     = $month == null ? date('m') : $month;
        $criteria->compare('t.is_cancelled', 0);
        $criteria->addCondition('event.start >= "' . $week_start . ' 00:00:00" and event.start <= "' . $week_end . ' 23:59:59"');
        $criteria->with  = array(
            'event'
        );
        $criteria->order = 'event.start';
        $result          = $this->findAll($criteria);
        $bo_criteria     = new CDbCriteria;
        $bo_criteria->compare('type', array(
            'holiday',
            'leave'
        ));
        $blackout    = Blackout::model()->findAll($bo_criteria);
        $bo_criteria = new CDbCriteria;
        $bo_criteria->compare('type', array(
            'covering'
        ));
        $bo_criteria->compare('covering_doctor_id', $doctor_id);
        $covering = Blackout::model()->findAll($bo_criteria);

        foreach ($result as $item) {
            $inBlack = false;
            foreach ($blackout as $itemBlack) {
                if ((int) $itemBlack->doctor_id != 0) {
                    if (strtotime($itemBlack->start) <= strtotime(date("Y-m-d", strtotime($item->event->start))) && strtotime(date("Y-m-d", strtotime($item->event->start))) <= strtotime($itemBlack->end) && $itemBlack->doctor_id == $item->event->doctor_id) {
                        $inBlack = true;
                        break;
                    }
                } else {
                    if (strtotime($itemBlack->start) <= strtotime(date("Y-m-d", strtotime($item->event->start))) && strtotime(date("Y-m-d", strtotime($item->event->start))) <= strtotime($itemBlack->end)) {
                        $inBlack = true;
                        break;
                    }
                }
            }
            if (!$inBlack) {
                foreach ($covering as $itemCovering) {
                    if ($itemCovering->doctor_id == $item->event->doctor_id) {
                        if (strtotime($itemCovering->start) <= strtotime(date("Y-m-d", strtotime($item->event->start))) && strtotime(date("Y-m-d", strtotime($item->event->start))) <= strtotime($itemCovering->end) && $itemCovering->doctor_id == $item->event->doctor_id) {
                            $inCovering  = true;
                            $doctor      = Doctor::model()->findByPk($itemCovering->covering_doctor_id);
                            $item->name  = 'Covering is ' . $doctor->salutation . ' ' . $doctor->name . ': ' . $item->name;
                            $retValues[] = $item;
                            break;
                        }
                    }
                }
            }
        }
        return $retValues;
    }

}
