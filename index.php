<?php
include_once(dirname(__FILE__)."/config/config.php");

$param	= explode("/", $_GET['param']);

if(!isset($param[0]) || $param[0] == "")
{
	$page	= "overview";
}
else
{
	$page	= $param[0];
}

if($page == "print_invoice")
{
	include(PATH_PAGES.$page.".php");
}
elseif(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
	include_once(PATH_PAGES.$page.".php");
}
else
{
	include_once(PATH_TPL."layout.php");
}