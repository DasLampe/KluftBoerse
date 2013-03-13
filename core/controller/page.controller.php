<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
class pageController
{
	private $param;

	function __construct($param)
	{
		include_once(PATH_CORE."class/ramverkTemplate.class.php");
		$this->param	= $param;
		$this->tpl		= ramverkTemplate::getInstance();
	}

	function render()
	{
		try
		{
				if(file_exists(PATH_APP.$this->param[0]) && is_dir(PATH_APP.$this->param[0]))
				{ //if dir exists
					save_include(PATH_APP.$this->param[0].'/controller.php');
					$controller	= ucfirst($this->param[0]).'Controller';
					$controller	= new $controller($this->param);
				}
				else {
					throw new Exception("Page not found");
				}

				$page_content	= $controller->factoryController();
				$this->tpl->vars("page_content", $page_content);
		}
		catch(Exception $e)
		{
			$page_content	= $e->getMessage();
			$this->tpl->vars("page_content", $page_content);
		}

		/**
		 * Handle JSON
		 */
		if(preg_match('/^\{".*".?:/', $page_content))
		{
			header('Content-type: text/json');
			echo $page_content;
			exit();
		}
		
		/**
		 * Add own js and css files
		 */
		$this->tpl->vars("js_files",		$this->tpl->getJs());
		$this->tpl->vars("css_files",		$this->tpl->getCss());
		
		echo $this->tpl->load("layout");
	}
}
