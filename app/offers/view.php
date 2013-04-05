<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
class offersView extends AbstractView {
	public function showSelling() {
		return $this->showList($this->model->getAllSelling());
	}
	
	public function showSearching() {
		return $this->showList($this->model->getAllSearching());
	}
	
	private function showList($values) {
		$list	= "";
		foreach($values as $offer) {
			$this->tpl->vars("value",	'<a href="'.LINK_MAIN.'offers/'.$offer['id'].'">'.$offer['description'].'</a>');
			$list	.= $this->tpl->load("_li");
		}
		
		$this->tpl->vars("list_style",	"");
		$this->tpl->vars("li_list",		$list);
		return $this->tpl->load("_ul");
	}
}