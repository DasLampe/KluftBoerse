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
	
	public function getOffer($id) {
		$sth	= $this->db->prepare("SELECT offer.id, offer.description, offer.type, offer.owner as ownerId, user.givenname as owner_givenname, user.familyname as owner_familyname
									FROM ".MYSQL_PREFIX."offers AS offer
									INNER JOIN ".MYSQL_PREFIX."user AS user ON offer.owner = user.id
									WHERE offer.id = :offer_id");
		$sth->bindValue(":offer_id",	$id);
		$sth->execute();
		return $sth->fetch();
	}
}