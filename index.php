<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
header('Content-Type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/core/inc.php"); //Include core files

$param = (!empty($_GET['param'])) ? explode("/", $_GET['param']) : array("home");

if($param[0] == "resource")
{
	include_once(PATH_CORE."controller/resource.controller.php");
	new resourceController($param);
}
else
{
	include_once(PATH_CORE."controller/page.controller.php");
	$pageController	= new pageController($param);
	$pageController->render();
}