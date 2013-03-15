<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2012 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
abstract class AbstractView {
	protected $tpl;
	protected $model;
	
	public function __construct() {
		$name			= str_replace('View', '', get_class($this));
		$classname		= $name."Model";
		
		exception_include(PATH_APP.lcfirst($name)."/model.php");
		$this->model	= new $classname();
			
		$this->tpl		= ramverkTemplate::getInstance();
	}
}