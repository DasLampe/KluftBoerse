<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
class ramverkUserExeption extends ramverkException {
	//TODO: Report Admin
}

class ramverkException extends Exception {
	public function __construct($msg="", $code=0, Exception $prev=null) {
		$this->saveException($msg);
		parent::__construct($msg, $code, $prev);
	}
	
	private function saveException($msg) {
		exception_include(PATH_CORE."helper/ramverkLog.class.php");
		$logger		= new ramverkLog();
		
		$logger->setError($msg." on line ".$this->getLine(), $this->getFile());
	}
}
?>