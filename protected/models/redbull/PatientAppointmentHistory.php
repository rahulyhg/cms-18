<?php

/**
 * This is the model class for table "{{_patient_appointment_history}}".
 *
 * The followings are the available columns in table '{{_patient_appointment_history}}':
 * @property integer $id
 * @property integer $patient_id
 * @property string $appointment_date
 * @property string $reason
 * @property integer $turn_up
 * @property string $comment
 * @property integer $status
 */
class PatientAppointmentHistory extends _BaseModel {
		
		/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_patient_appointment_history}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('reason, comment, turn_up', 'required'),
			array('patient_id, turn_up, status', 'numerical', 'integerOnly'=>true),
			array('reason', 'length', 'max'=>500),
			array('appointment_date, comment', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, patient_id, appointment_date, reason, turn_up, comment, status', 'safe', 'on'=>'search'),
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
			'appointment_date' => Yii::t('translation','Appointment Date'),
			'reason' => Yii::t('translation','Reason'),
			'turn_up' => Yii::t('translation','Turn Up Yes/No'),
			'comment' => Yii::t('translation','comment'),
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
		$criteria->compare('appointment_date',$this->appointment_date,true);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('turn_up',$this->turn_up);
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
	 * @return PatientAppointmentHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function nextOrderNumber()
	{
		return PatientAppointmentHistory::model()->count() + 1;
	}

	public function getListBaseOnPatient($patient_id, $return = false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('patient_id',$this->patient_id);
		$criteria->compare('status', STATUS_ACTIVE);
		 
		if ($return) {
		 	return $this->findAll($criteria);
	 	}
		 else{
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>array(
	                'pageSize'=> Yii::app()->params['defaultPageSize'],
	            ),
			));
		}
	}

    public function clear($patient) {
        $criteria=new CDbCriteria;
        $criteria->compare('patient_id',$patient->id);
        $this->deleteAll($criteria);
    }	
}
