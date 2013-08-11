<?php
class ramverkPostProcess {
	/**
	 * Protect Emails with base64 encoding
	 * based on https://gist.github.com/907604
	 * @param string $html
	 * @return string
	 */
	public static function protectEmail($html)
	{
		$regexp = '/
					( # leading text
						<\w+.?>| # leading HTML tag, or
						[^=:!\'"\/]| # leading punctuation, or
						<a.?href="mailto:|
						^
					)
					(
						[a-z]+[a-z0-9\-\.\_]+?@[a-z0-9\-\.]+[a-z]{2,6}
					)
					(
						[[:punct:]]||\s|<|$
					) # trailing text
				/ix';

		return preg_replace_callback($regexp, function($matched) {
			list($all, $before, $address, $after) = $matched;
			
			// already linked
			if (preg_match('/<a\s/i', $before)) {
				return preg_replace_callback("/[a-z]+[a-z0-9\-\.\_]+?@[a-z0-9\-\.]+[a-z]{2,6}/ix", function($matches){return base64_encode($matches[0]);}, $all);
			}

			if(preg_match('/[A-Z]/i', $before) && !preg_match('/>/', $before))
			{
				return $all;
			}

			$text 		= strtr($address,array("@"=> " ät ", "." => " dot "));
			$address	= base64_encode($address); 

			return $before.'<a href="mailto:'.$address.'">'.$text.'</a>'.$after;
			}, $html);
	}
}
?>