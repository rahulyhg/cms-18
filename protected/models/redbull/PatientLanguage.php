<?php

/**
 * This is the model class for table "{{_patient_language}}".
 *
 * The followings are the available columns in table '{{_patient_language}}':
 * @property integer $id
 * @property integer $patient_id
 * @property integer $language_id
 */
class PatientLanguage extends _BaseModel {
		
		/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_patient_language}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('patient_id, language_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, patient_id, language_id', 'safe', 'on'=>'search'),
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
			'language' => array(self::BELONGS_TO, 'Language', 'language_id'),
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
			'language_id' => Yii::t('translation','Language'),
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
		$criteria->compare('language_id',$this->language_id);
					
		 
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
	 * @return PatientLanguage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function nextOrderNumber()
	{
		return PatientLanguage::model()->count() + 1;
	}

	public function deleteAllPatientLanguages($patient)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('patient_id',$patient->id);
		$this->deleteAll($criteria);
	}
        public function  getPatientLanguegesName($patient)
        {
             
		$model=  PatientLanguage::model()->findAll('patient_id='.$patient.'');
                $langueges=array();
                foreach ($model as $data)
                {
                   
                   $langueges[]= $data->language->name;
                   
                }
                return implode('+', $langueges);
        }

	public function getAllPatientLanguages($patient_id)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('patient_id',$patient_id);
		return $this->findAll($criteria);
	}
}
