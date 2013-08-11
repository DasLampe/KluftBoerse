<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
header('Content-Type: text/html; charset=utf-8');

//Check if AJAX request.
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
		strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == "xmlhttprequest")
{
	define("IS_AJAX", true);
}
else
{
	define("IS_AJAX", false);
}

define("ADMIN_EMAIL",		"webmaster@example.com");

