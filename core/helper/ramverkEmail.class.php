<?php
// +----------------------------------------------------------------------+
// | Copyright (c) 2013 DasLampe <daslampe@lano-crew.org> |
// | Encoding:  UTF-8 |
// +----------------------------------------------------------------------+
class ramverkEmail {
	public static function sendMail($to, $subject, $text, $from=ADMIN_EMAIL) {
		try {
			$header		= 'MIME-Version: 1.0' . "\r\n";
			$header		.= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$header		.= 'From: '.$from."\r\n";
			$header		.= 'Reply-To: '.$to."\n";
			$header		.= "X-Mailer: php";
		
			$to			= $email;
			$subject	= "[".ucfirst(DOMAIN)."]".$subject;
			$body		= nl2br($text);
		
			if(mail($to, $subject, $body, $header))
			{
				return true;
			}
			return false;
		} catch(Exception $e) {
			throw new ramverkException($e->getMsg(), $e->getCode(), $e);
		}
	}
}