<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
class ramverkFacebookController extends AbstractController {
	public function factoryController() {
		if(!isset($this->param[1]) || empty($this->param[1])) {
			return "";
		}
		
		switch($this->param[1]) {
			case 'changeKey':
				return $this->view->changeKey($this->param[2]);
				break;
			case 'checkNotification':
				$this->view->checkNotification();
				break;
		}
	}
}