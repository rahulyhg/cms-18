<?php

/**
 * This is the model class for table "{{_patient_insurrance_card}}".
 *
 * The followings are the available columns in table '{{_patient_insurrance_card}}':
 * @property integer $id
 * @property integer $patient_id
 * @property string $name
 */
class PatientInsurranceCard extends _BaseModel {
		
		/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_patient_insurrance_card}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('patient_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, patient_id, name', 'safe', 'on'=>'search'),
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
			'patient' => array(self::BELONGS_TO, 'Patient', 'patient_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('translation','ID'),
			'patient_id' => Yii::t('translation','Patient'),
			'name' => Yii::t('translation','Name'),
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
		$criteria->compare('patient_id',$this->patient_id);
		$criteria->compare('name',$this->name,true);
					
		 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                'pageSize'=> Yii::app()->params['defaultPageSize'],
            ),
		));
	}

	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PatientInsurranceCard the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function nextOrderNumber()
	{
		return PatientInsurranceCard::model()->count() + 1;
	}

	public function getDataBaseOnPatientInsurrance($patient_id, $patient_medical_insurrance_id)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('patient_id',$patient_id);
		$criteria->compare('patient_medical_insurrance_id',$patient_medical_insurrance_id);
		 
		return self::model()->findAll($criteria);
	}	

    public function clear($patient) {
        $criteria=new CDbCriteria;
        $criteria->compare('patient_id',$patient->id);
        $this->deleteAll($criteria);
    }	

    public function beforeDelete() {
        $path = Yii::getPathOfAlias("webroot").'/upload/patient/'.$this->patient_id.'/insurrance_card/'; // Upload directory
        MyFunctionCustom::deleteAllChild($path, $this->name);

        return parent::beforeDelete();
    }    
}
