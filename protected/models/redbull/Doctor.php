<?php

/**
 * This is the model class for table "mydb.{{doctor}}".
 *
 * The followings are the available columns in table '{{doctor}}':
 * @property integer $id
 * @property string $name
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property Calendar[] $calendars
 */
class Doctor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_doctor}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'length', 'max'=>100),
            array('name', 'required', 'message'=>Yii::t('validation','Please provide doctor\'s name')),
            array('name, active', 'safe', 'on'=>'update'),
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
            'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => Yii::t('model', 'Doctor Name'),
			'active' => Yii::t('model', 'Active'),
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
		$criteria=new CDbCriteria;
		$criteria->order='default desc';
                $criteria->order='name';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Doctor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

//    public function afterSave() {
//        if (!$this->isNewRecord) {
//            $user = User::model()->findByPk($this->user_id);
//            if ($user) {
//                $user->saveAttributes(array('name'=>$this->name));
//                $user->saveAttributes(array('active'=>$this->active));
//            }
//        }
//    }

    public function getFullName() {
        return (!empty($this->salutation)?($this->salutation.' '):'').$this->name;
    }

    
    public function getDoctorById($id)
    {
       $doctor = Doctor::model()->find('user_id=' . $id . '');
       if(empty($doctor) ) {
          
           return '';
       }
     
       return $doctor;
    }

    
    public function getDoctorID($id) {
        $model = Doctor::model()->find('user_id=' . $id . '');
        if (!empty($model)) {
            return $model;
        }
        return null;
    }

    public function loadAll() {
        $models = self::model()->findAll(array(
            'order' => 'name',
            'condition' => 'active = 1'
        ));
        return CHtml::listData($models, 'id', 'name');
    }
    
    public function getDoctorList()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('active', 1);
        $criteria->order = 'is_default desc, name';
        $doctorList = Doctor::model()->findAll($criteria);
        return $doctorList;
    }
    
    public static function getDoctorDropdown() {
        $criteria = new CDbCriteria;
        $criteria->compare('active', 1);
        $criteria->order = 'is_default desc, name';
        $model = Doctor::model()->findAll($criteria);
        $list = CHtml::listData($model, 'id', 'name');
        return $list;
    }
    
    

}
