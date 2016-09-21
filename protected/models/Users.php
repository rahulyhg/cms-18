<?php

/**
 * This is the model class for table "{{_users}}".
 *
 * The followings are the available columns in table '{{_users}}':
 * @property string $id
 * @property string $email
 * @property string $password_hash
 * @property string $temp_password
 * @property string $first_name
 * @property string $last_name
 * @property string $first_char
 * @property integer $login_attemp
 * @property string $created_date
 * @property string $last_logged_in
 * @property string $ip_address
 * @property integer $role_id
 * @property integer $application_id
 * @property integer $approved_status
 * @property string $gender
 * @property string $area_code_id
 * @property string $phone
 * @property string $verify_code
 * @property string $temp_appointment
 * @property string $i_am_doctor
 * @property integer coach_location_id
 * 
 * The followings are the available model relations:
 * @property Appointment[] $appointments
 * @property Booking[] $bookings
 * @property Doctor[] $doctors
 * @property DoctorPictures[] $doctorPictures
 * @property DoctorSpecialty[] $doctorSpecialties
 * @property InsurancesAccept[] $insurancesAccepts
 */
class Users extends _BaseModel
{

	public $password_confirm;
	/* for change pass in admin */
	public $currentPassword; //in form
	public $newPassword;
	public $agreeTermOfUse;
	public $recieveNewsletter;
	public $verifyCode;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

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
			//all module
            //
            //general
            
			array('username, email', 'required'),

//			array('agreeTermOfUse', 'required', 'on' => 'createMemberFE', 'message' => 'You have to agree the terms and condition to continue'),
			array('username, email', 'unique', 'on' => 'create, update'),
			array('password_confirm', 'compare', 'compareAttribute' => 'temp_password', 'on' => 'create'),
			array('temp_password', 'length', 'max' => 20, 'min' => 6),
			array('email', 'length', 'max' => 200),
			array('first_name, last_name', 'length', 'max' => 100),
			array('full_name', 'length', 'max' => 200),
			array('ip_address, phone', 'length', 'max' => 30),
			array('gender', 'length', 'max' => 6),
			array('verify_code', 'length', 'max' => 20),
			array('username', 'length', 'max' => 20),
			array('email', 'email', 'message' => 'Please enter a valid email.'),
			array('email', 'required', 'on' => 'forgotPassword'),
			array('username', 'match', 'pattern' => '/^[a-zA-Z\d_.]{2,30}$/i', 'message' => 'Username cannot include special characters', 'on' => 'createAdmin, editAdmin'),
			array('username, email', 'required', 'on' => 'createAdmin, editAdmin'),
			array('temp_password, password_confirm', 'required', 'on' => 'createAdmin, createDoctor'),
            array('full_name,salutation, phone', 'required', 'on' => 'createDoctor, updateDoctor'),
			array('password_confirm', 'compare', 'compareAttribute' => 'temp_password', 'on' => 'editAdmin, createAdmin, createDoctor, updateDoctor'),
			array('email', 'unique', 'message' => 'This email address existed', 'on' => 'editAdmin, createAdmin, createDoctor, updateDoctor'),
			array('temp_password, password_confirm', 'length', 'min' => PASSW_LENGTH_MIN, 'max' => PASSW_LENGTH_MAX,
				'tooLong' => 'Password is too long (maximum is ' . PASSW_LENGTH_MAX . ' characters).',
				'tooShort' => 'Password is too short (minimum is ' . PASSW_LENGTH_MIN . ' characters).',
				'on' => 'createAdmin, editAdmin, createMember, updateMember, createMemberFE'),
			array('temp_password', 'checkDigit', 'on' => 'editAdmin, createAdmin, createMember, updateMember, createMemberFE'),
			//change password session
            array('currentPassword, password_confirm, newPassword', 'length', 'min' => PASSW_LENGTH_MIN, 'max' => PASSW_LENGTH_MAX,
				'tooLong' => 'Password is too long (maximum is ' . PASSW_LENGTH_MAX . ' characters).',
				'tooShort' => 'Password is too short (minimum is ' . PASSW_LENGTH_MIN . ' characters).',
				'on' => 'changeMyPassword'),
			array('currentPassword, password_confirm, newPassword', 'required', 'on' => 'changeMyPassword'),
			array('password_confirm', 'compare', 'compareAttribute' => 'newPassword', 'on' => 'changeMyPassword'),
			array('currentPassword', 'comparePassword', 'on' => 'changeMyPassword'),
			array('newPassword', 'checkDigit', 'on' => 'changeMyPassword'),
            
