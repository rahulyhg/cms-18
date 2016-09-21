<?php

/**
 * This is the model class for table "{{_patient_payment_history}}".
 *
 * The followings are the available columns in table '{{_patient_payment_history}}':
 * @property integer $id
 * @property integer $patient_id
 * @property string $invoice_date
 * @property string $invoice_no
 * @property string $amount
 * @property string $amount_paid
 * @property string $payment_date
 * @property string $comment
 * @property integer $status
 */
class PatientPaymentHistory extends _BaseModel {
		
		/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_patient_payment_history}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('patient_id, status', 'numerical', 'integerOnly'=>true),
			array('invoice_no', 'length', 'max'=>100),
			array('amount, amount_paid', 'length', 'max'=>16),
			array('invoice_date, payment_date, comment', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, patient_id, invoice_date, invoice_no, amount, amount_paid, payment_date, comment, status', 'safe', 'on'=>'search'),
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
			'invoice_date' => Yii::t('translation','Invoice Date'),
			'invoice_no' => Yii::t('translation','Invoice No'),
			'amount' => Yii::t('translation','Amount'),
			'amount_paid' => Yii::t('translation','Amount Paid'),
			'payment_date' => Yii::t('translation','Payment Date'),
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
		$criteria->compare('invoice_date',$this->invoice_date,true);
		$criteria->compare('invoice_no',$this->invoice_no,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('amount_paid',$this->amount_paid,true);
		$criteria->compare('payment_date',$this->payment_date,true);
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
	 * @return PatientPaymentHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function nextOrderNumber()
	{
		return PatientPaymentHistory::model()->count() + 1;
	}

    public function clear($patient) {
        $criteria=new CDbCriteria;
        $criteria->compare('patient_id',$patient->id);
        $this->deleteAll($criteria);
    }	
}
