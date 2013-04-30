<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
class ramverkLog {
	public static function setWarning($msg, $filename) {
		$msg	= "WARNING: ".$msg." log in ".$filename."\n\r";
		self::writeLog($msg);
	}
	
	public static function setError($msg, $filename) {
		$msg	= "ERROR: ".$msg." log in ".$filename."\n\r";
		self::writeLog($msg);
	}
	
	private static function writeLog($msg) {
		$msg	= date("d.m.Y - H:i")." - ".$msg;
		
		$handle	= fopen(PATH_MAIN."tmp/".date("d-m-Y").".debug", "a+");
		fwrite($handle, $msg);
		fclose($handle);
	}
}
?>