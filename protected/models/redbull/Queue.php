<?php

/**
 * This is the model class for table "{{_queue}}".
 *
 * The followings are the available columns in table '{{_queue}}':
 * @property integer $id
 * @property string $time_in
 * @property string $time_out
 * @property string $patient_name
 * @property integer $seen
 * @property string $dispense
 * @property string $bill
 * @property string $paid
 * @property string $contact_insurance
 * @property string $height
 * @property string $weight
 * @property string $comments
 * @property integer $status
 * @property integer $doctor_id
 */
class Queue extends _BaseModel {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{_queue}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('time_in, patient_id, patient_name, seen, doctor_id', 'required'),
            //array('time_in', "checkExistedQueue"),
            array('seen, status, doctor_id,patient_id', 'numerical', 'integerOnly' => true),
            array('patient_name, dispense, contact_insurance', 'length', 'max' => 255),
            array('bill, paid, height, weight', 'length', 'max' => 16),
            array('time_in, time_out, comments, patient_id,patient_name, seen, dispense, bill, paid,contact_insurance, height, weight, comments, status, doctor_id, follow_up', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, time_in, time_out, patient_id,patient_name, seen, dispense, bill, paid, '
                . 'contact_insurance, height, weight, comments, status, doctor_id, created_date', 'safe', 'on' => 'search'),
        );
    }
    
    public function checkExistedQueue($attribute, $params)
	{
        if ($this->isNewRecord)
        {
            $criteria = new CDbCriteria;
            $criteria->compare('time_in', $this->time_in);
            $criteria->compare('date(created_date)', date("Y-m-d"));
            $result = Queue::model()->find($criteria);
            $lb = $this->getAttributeLabel($attribute);
            if ($result)
            {
                $this->addError('endDate', "$lb $this->time_in existed in system already. Please choose another"); 
            }
        }
        
	}

    /**
     * @return array relational rules
     * .
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'doctor' => array(self::BELONGS_TO, 'Users', 'doctor_id'),
            'patient' => array(self::BELONGS_TO, 'Patient', 'patient_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('translation', 'ID'),
            'time_in' => Yii::t('translation', 'Time In'),
            'time_out' => Yii::t('translation', 'Time Out'),
            'patient_name' => Yii::t('translation', 'Patient Name'),
            'seen' => Yii::t('translation', 'Seen'),
            'dispense' => Yii::t('translation', 'Dispense'),
            'bill' => Yii::t('translation', 'Bill'),
            'paid' => Yii::t('translation', 'Paid'),
            'contact_insurance' => Yii::t('translation', 'Contact Insurance'),
            'height' => Yii::t('translation', 'Height'),
            'weight' => Yii::t('translation', 'Weight'),
            'comments' => Yii::t('translation', 'Comments'),
            'status' => Yii::t('translation', 'Status'),
            'doctor_id' => Yii::t('translation', 'Doctor'),
            'patient_id' => Yii::t('translation', 'Patient ID'),
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
    public function search($paging = true) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        if ($paging)
        {
            $criteria = new CDbCriteria;

            $criteria->compare('id', $this->id);
            $criteria->compare('time_in', $this->time_in, true);
            $criteria->compare('time_out', $this->time_out, true);
            $criteria->compare('patient_name', $this->patient_name, true);
            $criteria->compare('seen', $this->seen);
            $criteria->compare('dispense', $this->dispense, true);
            $criteria->compare('bill', $this->bill, true);
            $criteria->compare('paid', $this->paid, true);
            $criteria->compare('contact_insurance', $this->contact_insurance, true);
            $criteria->compare('height', $this->height, true);
            $criteria->compare('weight', $this->weight, true);
            $criteria->compare('comments', $this->comments, true);
            $criteria->compare('status', $this->status);
            $criteria->compare('doctor_id', $this->doctor_id);
            $criteria->compare('patient_id', $this->patient_id);
            if ($this->created_date != '')
            {
                $this->created_date = str_replace('/', '-', $this->created_date);
                $this->created_date = date("Y-m-d", strtotime($this->created_date));
                $criteria->addCondition('date(created_date) = "' . $this->created_date . '"');
            }
            Yii::app()->session['queue_criteria'] = $criteria;
        }
        else
        {
            $criteria = Yii::app()->session['queue_criteria'];
        }
        $sort = new CSort();

        $sort->attributes = array(
            'created_date' => array(
                'asc' => 't.created_date',
                'desc' => 't.created_date desc',
                'default' => 'desc',
            ),
        );
		$sort->defaultOrder = 't.created_date desc';
        
        if ($paging)
        {
            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                        'pagination' => array(
                            'pageSize' => Yii::app()->params['defaultPageSize'],
                        ),
                        'sort' => $sort
                    ));
        }
        else 
        {
            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                        'pagination' => false,
                        'sort' => $sort
                    ));
        }
    }

    public function activate() {
        $this->status = 1;
        $this->update();
    }

    public function deactivate() {
        $this->status = 0;
        $this->update();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Queue the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function nextOrderNumber() {
        return Queue::model()->count() + 1;
    }

    public function deleteQueues($selectedQueues)
    {
        $criteria = new CDbCriteria;
        $criteria->addInCondition('id', $selectedQueues);
        Queue::model()->deleteAll($criteria);
    }
    public function getQueuesByDoctorId($doctorId)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('status', 1);
        //$criteria->compare('doctor_id', $doctorId);
        $criteria->addCondition('DATE(created_date) = "' . date("Y-m-d") . '"');
        return Queue::model()->findAll($criteria);
    }
    
    


    public function getQueueDoctorID($doctorId){
        $criteria = new CDbCriteria;
        $criteria->compare('status', 1);
        $criteria->compare('doctor_id', $doctorId);
        $model = Queue::model()->findAll($criteria);
        if(!empty($model)) {
            foreach ($model as $item) {
                return $item->id;
            }
        }
        return null;
    }
    
    public function beforeSave()
    {
        if (parent::beforeSave())
		{
			if ($this->isNewRecord)
            {
				$this->created_date = date('Y-m-d H:i:s');
                $this->created_by = Yii::app()->user->id;
            }
			else
            {
				$this->modified_by = time();
            }
			
		}
		return true;
    }
    
    public function getDoctor($id)
    {
        $doctor = User::model()->findByPk($id);
        if(empty($doctor)) {
           return null; 
        }
        return $doctor;
    }
}
