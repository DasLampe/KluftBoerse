<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2012 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
abstract class AbstractView {
	protected $tpl;
	protected $model;
	
	public function __construct() {
		try {
			$rc = new ReflectionClass(get_class($this));
			
			$name			= str_replace('View', '', get_class($this));
			$classname		= $name."Model";
		
			exception_include(dirname($rc->getFileName())."/model.php");
			$this->model	= new $classname();
		} catch(Exception $e) {
			ramverkLog::setWarning($e->getMessage(), __FILE__);
		}
			
		$this->tpl		= ramverkTemplate::getInstance();
	}
}