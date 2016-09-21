<?php

/**
 * This is the model class for table "{{fcc_timetable}}".
 *
 * The followings are the available columns in table '{{fcc_timetable}}':
 * @property integer $id
 * @property string $day
 * @property string $time
 * @property string $fcc_doctor_uuid
 * @property string $uuid
 */
class FccTimetable extends GActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{fcc_timetable}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('day, time, fcc_doctor_uuid, uuid', 'required'),
			array('uuid', 'unique'),
			array('day', 'length', 'max'=>20),
			array('time', 'length', 'max'=>2),
			array('fcc_doctor_uuid, uuid', 'length', 'max'=>36),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, day, time, fcc_doctor_uuid, uuid', 'safe', 'on'=>'search'),
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
			'doctor' => array(self::BELONGS_TO,'FccDoctor','fcc_doctor_uuid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'day' => 'Day',
			'time' => 'Time',
			'fcc_doctor_uuid' => 'Fcc Doctor Uuid',
			'uuid' => 'Uuid',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('day',$this->day,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('fcc_doctor_uuid',$this->fcc_doctor_uuid,true);
		$criteria->compare('uuid',$this->uuid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FccTimetable the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
