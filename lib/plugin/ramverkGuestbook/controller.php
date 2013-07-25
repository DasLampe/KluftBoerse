<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
class ramverkGuestbookController extends AbstractController {
	public function factoryController() {
		if(!isset($_POST['submit']) && (!isset($this->param[1]) || empty($this->param[1]))) {
			return $this->view->Main();
		}
		
		switch($this->param[1]) {
			case 'create':
				return $this->view->createEntry($_POST);
				break;
			case 'activate':
				return $this->view->activateEntry($this->param[2], $this->param[3]);
				break;
		}
	}
}