<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
class ramverkFacebook {
	private $facebook;
	
	public function __construct() {
		exception_include(PATH_MAIN."lib/facebook/src/facebook.php");
		$this->facebook	= new Facebook(array(
				'appId'  => FACEBOOK_APP_ID,
				'secret' => FACEBOOK_APP_SECRET,
		));
	}
	
	public function getConnection() {
		return $this->facebook;
	}
	
	public function getUserConnection($userid) {
		$this->facebook->setAccessToken($user['access_token']);
		return $this->facebook;
	}
	
	public function apiFQL($fql) {
		$param		= array(
			'method' => 'fql.query',
			'query' => $fql,
		);
		return $this->facebook->api($fql);
	}
}