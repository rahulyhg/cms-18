<?php

/**
 * This is the model class for table "mydb.{{event}}".
 *
 * The followings are the available columns in table '{{event}}':
 * @property integer $id
 * @property string $type
 * @property integer $calendar_id
 * @property string $start
 * @property string $end
 * @property string $remarks
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property Appointment $appointment
 * @property Calendar $calendar
 * @property Operation $operation
 */
class Event extends CActiveRecord {

    public $total_op;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{_event}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('deleted', 'numerical', 'integerOnly' => true),
            array('type', 'length', 'max' => 11),
            array('remarks', 'length', 'max' => 1000),
            // array('start, end', 'date', 'allowEmpty' => false, 'format' => 'yyyy-MM-dd H:mm', 'message' => Yii::t('validation', 'Invalid date time value')),
            array('end', 'minDuration'),
        );
    }

    public function minDuration($attribute, $params)
    {
        $diff = strtotime($this->end) - strtotime($this->start);
        if ($diff < Yii::app()->params['minEventDuration'] * 60)
        {
            $this->addError('end', Yii::t('validation', 'Event duration must be at least 15 minutes'));
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
            'operation' => array(self::HAS_ONE, 'Operation', 'event_id'),
            'doctor' => array(self::BELONGS_TO, 'Doctor', 'doctor_id'),
            'clinic' => array(self::BELONGS_TO, 'Clinic', 'clinic_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'start' => Yii::t('model', 'Start Time'),
            'end' => Yii::t('model', 'End Time'),
            'remarks' => Yii::t('model', 'Remarks'),
            'doctor_id' => Yii::t('model', 'Doctor'),
            'clinic_id' => Yii::t('model', 'Clinic'),
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
        $criteria->compare('type', $this->type, true);
        $criteria->compare('calendar_id', $this->calendar_id);
        $criteria->compare('start', $this->start, true);
        $criteria->compare('end', $this->end, true);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('deleted', $this->deleted);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Event the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        if ($this->isNewRecord || empty($this->created))
        {
            $this->created = time();
        }
        return true;
    }


}
