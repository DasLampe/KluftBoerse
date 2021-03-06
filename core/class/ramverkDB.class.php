<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <andre@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
include_once(PATH_CORE."config/database.conf.php");

class ramverkDb {
	private static $db = NULL;
 
	public function __construct()
	{
	}
 
	public function __clone()
	{
	}
 
	public static function getConnection()
	{
		if(self::$db == NULL)
		{
			try
			{
				self::$db	= new PDO("mysql:host=".MYSQL_HOST.";dbname=".MYSQL_DATABASE, MYSQL_USER, MYSQL_PASSWORD);
				if($_SERVER['HTTP_HOST'] == "localhost")
				{
					self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				}
				self::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, MYSQL_FETCH_MODE);
				self::$db->exec("SET CHARACTER SET utf8");
			}
			catch(PDOException $e)
			{
				die("Database connection failed");
			}
		}
		return self::$db;
	}
}