<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <andre@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+

class ramverkUser {
	private $session;
	private $userinfo;
	private $db;
	
	public function __construct(&$session) {
		$this->db				= ramverkDB::getConnection();
		$this->session			= &$session;
		if($this->isLogin()) {
			$this->userinfo		= $this->getUserInfo($session['userId']);
		}
	}
	
	/**
	* Check if user is login & fingerprint correct
	**/
	private function isLogin() {
		if(isset($this->session['userId']) && is_numeric($this->session['userId'])) {
			$userId	= $this->session['userId'];
			if ($this->generateSessionFingerprint($_SERVER['HTTP_HOST'], $this->getSessionKey($userId)) == $this->getSessionFingerprint($userId)) {
				return true;
			}
			else {
				//Session stolen?! oO
				$this->setLogout($userId);
				throw new ramverkUserException("Possible session was stolen");
				return false;
			}
		}
		return false;
	}
	
	public function checkPassword($userId, $input_password) {
		$db_password	= $this->getUserPassword($user_id);
		
		if($db_password == $this->createPasswordHash($input_password, $this->getSalt($userId))) {
			return true;
		}
		return false;
	}
	
	private function getUserPassword($userId) {
		$sth	= $this->db->prepare("SELECT password
									FROM ".MYSQL_PREFIX."user
									WHERE id = :userId");
		$sth->bindValue(":userId", $userId);
		$sth->execute();
		
		$row	= $sth->fetch();
		return $row['password'];
	}
	
	/**
	* Get Salt of an user
	* @param	integer		$userId		User ID
	* @return	string
	**/
	private function getSalt($userId) {
		$sth	= $this->db->prepare("SELECT salt
									FROM ".MYSQL_PREFIX."user
									WHERE id = :userId");
		$sth->bindValue(":userId",		$userId);
		$sth->execute();
		$row	= $sth->fetch();
		return $row['salt'];
	}
	
	/**
	* Create a hashed password, choose algorithm by password. Create salt if isn't set.
	* @param	string		$password		Password
	* @param	string		salt			salt (optional)
	* @return	array 		(hash, salt)
	**/
	private function createPasswordHash($password, $salt="")
	{
		if(empty($salt))
		{
			$salt = md5(mt_rand());
		}
		$hash = hash('sha512', $password);
		
		if ( preg_match('#[0-4]#i', $password) )
		{
			crypt($hash, substr($salt, 0, 2));
		}
		if ( preg_match('#[5-9]#i', $password) )
		{
			crypt($hash, substr($salt, 0, 9));
		}
		if ( preg_match('#[bcfgk]#i', $password) )
		{
			crypt($hash, substr($salt, 0, 12));
		}
		if ( preg_match('#[lmowz]#i', $password) ) 
		{
			crypt($hash, substr($salt, 0, 16));
		}
		$len = strlen($password);
		for ( $i=0; $i < $len; $i++ )
		{
			$hash = hash('sha512', $hash . $salt);
		}
		
		return array($hash, $salt);
	}
	
	
	public function getUserInfo($userId) {
		$sth	= $this->db->prepare("SELECT id, username, email, givenname, familyname, session_key
										FROM ".MYSQL_PREFIX."user
										WHERE id = :userId");
		$sth->bindParam(":userId",		$userId);
		$sth->execute();
		
		return $sth->fetch();
	}
	
	public function getUserIdByName($username) {
		$sth	= $this->db->prepare("SELECT id
									FROM ".MYSQL_PREFIX."user
									WHERE username LIKE :username");
		$sth->bindParam(":username",	$username);
		$sth->execute();
		
		$row	= $sth->fetch();
		return $row['id'];
	}
	
	public function setLogin($boolean, $userId) {
		if($boolean == true) {
			$this->session['userId'] = $userId;
			return $this->setSessionFingerprint($userId);
		} else {
			return $this->setLogout($userId);
		}
	}
	
	private function setLogout($userId) {
		try {
			$this->setSessionKey($userId); //=> Fingerprint only one time the same
			$this->clearSessionFingerprint($userId);
			return true;
		} catch(ramverkUserException $e) {
			return false;
		}
	}
	
	private function getSessionFingerprint($userId) {
		$sth	= $this->db->prepare("SELECT session_fingerprint
									FROM ".MYSQL_PREFIX."user
									WHERE id = :userId");
		$sth->bindValue(":userId",	$userId);
		$sth->execute();
		$row	= $sth->fetch();
		return $row['session_fingerprint'];
	}
	
	private function setSessionFingerprint($userId) {
		$fingerprint = md5($_SERVER['HTTP_USER_AGENT'].$this->getSessionKey($userId));
		
		$sth	= $this->db->prepare("UPDATE ".MYSQL_PREFIX."user SET
									session_fingerprint = :fingerprint
									WHERE id = :userId");
		$sth->bindParam(":fingerprint",	$fingerprint);
		$sth->bindParam(":userId",		$userId);
		$sth->execute();
		return true;
	}
	
	private function clearSessionFingerprint($userId) {
		$sth	= $this->db->prepare("UPDATE ".MYSQL_PREFIX."user SET
									session_fingerprint	= ''
									WHERE id			= :userId");
		$sth->bindValue(":userId",	$userId);
		return $sth->execute();
	}
	
	private function getSessionKey($userId) {
		return $this->userinfo['session_key'];
	}
	
	private function setSessionKey($userId) {
		$session_key	= substr(md5(time()), 0,6);
		
		$sth			= $this->db->prepare("UPDATE ".MYSQL_PREFIX."user SET
											session_key		= :session_key
											WHERE id		= :userId");
		$sth->bindValue(":session_key",		$session_key);
		$sth->bindValue(":userId",			$userId);
		return $sth->execute();
	}
}