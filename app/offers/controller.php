<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
class offersController extends AbstractController {
	public function factoryController() {
		if(!isset($this->param[1])) {
			header("Location: ".LINK_MAIN); //Redirect to index
		}
		
		switch($this->param[1]) {
			case 'selling':
				return $this->view->showSelling();
				break;
			case 'searching':
				return $this->view->showSearching();
				break;
		}
	}
}