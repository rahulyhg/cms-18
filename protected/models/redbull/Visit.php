<?php

/**
 * This is the model class for table "mydb.{{visit}}".
 *
 * The followings are the available columns in table '{{visit}}':
 * @property integer $id
 * @property integer $walkin
 * @property integer $appointment_id
 * @property string $time_in
 * @property string $status
 * @property string $billed
 * @property string $cash
 * @property string $nets
 * @property string $card
 * @property integer $patient_id
 *
 * The followings are the available model relations:
 * @property Patient $patient
 */
class Visit extends CActiveRecord
{
    public $timein;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_visit}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('walkin, appointment_id, patient_id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>8),
			array('billed, cash, nets, card', 'length', 'max'=>10),
			array('time_in, note', 'safe'),
            array('time_in','required','message'=>Yii::t('validation','Please provide time in')),
            array('billed','checkBillTotal'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, walkin, appointment_id, time_in, status, billed, cash, nets, card, patient_id', 'safe', 'on'=>'search'),
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
            'appointment' => array(self::BELONGS_TO, 'Appointment', 'appointment_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'walkin' => 'Walkin',
			'time_in' => Yii::t('model','Time In'),
			'status' => Yii::t('model','Status'),
			'billed' => Yii::t('model','Billed'),
			'cash' => Yii::t('model','Cash'),
			'nets' => Yii::t('model','Nets'),
			'card' => Yii::t('model','Card'),
            'appointment_id'=> Yii::t('model','Appointment'),
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
	public function today()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

//		$criteria->addBetweenCondition('time_in',date('Y-m-d 00:00:00'),date('Y-m-d 23:59:59'));
		$criteria->addCondition('status <> :status');
        $criteria->params=array(':status'=>'complete');
        $criteria->order = 'time_in desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function countData() {
        $result=array(
            'paid'=>$this->count('status=:status',array(':status'=>'complete')),
            'seen'=>$this->count('status=:status',array(':status'=>'seen')),
            'waiting'=>$this->count('status=:status',array(':status'=>'waiting')),
            'cancelled'=>$this->count('status=:status',array(':status'=>'cancelled'))
        );

        return $result;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Visit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function checkBillTotal($attribute,$param) {
        if($this->$attribute != $this->cash+$this->nets+$this->card)
            $this->addError($attribute, Yii::t('validation','Bill total is not tally. Please recheck'));
    }
}
