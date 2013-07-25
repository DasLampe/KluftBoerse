<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
class ramverkGuestbookView extends AbstractView {
	private $form_fields	= array(
									array("fieldset", "Dein Eintrag", array(
											array("text", "Name", "name", "", true),
											array("textarea", "", "message", "", true),
										),
									),
									array("fieldset", "", array(
											array("submit", "Eintragen", "submit"),
										),
									),
								);
	
	public function Main() {
		$this->tpl->addCSS("style.css", LINK_MAIN."lib/plugin/ramverkGuestbook/template/css/");
		
		$entries	= "";
		foreach($this->model->getAllEntries() as $entry) {
			$entries .= $this->getEntryBlock($entry);
		}
		
		$this->tpl->vars("create_form",	$this->getCreateForm());
		$this->tpl->vars("entries",		$entries);
		
		return $this->tpl->load("main", PATH_PLUGIN."ramverkGuestbook/template/");
	}
	
	public function createEntry(array $data) {
		if(!isset($data['name']) || !isset($data['message'])) {
			return $this->getCreateForm();
		}
		
		$this->model->createEntry($data['name'], $data['message']);
		
		// @TODO: Implements somthing like notification in impeesa2
		header("Location: ".LINK_MAIN."/guestbook");
	}
	
	public function activateEntry($id, $verify_code) {
		if($this->model->activateEntry($id, $verify_code) == true) {
			return "Eintrag wurde aktiviert!";
		}
		return "Eintrag konnte nicht aktiviert werden!";
	}
	
	private function getEntryBlock(array $entry) {
		$this->tpl->vars("name",	$entry['name']);
		$this->tpl->vars("created",	date("d.m.Y", $entry['created']));
		$this->tpl->vars("content", nl2br($entry['content']));
		
		return $this->tpl->load("_entry", PATH_PLUGIN."ramverkGuestbook/template/");
	}
	
	private function getCreateForm() {
		exception_include(PATH_CORE."class/ramverkForm.class.php");
		$form 	= new ramverkForm();
		
		return $form->getForm($this->form_fields, CURRENT_PAGE."create/");
	}
}