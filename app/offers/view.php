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
		foreach($values as $selling) {
			$this->tpl->vars("value",	$selling['description']);
			$list	.= $this->tpl->load("_li");
		}
		
		$this->tpl->vars("list_style",	"unstyled");
		$this->tpl->vars("li_list",		$list);
		return $this->tpl->load("_ul");
	}
}