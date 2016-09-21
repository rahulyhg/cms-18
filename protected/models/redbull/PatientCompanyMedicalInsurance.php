<?php

/**
 * This is the model class for table "{{_patient_company_medical_insurance}}".
 *
 * The followings are the available columns in table '{{_patient_company_medical_insurance}}':
 * @property integer $id
 * @property integer $patient_id
 * @property string $company_name
 * @property string $department
 * @property string $staff_no
 * @property string $entilement
 * @property integer $to_bill_insurance
 * @property integer $follow
 * @property integer $copayment
 * @property string $copayment_amount
 * @property string $insurance_name
 * @property string $insurance_card
 * @property string $insurance_referal_letter
 * @property string $insurance_document_a
 * @property integer $status
 */
class PatientCompanyMedicalInsurance extends _BaseModel {
		
		/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_patient_company_medical_insurance}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('patient_id, to_bill_insurance, follow, copayment, status', 'numerical', 'integerOnly'=>true),
			array('company_name, department, staff_no, insurance_name, insurance_card, insurance_referal_letter, insurance_document_a', 'length', 'max'=>255),
			array('entilement, copayment_amount', 'length', 'max'=>16),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, patient_id, company_name, department, staff_no, entilement, to_bill_insurance, follow, copayment, copayment_amount, insurance_name, insurance_card, insurance_referal_letter, insurance_document_a, status', 'safe', 'on'=>'search'),
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
			'entilement' => Yii::t('translation','Entilement'),
			'to_bill_insurance' => Yii::t('translation','To Bill Insurance'),
			'follow' => Yii::t('translation','Follow'),
			'copayment' => Yii::t('translation','Copayment'),
			'copayment_amount' => Yii::t('translation','Copayment Amount'),
			'insurance_name' => Yii::t('translation','Insurance Name'),
			'insurance_card' => Yii::t('translation','Insurance Card'),
			'insurance_referal_letter' => Yii::t('translation','Insurance Referal Letter'),
			'insurance_document_a' => Yii::t('translation','Insurance Document A'),
			'status' => Yii::t('translation','Status'),
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
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('department',$this->department,true);
		$criteria->compare('staff_no',$this->staff_no,true);
		$criteria->compare('entilement',$this->entilement,true);
		$criteria->compare('to_bill_insurance',$this->to_bill_insurance);
		$criteria->compare('follow',$this->follow);
		$criteria->compare('copayment',$this->copayment);
		$criteria->compare('copayment_amount',$this->copayment_amount,true);
		$criteria->compare('insurance_name',$this->insurance_name,true);
		$criteria->compare('insurance_card',$this->insurance_card,true);
		$criteria->compare('insurance_referal_letter',$this->insurance_referal_letter,true);
		$criteria->compare('insurance_document_a',$this->insurance_document_a,true);
		$criteria->compare('status',$this->status);
					
		 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                'pageSize'=> Yii::app()->params['defaultPageSize'],
            ),
		));
	}

	
	public function activate()
    {
        $this->status = 1;
        $this->update();
    }



    public function deactivate()
    {
        $this->status = 0;
        $this->update();
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PatientCompanyMedicalInsurance the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function nextOrderNumber()
	{
		return PatientCompanyMedicalInsurance::model()->count() + 1;
	}
}
