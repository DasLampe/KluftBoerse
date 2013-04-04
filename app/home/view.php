<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
class HomeView extends AbstractView {
	public function Example() {
		return $this->tpl->load("_example");
	}
}
?>