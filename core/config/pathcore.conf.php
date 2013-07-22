<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
$dir		= explode("core/config", dirname(__FILE__));
$protocol	= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http";

$subdir		= "/";
if(strlen($_SERVER['DOCUMENT_ROOT']) < strlen($dir[0]))
{ //dir isn't document root.
	$subdir 	= explode($_SERVER['DOCUMENT_ROOT'], $dir[0]);
	$subdir		= $subdir[1];
	$subdir		= (substr($subdir, 0, 1) == "/") ? $subdir : "/".$subdir;
}

define("PATH_MAIN",				$dir[0]);
define("PATH_CORE",				PATH_MAIN."core/");
define("PATH_APP",				PATH_MAIN."app/");
define("PATH_PLUGIN",			PATH_MAIN."lib/plugin/");

define("LINK_MAIN",				$protocol."://".$_SERVER['HTTP_HOST'].$subdir);
define("DOMAIN",				$_SERVER['HTTP_HOST']);

define("CURRENT_PAGE",			LINK_MAIN.substr($_SERVER['QUERY_STRING'], 6));