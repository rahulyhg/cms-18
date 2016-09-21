<?php

/**
 * This is the model class for table "{{_doctor_time}}".
 *
 * The followings are the available columns in table '{{_doctor_time}}':
 * @property string $id
 * @property string $doctor_id
 * @property string $day
 * @property string $time
 */
class DoctorTime extends CActiveRecord
{
	/**
	 * @var Address Localization model
	 * Retrieves from Address ID
	 */
	protected $_address;

	/**
	 * @var The Old day
	 * Using for comparing with newly set day
	 */
	protected $_day_old;

	/**
	 * @var The Old time
	 * Using for comparing with newly set time
	 */
	protected $_time_old;

	/**
	 * @var Is using text for content
	 */
	public $is_text;

	/**
	 * @var Text Content
	 */
	public $content_text;

	/**
	 * @var Address Content
	 */
	public $content_address;

	/**
	 * Content Getter
	 * @return Address Localization model
	 */
	public function getContent() {
		if (!empty($this->clinic_id)) {
			return  Clinic::model()->findByPk($this->clinic_id)->name;
		} else
			return $this->getEmptyContent();

	}

	/**
	 * Get Empty Content string
	 * @return string Empty string
	 */
	public function getEmptyContent() {
		return Yii::t('static', 'Not set');
	}

	/**
	 * Get Color ID
	 */
	public function getColorID() {
		if (!isset($this->is_text))
			return 0;
		elseif ($this->is_text === 1)
			return 4;
		else {
			$this->getContent();
			return $this->_address->order;
		}
	}

	public function getColorCode() {
		if (!empty($this->clinic_id)) {
			return  Clinic::model()->findByPk($this->clinic_id)->color_code2;
		} else
			return '#FFF';
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{_doctor_time}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('doctor_id, day, time', 'required'),
			array('day', 'uniqueTime'),
			//array('uuid', 'length', 'max'=>36),
			array('doctor_id,clinic_id', 'length', 'max'=>10),
			//array('content', 'length', 'max' => 255),
			array('day', 'length', 'max'=>20),
			array('time', 'length', 'max'=>2),
			array('is_text, content_text, content_address, content, comment', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, doctor_id, clinic_id, day, time', 'safe', 'on'=>'search'),
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
			'uuid' => 'UUID',
			'doctor_id' => Yii::t('static', 'Doctor'),
			'clinic_id' => Yii::t('static', 'Clinic'),
			'day' => Yii::t('static', 'Day'),
			'time' => Yii::t('static', 'Time'),
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('uuid',$this->uuid,true);
		$criteria->compare('doctor_id',$this->doctor_id,true);
		$criteria->compare('clinic_id',$this->clinic_id,true);
		$criteria->compare('day',$this->day,true);
		$criteria->compare('time',$this->time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DoctorTime the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Prepare data before validattion
	 */
	// protected function beforeValidate() {
	// 	if (!$this->_save_by_api)
	// 		$this->content = empty($this->is_text) ? $this->content_address : $this->content_text;
	// 	return parent::beforeValidate();
	// }

	// /**
	//  * Prepare data after find
	//  */
	// protected function afterFind() {
	// 	if (is_numeric($this->content)) {
	// 		$this->is_text = '';
	// 		$this->content_address = $this->content;
	// 	} else {
	// 		$this->is_text = 1;
	// 		$this->content_text = $this->content;
	// 	}
	// 	$this->_day_old = $this->day;
	// 	$this->_time_old = $this->time;
	// 	parent::afterFind();
	// }

	/**
	 * Retreives a list of model by doctor id
	 * @param int $doctorId doctor id
	 * @return array a list of DoctorTime models
	 */
	public function getTableDataByDoctor($id) {
		$criteria = new CDbCriteria;
		$criteria->compare('doctor_id', $id);
		$criteria->order = 'time ASC';

		$records = $this->findAll($criteria);
		$data = array(
			'Monday' => array(),
			'Tuesday' => array(),
			'Wednesday' => array(),
			'Thursday' => array(),
			'Friday' => array(),
			'Saturday' => array(),
			'Sunday' => array(),
		);
		foreach ($records as $item) {
			$data[$item->day][$item->time][] = $item;
		}
		return $data;
	}

	/**
	 * Check this time is existed
	 * @return boolean
	 */
	public function isTimeExisted() {
		$criteria = new CDbCriteria;
		$criteria->compare('day', $this->day);
		$criteria->compare('time', $this->time);
		$criteria->compare('doctor_id', $this->doctor_id);

		return $this->count($criteria) > 0;
	}

	public function doctorHasTime() {
		$models = self::model()->findAll(array(
		    'select'=>'t.doctor_id',
		    'group'=>'t.doctor_id',
		    'distinct'=>true,
		));
		$doctor_ids = array();
		foreach ($models as $m) {
			$doctor_ids[] = $m->doctor_id;
		}

		return $doctor_ids;
	}

		/**
	 * Validates Unique Date Time of the attribute of the object.
	 * If there is any error, the error message is added to the object.
	 * @param string $attribute the attribute being validated
	 * @param array $params Validation parmas
	 */
	public function uniqueTime($attribute, $params) {
		$isChanged = true;
		if (!$this->isNewRecord) {
			$isChanged = !($this->day === $this->_day_old && $this->time === $this->_time_old);
		}

		if ($isChanged && $this->isTimeExisted()) {
			$this->addError($attribute, Yii::t('static', 'The Doctor\'s {time} {day} AM is existed', array(
				'{day}' 	=> $this->day,
				'{time}' 	=> $this->time,
			 ) ) );
		}
	}

	public function checkNotWorkingDate($doctor_id,$datetime) {
        $day = date('l',strtotime($datetime));
        $time = date('A',strtotime($datetime));

        $criteria = new CDbCriteria;
        $criteria->compare('day', $day);
        $criteria->compare('time', $time);
        $criteria->compare('doctor_id', $doctor_id);
        $model = DoctorTime::model()->find($criteria);
        if (isset($model->clinic_id) && $model->clinic_id > 0) return 0;//Is working day
        else return 1;//Is not working day
	}

}
