<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
class HomeView extends AbstractView {
	public function info() {
		$this->tpl->vars("hero_unit",		$this->tpl->load("info", dirname(__FILE__)."/template/"));
		$this->tpl->vars("selling",			$this->sellingView());
		$this->tpl->vars("searching",		$this->searchingView());
		return $this->tpl->load("home", dirname(__FILE__)."/template/");
	}
	
	private function sellingView() {
		include_once(PATH_APP."offers/view.php");
		$offers		= new offersView();
		
		return '<h3>Zu verkaufen</h3>'.$offers->showSelling();
	}
	
	private function searchingView() {
		include_once(PATH_APP."offers/view.php");
		$offers		= new offersView();
		
		return '<h3>Gesucht</h3>'.$offers->showSearching();
	}
}
?>