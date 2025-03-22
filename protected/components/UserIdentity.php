<?php

class UserIdentity extends CUserIdentity
{
	/*public function authenticate()
	{
		$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;
	}
	*/
	
	private $_id;
	
	public function authenticate()
	{
		$user=User::model()->findByAttributes(array('Password'=> $this->password));  // USER from db
	
		if($user===null){
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		}else if($user->Password !==($this->password)){
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		}else{
			
			$this->errorCode=self::ERROR_NONE;
			$this->setState('id', $user->User_ID);
			$this->setState('Kode_Cabang', $user->Kode_Cabang); //Yii::app()->user->getState('Kode_Cabang');
			$this->setState('Nama', $user->Nama); //Yii::app()->user->getState('Kode_Cabang');
			$this->_id=$user->User_ID;
		}
		
		return !$this->errorCode;	
	}

	public function getId()
	{
		return $this->_id;
	}
}