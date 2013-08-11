<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <andre@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
class ramverkNotification {
	private static $instance = NULL;
	
	public function __construct() {
		
	}
	
	public static function getInstance() {
		if(null == self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public static function setMsg(&$session, $msg, $redirection, $status="success", array $param = array()) {
		if(IS_AJAX == true)
		{
			$return	= array();
			$return["msg"]		= $msg;
			$return["status"]	= $status;
			foreach($param as $key=>$value)
			{
				$return[$key]	= $value;
			}
			return json_encode($return);
		}
		else
		{
			$_SESSION['info_msg']		= $msg;
			$_SESSION['info_status']	= $status;
			header("Location: ".$redirection);
			exit(); //Do not remove this! Elsewhere you can't see the infomessage after redirect!
		}
		return true;
	}
	
	public function getMsg(&$session)
	{
		if(isset($session['info_msg']))
		{
			$return	= array(
							"msg"		=> $session['info_msg'],
							"status"	=> $session['info_status'],
							);
			
			//Clear Session
			unset($session['info_msg']);
			unset($session['info_status']);
			
			return $return;
		}
		return array("msg" => "", "status" => "");
	}
}