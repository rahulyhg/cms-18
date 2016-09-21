<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    protected $_id;
    protected $_isAdmin = false;
	private $applicationId = 2;
	private $status = 1;
    public $role_id;
    const ERROR_USERNAME_BLOCKED=35; // verz custom by Nguyen Dung
    const ERROR_FAILURE_MAX_TIMES = 4;

	public function authenticate()
	{
       
        $record=Users::model()->findByAttributes(array('username'=>$this->username, 'application_id'=>$this->applicationId, 'status' => $this->status ));
        $isCookie = isset(Yii::app()->request->cookies['redbullcredentials'])?Yii::app()->request->cookies['redbullcredentials']:null;
        $cookiePass = json_decode($isCookie, true);
        $password = $isCookie ? $cookiePass['value'] : md5(trim($this->password));
        if($record===null)
        {
            $this->errorCode=  self::ERROR_USERNAME_INVALID;
        }
        else if(trim($record->password_hash) != $password)
        {
            unset(Yii::app()->request->cookies['redbullcredentials']);
            $this->errorCode=  self::ERROR_PASSWORD_INVALID;
            $record->login_attemp = $record->login_attemp + 1;
            $record->update();
        }
        else if($record->role_id==ROLE_MEMBER && $record->status==0 )
        {
            $this->errorCode=  self::ERROR_USERNAME_BLOCKED;
        }
        else if($record->role_id==ROLE_MEMBER && $record->status==2 )
        {
            $this->errorCode=  self::ERROR_USERNAME_INVALID;
        }
        else
        {
            $this->_id=$record->id;
            $this->errorCode=self::ERROR_NONE;
            $this->_isAdmin = false;
            $record->last_logged_in = date('Y-m-d H:i:s');
            $record->ip_address = Yii::app()->request->getUserHostAddress();
            $record->login_attemp = 0;
            Yii::app()->session['LOGGED_USER'] = $record;
            if(!$record->update())
                Yii::log(print_r($record->getErrors(), true), 'error', 'UserIdentity.authenticate');
            
            $array['key'] = $this->username;
            $array['value'] = md5($this->password);
            $cookie = new CHttpCookie('redbullcredentials', json_encode($array));
            $cookie->expire = time() + 356 * 24 * 60 * 60;
            Yii::app()->request->cookies['redbullcredentials'] = $cookie;
        }


        return !$this->errorCode;
	}

    public function getId()
    {
        return $this->_id;
    }

    public function getIsAdmin()
    {
        return $this->_isAdmin;
    }

    public function getRoleId()
    {
        return $this->role_id;
    }
}