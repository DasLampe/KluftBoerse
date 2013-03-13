<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
include_once(PATH_CORE."class/ramverkDB.class.php");

abstract class AbstractModel {
	protected $db;
	
	public function __construct()
	{
		$this->db	= Db::getConnection();
	}
}