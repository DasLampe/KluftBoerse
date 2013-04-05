<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
class offersModel extends AbstractModel {
	public function getAllSearching() {
		$sth	= $this->db->query("SELECT id, description, owner
									FROM ".MYSQL_PREFIX."offers
									WHERE type = 2");
		return $sth->fetchAll();
	}
	
	public function getAllSelling() {
		$sth	= $this->db->query("SELECT id, description, owner
									FROM ".MYSQL_PREFIX."offers
									WHERE type = 1");
		return $sth->fetchAll();
	}
}