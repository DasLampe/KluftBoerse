<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+

//config values
include_once(dirname(__FILE__)."/config/pathcore.conf.php");

//abstract classes
include_once(PATH_CORE."abstract/model.abstract.php");
include_once(PATH_CORE."abstract/view.abstract.php");
include_once(PATH_CORE."abstract/controller.abstract.php");

//helper classes
include_once(PATH_CORE."helper/ramverkLog.class.php");
include_once(PATH_CORE."helper/ramverkException.class.php");