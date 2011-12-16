<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2011 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
$dir	= explode("config", dirname(__FILE__));

define("PATH_MAIN",				$dir[0]);
define("PATH_CORE",				PATH_MAIN."core/");
define("PATH_CORE_LIB",			PATH_CORE."lib/");
define("PATH_CORE_CONTROLLER",	PATH_CORE."controller/");
define("PATH_CORE_CLASS",		PATH_CORE."class/");
define("PATH_LIB",				PATH_MAIN."public_html/lib/");
define("PATH_MODULES",			PATH_MAIN."modules/");
define("PATH_TPL",				PATH_MAIN."public_html/template/");
define("PATH_UPLOAD",			PATH_MAIN."upload/");

define("LINK_MAIN",				"http://localhost/nixmuss-rechnungen/");
define("LINK_MODULES",			LINK_MAIN."modules/");
define("LINK_PUB",				LINK_MAIN."public_html/");
define("LINK_TPL",				LINK_PUB."template/");
define("LINK_LIB",				LINK_PUB."lib/");

define("PATH_PAGES",			PATH_MAIN."pages/");
