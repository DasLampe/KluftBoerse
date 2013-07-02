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
	
	public function showOffer($id) {
		$data	= $this->model->getOffer($id);
		
		$this->tpl->vars("id",					$data['id']);
		$this->tpl->vars("title",				$data['description']); //@TODO: Add new field in database
		$this->tpl->vars("description",			$data['description']);
		$this->tpl->vars("type",				$data['type']);
		$this->tpl->vars("owner_givenname",		$data['owner_givenname']);
		$this->tpl->vars("owner_familyname",	$data['owner_familyname']);
		
		return $this->tpl->load("_offer", PATH_APP."offers/template/");
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