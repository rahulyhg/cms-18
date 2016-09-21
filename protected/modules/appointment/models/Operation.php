<?php

/**
 * This is the model class for table "{{operation}}".
 *
 * The followings are the available columns in table '{{operation}}':
 * @property integer $id
 * @property string $admission_hospital
 * @property string $where_in_hospital
 * @property string $bed_type
 * @property string $anaesthesia_type
 * @property string $anaesthetist
 * @property string $preparation
 * @property string $surgical_assistant
 * @property string $operation_type
 */
class Operation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_operation}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('admission_hospital, where_in_hospital', 'length', 'max'=>60),
			array('bed_type, anaesthesia_type, anaesthetist, preparation, surgical_assistant', 'length', 'max'=>45),
			array('operation_type', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, admission_hospital, where_in_hospital, bed_type, anaesthesia_type, anaesthetist, preparation, surgical_assistant, operation_type', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'admission_hospital' => 'Admission Hospital',
			'where_in_hospital' => 'Where In Hospital',
			'bed_type' => 'Bed Type',
			'anaesthesia_type' => 'Anaesthesia Type',
			'anaesthetist' => 'Anaesthetist',
			'preparation' => 'Preparation',
			'surgical_assistant' => 'Surgical Assistant',
			'operation_type' => 'Operation Type',
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
		$criteria->compare('admission_hospital',$this->admission_hospital,true);
		$criteria->compare('where_in_hospital',$this->where_in_hospital,true);
		$criteria->compare('bed_type',$this->bed_type,true);
		$criteria->compare('anaesthesia_type',$this->anaesthesia_type,true);
		$criteria->compare('anaesthetist',$this->anaesthetist,true);
		$criteria->compare('preparation',$this->preparation,true);
		$criteria->compare('surgical_assistant',$this->surgical_assistant,true);
		$criteria->compare('operation_type',$this->operation_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Operation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
