<?php

/**
 * This is the model class for table "{{_patient_depensing}}".
 *
 * The followings are the available columns in table '{{_patient_depensing}}':
 * @property integer $id
 * @property integer $patient_id
 * @property string $date
 * @property string $drug_dispensed
 * @property integer $quanlity
 * @property string $selling_price
 * @property string $comment
 * @property integer $status
 */
class PatientDepensing extends _BaseModel {
		
		/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_patient_depensing}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('patient_id, quanlity, status', 'numerical', 'integerOnly'=>true),
			array('drug_dispensed', 'length', 'max'=>255),
			array('selling_price', 'length', 'max'=>16),
			array('date, comment', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, patient_id, date, drug_dispensed, quanlity, selling_price, comment, status', 'safe', 'on'=>'search'),
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
			'date' => Yii::t('translation','Date'),
			'drug_dispensed' => Yii::t('translation','Drug Dispensed'),
			'quanlity' => Yii::t('translation','Quanlity'),
			'selling_price' => Yii::t('translation','Selling Price'),
			'comment' => Yii::t('translation','Comments'),
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
		$criteria->compare('date',$this->date,true);
		$criteria->compare('drug_dispensed',$this->drug_dispensed,true);
		$criteria->compare('quanlity',$this->quanlity);
		$criteria->compare('selling_price',$this->selling_price,true);
		$criteria->compare('comment',$this->comment,true);
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
	 * @return PatientDepensing the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function nextOrderNumber()
	{
		return PatientDepensing::model()->count() + 1;
	}

    public function clear($patient) {
        $criteria=new CDbCriteria;
        $criteria->compare('patient_id',$patient->id);
        $this->deleteAll($criteria);
    }	
}
