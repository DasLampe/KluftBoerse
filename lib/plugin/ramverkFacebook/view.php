<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
class ramverkFacebookView extends AbstractView {
	public function checkNotification() {
		$this->model->checkEmailNotification();
	}
	
	public function changeKey($userid) {
		if($this->model->userFromFacebook() === false) {
			header("Location:".$this->model->getFacebookLogin($userid));
			return 0;
		}
		else {
			if($this->model->setAccessToken($userid) == true) {
				$this->tpl->vars("headline",	"Erfolgreich geändert!");
				$this->tpl->vars("content",		"Der Schlüssel wurde erfolgreich geändert.<br/>Vielen Dank!<br/>Bis in 50 Tagen.");
			}
			else {
				$this->tpl->vars("headline",	"Fehler beim ändern!");
				$this->tpl->vars("content",		"Leider konnte der Schlüssel nicht geändert werden.<br/>Bitte wende dich an den Administartor!");
			}
			return $this->tpl->load("_content_h1");
		}
	}
}