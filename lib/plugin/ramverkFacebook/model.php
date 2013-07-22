<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
exception_include(dirname(__FILE__)."/config/app.conf.php");

class ramverkFacebookModel extends AbstractModel {
	private function getUser() {
		$sth	= $this->db->query("SELECT id, access_token, expired, email, name
								FROM ".MYSQL_PREFIX."facebook_user");
		return $sth->fetchAll();
	}
	
	public function checkEmailNotification() {
		foreach($this->getUser() as $user) {
			if($this->checkAccessTokenExpired($user['expired']) === false) {
				$this->sendEmailNotification($user['id'], $user['email'], $user['name'], $user['expired']);
			}
		}
		return true;
	}
	
	/**
	* Check if user comes from Facebook to give access token
	**/
	private function userFromFacebook() {
		if(isset($_GET['code'])) {
			return true;
		}
		return false;
	}
	
	
	public function getFacebookLogin($userid) {
		exception_include(PATH_MAIN."lib/facebook/src/facebook.php");
		$facebook	= new Facebook(array(
				'appId'  => FACEBOOK_APP_ID,
				'secret' => FACEBOOK_APP_SECRET,
		));
		
		return $facebook->getLoginUrl(array("redirect_uri" => CURRENT_PAGE."/change", "scope" => FACEBOOK_APP_RIGHTS));
	}
	
	private function sendEmailNotification($userid, $email, $name, $expired) {
		$header		= 'MIME-Version: 1.0' . "\r\n";
		$header		.= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$header		.= 'From: '.ADMIN_EMAIL."\r\n";
		$header		.= 'Reply-To: '.ADMIN_EMAIL."\n";
		$header		.= "X-Mailer: php";
		
		$to			= $email;
		$mailsubject	= "[".DOMAIN."] Bitte Facebook Zugriff erneuern.";
		$body		= "Hallo,<br/>
						Die Seite ".DOMAIN." hat am ".date("d.m.Y", $expired)." keinen Zugriff mehr auf den Account: ".$name.".<br/>
						Bitte nutze daher folgenden Link, nachdem du mit dem Account in Facebook eingeloggt bist, um den Zugriff zu verlängern.<br/><br/>
						".LINK_MAIN."facebook/changeKey/".$userid."<br/><br/>
						Vielen Dank.";
		if(mail($to, $mailsubject, $body, $header))
		{
			return true;
		}
		return false;
	}
	
	private function checkAccessTokenExpired($expired) {
		if(abs($expired - time()) <= 864000) {
			return false;
		}
		return true;
	}
	
	private function getAccessTokenByCode($code) {
		exception_include(PATH_MAIN."lib/facebook/src/facebook.php");
		$facebook	= new Facebook(array(
				'appId'  => FACEBOOK_APP_ID,
				'secret' => FACEBOOK_APP_SECRET,
		));
		
		$facebook->api('oauth/access_token', array(
			'client_id'		=> FACEBOOK_APP_ID,
			'client_secret'	=> FACEBOOK_APP_SECRET,
			'type'			=> 'client_cred',
			'code'			=> $code,
				));
			
		return $facebook->getAccessToken();
	}
	
	public function setAccessToken($userid) {
		$token		= $this->getAccessToken($_GET['code']);
		$expired	= time()+5184000;
		try {
			$sth	= $this->db->prepare("UPDATE ".MYSQL_PREFIX."facebook_user SET
											access_token	= :token,
											expired			= :expired
											WHERE id		= :userid");
			$sth->bindValue(":token",	$token);
			$sth->bindValue(":expired",	$expired);
			$sth->bindValue(":userid",	$userid);
			
			return $sth->execute();
		} catch(PDOException $e) {
			throw new ramverkException($e->getMsg(),$e->getCode(),$e);
		}
	}
}
