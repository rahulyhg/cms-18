<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $doctor
 * @property integer $active
 * @property string $name
 * @property string $contact
 * @property string $email
 */
class User extends CActiveRecord
{
    public $password2;
    public static $role = array('1' => 'Manager', '2' => 'Staff');

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_users}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username', 'required', 'message'=>Yii::t('validation', 'Please provide username.')),
            array('password', 'required', 'on' => 'insert', 'message'=>Yii::t('validation', 'Please provide password.')),
            array('username, email', 'unique', 'message'=>Yii::t('validation', 'Username exists. Please choose another one.')),
            array('email','email','message'=>Yii::t('validation', 'Email address is invalid.')),
            array('password2', 'compare', 'compareAttribute'=>'password', 'message'=>Yii::t('validation','Password confirmation is incorrect.')),

			array('doctor, active, role', 'numerical', 'integerOnly'=>true),
			array('username, password, password2, name, email', 'length', 'max'=>45),
			array('contact', 'length', 'max'=>20),

            array('id, username, active, email', 'safe'),
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
                    'Doctor' => array(self::HAS_ONE, 'Doctor', 'user_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'username' => Yii::t('model', 'Username'),
			'password' => Yii::t('model', 'Password'),
            'password2' => Yii::t('model', 'Confirm Password'),
			'doctor' => Yii::t('model', 'Is Doctor'),
			'active' => Yii::t('model', 'Active'),
			'name' => Yii::t('model', 'Name'),
			'contact' => Yii::t('model', 'Contact'),
			'email' => Yii::t('model', 'Email'),
			'role' => Yii::t('model', 'Role'),
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function afterSave() {
        if (!$this->isNewRecord) {
            $doctor = Doctor::model()->findByAttributes(array('user_id'=>$this->id));

            if ($doctor) {
                $doctor->saveAttributes(array('name'=>$this->name));
                $doctor->saveAttributes(array('active'=>$this->active));
            }
        }
    }
}
