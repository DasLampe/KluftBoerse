<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
abstract class AbstractController {
	protected $param;
	protected $view;
	protected $classname;
	
	public function __construct($param)
	{
	    $rc = new ReflectionClass(get_class($this));

		$name			= str_replace('Controller', '', get_class($this));
		$classname		= $name."View";
		
		exception_include(dirname($rc->getFileName())."/view.php");
		$this->view	 = new $classname();
	}
	
	abstract public function factoryController();
}