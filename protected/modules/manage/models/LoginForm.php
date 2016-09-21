<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;
	public $loginError;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
		// username and password are required
		//array('username, password', 'required'),
		array('username', 'required'),
		// rememberMe needs to be a boolean
		array('rememberMe', 'boolean'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>Yii::t('form', 'Remember me next time'),
		);
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if (!$this->validate()) return;
			
		$identity = new AdminIdentity($this->username, $this->password);
		if(!$identity->authenticate()) {
			$this->addError('', $identity->errorMessage);
			return false;
		}
		
		if ($this->rememberMe) {
			$duration = 3600*24*30; // 30 days
			Yii::app()->user->login($identity, $duration);
		}
		else {
			Yii::app()->user->login($identity);
		}
		return true;
	}
}
