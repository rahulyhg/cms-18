<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $nick_name;
    public $username;
	public $password;
	public $rememberMe;
    public $role_id;
    public $email;
    public $verifyCode;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that nick_name and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// nick_name and password are required
			array('username, password', 'required'),
            array('username, password', 'safe'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('username', 'authenticate'),
            //array('email, password, verifyCode','required','on'=>'captchaRequired'),
            //array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(), 'on'=>'captchaRequired'),
            //array('email', 'email'),
        );
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me',
		);
	}

        public function beforeValidate() {
            $this->email = trim($this->email);
            return parent::beforeValidate();
        }
        
	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors()) // we only want to authenticate when no input errors
		{                  
            $this->_identity=new UserIdentity($this->username,$this->password);

            $this->_identity->authenticate();

            switch($this->_identity->errorCode)
            {
                case UserIdentity::ERROR_NONE:
                    $duration = $this->rememberMe ? 3600*24*30 : 0; // 30 days
                    Yii::app()->user->login($this->_identity,$duration);
                    break;
                case UserIdentity::ERROR_FAILURE_MAX_TIMES:
                    $times = Yii::app()->setting->getItem('login_limit_times');
                    $time_refresh = Yii::app()->setting->getItem('time_refresh_login');
                    $this->addError("username","You can't login more than $times times. Wait $time_refresh minutes!.");
                    break;
                case UserIdentity::ERROR_USERNAME_INVALID:
                    $this->addError("username","Username is not valid.");
                    break;
                case UserIdentity::ERROR_USERNAME_BLOCKED:
                    $this->addError("username","Account has been blocked.");
                    break;
                /*
                case UserIdentity::ERROR_STATUS_NOTACTIV:
                    $this->addError("status",Yii::t("UserModule.user", "Votre compte n'est pas activer."));
                    break;
                case UserIdentity::ERROR_STATUS_BAN:
                    $this->addError("status",Yii::t("UserModule.user", "Votre compte est banni."));
                    break;
                */
                case UserIdentity::ERROR_PASSWORD_INVALID:
                    $this->addError("password","Password is wrong. Please enter password again.");
                    break;
            }
		}
	}

}