            //FE user session 
			array('username, email, full_name, temp_password, password_confirm, verifyCode, phone', 'required', 'on' => 'createMember, createMemberFE'),
			array('verifyCode', 'captcha', 'message' => 'Verify Code is incorrect', 'on' => 'createMemberFE'),
			array('email, full_name', 'required', 'on' => 'updateMember'),
			array('phone', 'checkPhone', 'on' => 'createMember, updateMember, updateMyProfile'),
			array('email, full_name, phone', 'required', 'on' => 'updateMyProfile'),
			// array('full_name', 'required', 'on' => 'updateMyProfile'),
			//array('agreeTermOfUse', 'compare', 'compareValue' => true, 'message' => 'You have to agree the terms and condition to continue', 'on' => 'createMemberFE'),
			array('id, username, full_name, salutation, email, password_hash, newPassword, currentPassword, temp_password, first_name, last_name, login_attemp, created_date, '
				. 'last_logged_in, ip_address, role_id, application_id, status, gender, phone, verify_code, area_code_id, agreeTermOfUse, '
				. 'recieveNewsletter, company, address, province, city, postal_code, verifyCode', 'safe'),
		);
	}

	public function checkDigit($attribute, $params)
	{
		if ($this->$attribute != '')
		{
			$containsDigit = preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $this->$attribute);
			$lb = $this->getAttributeLabel($attribute);
			if (!$containsDigit)
				$this->addError($attribute, "$lb must be at least one letter and one number.");
		}
	}

	public function checkPhone($attribute, $params)
	{
		if ($this->$attribute != '')
		{
			$pattern = '/^[\(]?(\+)?(\d{0,3})[\)]?[\s]?[\-]?(\d{0,9})[\s]?[\-]?(\d{0,9})[\s]?[x]?(\d*)$/';
			$containsDigit = preg_match($pattern, $this->$attribute);
			$lb = $this->getAttributeLabel($attribute);
			if (!$containsDigit)
				$this->addError($attribute, "$lb must be numerical and  allow input (),+,-");
		}
	}

	public function compareEmail($attribute, $params)
	{
		if ($this->email_confirm != $this->$attribute)
		{
			$this->addError("email_confirm", "$this->email_confirm email is wrong.");
		}
	}

	public function comparePassword($attribute, $params)
	{
		if (!$this->hasErrors())
		{
			$lb = $this->getAttributeLabel($attribute);
			if (trim($attribute) == '')
				$this->addError($attribute, "$lb cannot be blank.");
			else
			{
				if (trim($this->password_hash) != md5(trim($this->$attribute)))
				{
					$this->addError($attribute, "$lb is wrong.");
				}
			}
		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'area_code' => array(self::BELONGS_TO, 'AreaCode', 'area_code_id'),
            'Doctor' => array(self::HAS_ONE, 'Doctor', 'user_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'email_confirm' => 'Confirm email',
			'password_hash' => 'Password',
			'temp_password' => 'Password',
			'password_confirm' => 'Confirm Password',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'full_name' => 'Full Name',
			'login_attemp' => 'Login Temp',
			'created_date' => 'Created Date',
			'last_logged_in' => 'Last Logged In',
			'ip_address' => 'Ip Address',
			'role_id' => 'Role',
			'application_id' => 'Application',
			'status' => 'Status',
			'gender' => 'Gender',
			'phone' => 'Phone',
			'verify_code' => 'Verify Code',
			'full_name' => 'Full Name',
			'area_code_id' => 'Country',
			'currentPassword' => 'Current Password',
			'newPassword' => 'New password',
			'company' => 'Company Name',
			'address' => 'Address',
			'province' => 'Province',
			'city' => 'City',
			'postal_code' => 'Postal Code',
			'profile_imge' => Yii::t('translation', 'Profile Image'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($criteria = NULL)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		if ($criteria == NULL)
			$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id, true);
		$criteria->compare('t.email', $this->email, true);
		$criteria->compare('t.username', $this->username, true);
		$criteria->compare('t.password_hash', $this->password_hash, true);
		$criteria->compare('t.temp_password', $this->temp_password, true);
		$criteria->compare('t.first_name', $this->first_name, true);
		$criteria->compare('t.last_name', $this->last_name, true);
		$criteria->compare('t.login_attemp', $this->login_attemp);
		$criteria->compare('t.created_date', $this->created_date, true);
		$criteria->compare('t.last_logged_in', $this->last_logged_in, true);
		$criteria->compare('t.ip_address', $this->ip_address, true);
		$criteria->compare('t.role_id', $this->role_id);
		$criteria->compare('t.full_name', $this->full_name);
		$criteria->addCondition('t.role_id <> 2');
		$criteria->compare('t.application_id', $this->application_id);
		$criteria->compare('t.status', $this->status);
		$criteria->compare('t.gender', $this->gender, true);
		$criteria->compare('t.phone', $this->phone, true);
		$criteria->compare('t.verify_code', $this->verify_code, true);
		$criteria->order = "t.created_date desc";

		$_SESSION['data_user-excel'] = new CActiveDataProvider($this, array(
			'pagination' => false,
			'criteria' => $criteria,
		));

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function searchAdmin($criteria = NULL)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.


		if ($criteria == NULL)
			$criteria = new CDbCriteria;
		$criteria->select = 't.first_name, t.last_name, t.status, t.email, t.phone, t.created_date, t.id';
		$criteria->compare('t.id', $this->id, true);
		$criteria->compare('t.username', $this->username, true);
		$criteria->compare('t.email', $this->email, true);
		$criteria->compare('t.password_hash', $this->password_hash, true);
		$criteria->compare('t.temp_password', $this->temp_password, true);
		$criteria->compare('t.first_name', $this->first_name, true);
		$criteria->compare('t.last_name', $this->last_name, true);
		$criteria->compare('t.login_attemp', $this->login_attemp);
		$criteria->compare('t.created_date', $this->created_date, true);
		$criteria->compare('t.last_logged_in', $this->last_logged_in, true);
		$criteria->compare('t.ip_address', $this->ip_address, true);
		$criteria->compare('t.role_id', 2);
		$criteria->compare('t.application_id', 1);
		$criteria->compare('t.status', $this->status);
		$criteria->compare('t.gender', $this->gender, true);
		$criteria->compare('t.phone', $this->phone, true);
		$criteria->compare('t.verify_code', $this->verify_code, true);
		$criteria->compare('t.password_confirm', $this->password_confirm, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function defaultScope()
	{
		return array(
			//'condition'=>'',
		);
	}

	public function unlinkAllFileInFolder($path)
	{
		$files = glob($path . '/*'); // get all file names
		foreach ($files as $file)
		{ // iterate files
			if (is_file($file))
				unlink($file); // delete file
		}
	}

	public function beforeDelete()
	{
		try
		{
			
		}
		catch (Exception $ex)
		{
			echo $ex->getMessage();
			die;
		}

		return true;
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

	public function getInforUser($id = null, $name = null)
	{
		$id = (int) $id;
		$name = trim($name);
		if (empty($id))
			return;
		if (!empty($name))
			$result = Users::model()->findByPk($id)->$name;
		else
			$result = Users::model()->findByPk($id);
		return $result;
	}

	public static function loadItems($emptyOption = false)
	{
		$_items = array();
		if ($emptyOption)
			$_items[""] = "";
		$model = self::model()->findByPk(Yii::app()->user->getId());
		$_items[$model->id] = $model->email;
		return $_items;
	}

	public static function generateKey($user)
	{
		if (empty($user->email))
			$user->email = '';
		return md5($user->id . $user->email);
	}

	public static function findByVerifyCode($verify_code)
	{
		return Users::model()->find('verify_code=' . $verify_code . '');
	}

	public static function getUsernameById($id)
	{
		$model = self::model()->findByPk($id);
		if ($model)
			return $model->username;
		return null;
	}

	public static function getEmailById($id)
	{
		$model = self::model()->findByPk($id);
		if ($model)
			return $model->email;
		return null;
	}

	public static function isExistEmail($email, $ignore_id = NULL)
	{
		$criteria = new CDbCriteria;
		if ($ignore_id != NULL && $ignore_id != '')
			$criteria->compare('id', '<>' . $ignore_id);
		$criteria->addCondition('email="' . $email . '"');
		$iCount = self::model()->count($criteria);
		if ($iCount > 0)
			return true;
		return false;
	}
    
    public function getAllMember()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('status', 1);
        $criteria->compare('role_id', 3);
        $criteria->order = "full_name asc";
        return Users::model()->findAll($criteria);
    }

    
	public static function checkVerifyCode($verify_code)
	{
		$count = Users::model()->count('verify_code=' . $verify_code . '');
		if ($count > 0)
		{
			$verify_code = self::checkVerifyCode(rand(100000, 1000000));
			return $verify_code;
		}
		else
			return $verify_code;
	}

	protected function beforeSave()
	{

		if ($this->isNewRecord)
		{
			$this->created_date = date('Y-m-d H:i:s');
			$this->password_hash = md5($this->temp_password);
			
		}


		return parent::beforeSave();
	}

}
