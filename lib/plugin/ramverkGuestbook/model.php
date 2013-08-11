<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
exception_include(PATH_PLUGIN."ramverkGuestbook/config/app.conf.php");

class ramverkGuestbookModel extends AbstractModel {
	public function getAllEntries() {
		$sth	= $this->db->query("SELECT content, name, created
								FROM ".MYSQL_PREFIX."guestbook
								WHERE activated = '1'
								ORDER BY created DESC");
		return $sth->fetchAll();
	}
	
	/**
	* Activate entry
	* @param $id			integer Entry ID
	* @param $verify_code	string	Verify Code
	* @return boolean
	**/
	public function activateEntry($id, $verify_code) {
		try {
			if($this->checkVerifyCode($id, $verify_code) === true) {
				$sth	= $this->db->prepare("UPDATE ".MYSQL_PREFIX."guestbook SET
											activated = '1'
											WHERE id = :id");
				$sth->bindValue(":id",	$id, PDO::PARAM_INT);
				return $sth->execute();
			}
			return false;
		} catch(PDOException $e) {
			throw new ramverkException($e->getMsg(), $e->getCode(), $e);
		}
	}
	
	public function createEntry($name, $content) {
		try {
			$verify_code	= $this->createVerifyCode();
			$sth			= $this->db->prepare("INSERT INTO ".MYSQL_PREFIX."guestbook
												(content, name, created, verify_code, activated)
												VALUES
												(:content, :name, :created, :verify_code, :activated)");
			$sth->bindValue(":content",			$content);
			$sth->bindValue(":name",			$name);
			$sth->bindValue(":created",			time());
			$sth->bindValue(":verify_code",		$verify_code);
			$sth->bindValue(":activated",		GUESTBOOK_ACTIVATED);
			$sth->execute();
			
			if(GUESTBOOK_ACTIVATED == false) {
				$activation_link 	= LINK_MAIN."guestbook/activate/".$this->db->lastInsertId()."/".$verify_code;
				$text	= str_replace(array("%link%", "%content%", "%name%", "%remove_delay%"), array($activation_link,$content,$name, GUESTBOOK_REMOVE_DELAY), file_get_contents(PATH_PLUGIN."ramverkGuestbook/config/email_new_entry"));
				ramverkEmail::sendMail(GUESTBOOK_EMAIL, "Neuer Gästebuch Eintrag", $text);
			}
			return true;
		} catch(Exception $e) {
			throw new ramverkException($e->getMsg(), $e->getCode(), $e);
		}
	}
	
	
	private function createVerifyCode() {
		return sha1(uniqid(mt_rand(), true));
	}
	
	/**
	* Check if verify_code is correct. Protect to Bots or other script kiddies
	* @param $id			integer
	* @param $verify_code 	string
	* @return boolean
	**/
	private function checkVerifyCode($id, $verify_code) {
		try {
			$sth	= $this->db->prepare("SELECT verify_code
										FROM ".MYSQL_PREFIX."guestbook
										WHERE id = :id");
			$sth->bindValue(":id",	$id);
			$sth->execute();
		
			$row	= $sth->fetch();
			if($row['verify_code'] == $verify_code) {
				return true;
			}
			return false;
		} catch(PDOException $e) {
			throw new ramverkException($e->getMsg(), $e->getCode(), $e);
		}
	}
	
	/**
	* Remove old entries
	* Remove all entries: time >= time-(GUESTBOOK_REMOVE_DELAY * 3600)
	* Called by createEntry (conjob is to expensive)
	**/
	private function removeEntries() {
		$sth		= $this->db->prepare("DELETE FROM ".MYSQL_PREFIX."guestbook
										WHERE activated = '0'
											AND created <= :remove_time");
		$sth->bindValue(":remove_time",		(time()-(GUESTBOOK_REMOVE_DELAY*3600)));
		return $sth->execute();
	}
}