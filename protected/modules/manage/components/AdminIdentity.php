<?php
/**
 * AdminIdentity represents the data needed to identity an admin.
 * It contains the authentication method that checks if the provided
 * data can identity the admin.
 */
class AdminIdentity extends CUserIdentity
{
	const ERROR_NOT_ACTIVATED = 3;
	
	private $_id;
	
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$record = User::model()->findByAttributes(array('username'=>$this->username));
		if($record === null){
			$this->errorMessage=Yii::t('error', 'Invalid username or password');
		}
		else if($record->password != '' && $record->password != md5($this->password)){
			$this->errorMessage=Yii::t('error', 'Invalid username or password');
		}
		else if ($record->active != 1) {
			$this->errorMessage=Yii::t('error', "Your account is inactive");
		}
		else
		{
			$this->_id = $record->id;
			$this->setState('username', $record->username);
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode==self::ERROR_NONE;
	}
	
	public function getId()
    {
        return $this->_id;
    }
}