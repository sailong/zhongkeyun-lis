<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	
	private $_id;
	
	private $_name;
	
	
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$condition = Util::checkIsMobile($this->username) ? array('mobile'=>$this->username) : array('number'=>$this->username);
		$model = User::model()->findByAttributes($condition);
		if(empty($model))
		{
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}elseif($model->password != md5($this->password))
		{
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		}else{
			$this->_id = $model->id;
			$this->_name = $model->name;
			$this->setState('hospital_id', $model->hospital_id);
			$this->errorCode = self::ERROR_NONE;
		}
		return !$this->errorCode;
	}
	
	public function getId()
	{
		return $this->_id;
	}
	
	public function getName()
	{
		return $this->_name;
	}
	
}