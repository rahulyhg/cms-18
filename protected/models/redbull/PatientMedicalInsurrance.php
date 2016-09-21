<?php

/**
 * This is the model class for table "{{_patient_medical_insurrance}}".
 *
 * The followings are the available columns in table '{{_patient_medical_insurrance}}':
 * @property integer $id
 * @property string $patient_id
 * @property string $company_name
 * @property string $department
 * @property string $staff_no
 * @property string $entitlement_from
 * @property string $entitlement_to
 * @property integer $to_bill_insurrance
 * @property string $insurrance_name
 * @property integer $follow
 * @property integer $copayment
 * @property string $copayment_amount_from
 * @property string $copayment_amount_to
 */
class PatientMedicalInsurrance extends _BaseModel {
		
		/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_patient_medical_insurrance}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_name, department, staff_no', 'required'),
			array('to_bill_insurrance, follow, copayment', 'numerical', 'integerOnly'=>true),
			array('patient_id', 'length', 'max'=>20),
			array('company_name, department, insurrance_name', 'length', 'max'=>255),
			array('staff_no', 'length', 'max'=>100),
			array('entitlement_from, entitlement_to, copayment_amount_from, copayment_amount_to', 'length', 'max'=>16),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, patient_id, company_name, department, staff_no, entitlement_from, entitlement_to, to_bill_insurrance, insurrance_name, follow, copayment, copayment_amount_from, copayment_amount_to', 'safe'),
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
			'id' => Yii::t('translation','ID'),
			'patient_id' => Yii::t('translation','Patient'),
			'company_name' => Yii::t('translation','Company Name'),
			'department' => Yii::t('translation','Department'),
			'staff_no' => Yii::t('translation','Staff No'),
			'entitlement_from' => Yii::t('translation','Entitlement From'),
			'entitlement_to' => Yii::t('translation','Entitlement To'),
			'to_bill_insurrance' => Yii::t('translation','To Bill Insurrance'),
			'insurrance_name' => Yii::t('translation','Insurrance Name'),
			'follow' => Yii::t('translation','Follow'),
			'copayment' => Yii::t('translation','Copayment'),
			'copayment_amount_from' => Yii::t('translation','Copayment Amount From'),
			'copayment_amount_to' => Yii::t('translation','Copayment Amount To'),
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
		$criteria->compare('patient_id',$this->patient_id,true);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('department',$this->department,true);
		$criteria->compare('staff_no',$this->staff_no,true);
		$criteria->compare('entitlement_from',$this->entitlement_from,true);
		$criteria->compare('entitlement_to',$this->entitlement_to,true);
		$criteria->compare('to_bill_insurrance',$this->to_bill_insurrance);
		$criteria->compare('insurrance_name',$this->insurrance_name,true);
		$criteria->compare('follow',$this->follow);
		$criteria->compare('copayment',$this->copayment);
		$criteria->compare('copayment_amount_from',$this->copayment_amount_from,true);
		$criteria->compare('copayment_amount_to',$this->copayment_amount_to,true);
					
		 
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
	 * @return PatientMedicalInsurrance the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function nextOrderNumber()
	{
		return PatientMedicalInsurrance::model()->count() + 1;
	}

	public function getListBaseOnPatient($patient_id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria=new CDbCriteria;
		$criteria->compare('patient_id',$patient_id);
		 
		return self::model()->findAll($criteria);
	}

	public function getDefaultInsurrance($patient_id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria=new CDbCriteria;
		$criteria->compare('t.patient_id',$patient_id);
		$criteria->compare('t.default', STATUS_ACTIVE);
		$criteria->limit = 1;
		 	
		return self::model()->find($criteria);
	}

	public function checkExist($patient_id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria=new CDbCriteria;
		$criteria->compare('t.patient_id',$patient_id);
		$criteria->limit = 1;
		 	
		$model = self::model()->find($criteria);
		return isset($model) ? 1 : 0;
	}

    public function clear($patient) {
        $criteria=new CDbCriteria;
        $criteria->compare('patient_id',$patient->id);
        $this->deleteAll($criteria);
    }	
}
