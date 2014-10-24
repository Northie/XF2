<?php

namespace utils;

class Tools {

	public static function getRequest() {

		$str = $_SERVER['QUERY_STRING'];

		$str = preg_replace("/_dc=[0-9]+/", "", $str);

		$req = explode("/", $str);
		$module = array_shift($req);
		$action = array_shift($req);

		for ($i = 0; $i < count($req); $i+=2) {
			$_GET[$req[$i]] = $_GET[$i + 1];
		}

		return $_GET;
	}

	public static function generatePassword($len = 8, $selection = 'lower', $removeConfusing = 1) {

		$lower = 'abcdefghijklmnopqrstuvwxyz';
		$upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$number = '0123456789';

		$confusing = array('0', '1', '2', '5', 'i', 'l', 'o', 's', 'z', 'I', 'L', 'O', 'S', 'Z');

		switch ($selection) {
			case 'default':
				$str = $lower . $upper . $number;
				break;
			case 'lower':
				$str = $lower . $number;
				break;
			case 'upper':
				$str = $upper . $number;
				break;
			case 'alpha':
				$str = $lower . $number;
				break;
			default:
				$str = $lower . $upper . $number;
				break;
		}

		if ($removeConfusing > 0) {
			$str = str_replace($confusing, '', $str);
		}

		$pw = "";

		for ($i = 0; $i < $len; $i++) {
			$pw.=$str[rand(0, strlen($str) - 1)];
		}

		return $pw;
	}

	public static function hashPassword($plain) {
		//old
		//$hash = sha1($password.md5($password))."-".md5($password.sha1($password));
		//return $hash;
		//new
		$password = new \libs\misc\password;
		$hashed = $password->getHashToStore($plain);
		return $hashed;
	}

	public static function hashPasswordOld($password) {
		//old
		$hash = sha1($password . md5($password)) . "-" . md5($password . sha1($password));
		return $hash;
	}

	public static function encryptStr($msg, $key) {
		$c = new \libs\misc\Crypto;
		return $c->encrypt($msg, $key);
	}

	public static function decryptStr($msg, $key) {
		$c = new \libs\misc\Crypto;
		return $c->decrypt($msg, $key);
	}

	public static function camel_to_title($str) {
		return
			trim(
			ucwords(
				strtolower(
					preg_replace(
						'/([0-9]+)|([A-Z])/', ' $0', $str
					)
				)
			)
		);
	}

	public static function to_camel_case($str) {

		$str = str_replace('_', ' ', $str);
		$str = strtolower($str);
		$str = ucwords($str);
		$str = str_replace(' ', '', $str);



		$str[0] = strtolower($str[0]);

		return $str;
	}

	public static function is_unid($str) {
		$pattern = "/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/";

		return preg_match($pattern, $str) ? true : false;
	}

	public static function is_email($str, &$email = false) {

		if (filter_var($str, FILTER_VALIDATE_EMAIL)) {
			$email = $str;
			return true;
		}

		$str = filter_var($str, FILTER_SANITIZE_EMAIL);

		if (filter_var($str, FILTER_VALIDATE_EMAIL)) {
			$email = $str;
			return false;
		}

		return false;
	}

	public static function is_url($str, $url = false) {
		if (filter_var($str, FILTER_VALIDATE_URL)) {
			$email = $str;
			return true;
		}

		$str = filter_var($str, FILTER_SANITIZE_URL);

		if (filter_var($str, FILTER_VALIDATE_URL)) {
			$email = $str;
			return false;
		}

		return false;
	}

	public static function is_ip($str) {
		return filter_var($str, FILTER_VALIDATE_IP);
	}

	public static function json_to_ext($input) {
		if (is_array($input)) {
			$str = json_encode($input);
		} else {
			$str = $input;
		}

		$pattern = "/\"[a-zA-Z0-9]+\"\:/";

		preg_match_all($pattern, $str, $matches);

		$find = $replace = array();

		foreach ($matches[0] as $match) {
			$f = $match;
			$r = str_replace('"', '', $match);

			if (!in_array($f, $find)) {
				$find[] = $f;
			}

			if (!in_array($r, $replace)) {
				$replace[] = $r;
			}
		}

		return str_replace($find, $replace, $str);
	}

	public static function isAssoc($arr) {
		return array_keys($arr) !== range(0, count($arr) - 1);
	}

	public static function setCache($key, $data, $ttl = 3600) {
		return false;
		//get default cache adapter
		apc_store($key, $data, $ttl);
	}

	public static function getCache($key) {
		return false;
		//get default cache adapter
		return apc_fetch($key);
	}

	public static function html_escape($raw_input) {
		return htmlspecialchars($raw_input, ENT_QUOTES | ENT_HTML401, 'UTF-8');
	}

	public static function array2object($array) {
		return json_decode(json_encode($arr));
	}

	public static function object2array($object) {
		return json_decode(json_encode($object), 1);
	}

	public static function cleanHtml($html, $attr_black_list = false, $elem_black_list = false) {
		if (!$attr_black_list || !is_array($attr_black_list)) {
			$attr_black_list = ['onclick'];
		}

		if (!$elem_black_list || !is_array($elem_black_list)) {
			$elem_black_list = ['script', 'iframe'];
		}

		$remove_elems = [];

		$dom = new \DOMDocument();

		@$dom->loadHTML("<html><body>" . $html . "</body></html>");

		$els = $dom->getElementsByTagName('*');


		foreach ($els as $el) {

			foreach ($attr_black_list as $attr) {
				if ($el->hasAttribute($attr)) {
					$el->removeAttribute($attr);
				}
			}

			foreach ($elem_black_list as $elem) {
				if (strtolower($el->nodeName) == $elem) {
					$remove_elems[] = $el;
				}
			}
		}

		foreach ($remove_elems as $r) {
			$r->parentNode->removeChild($r);
		}

		$clean = $dom->saveHtml();

		$tidy_config = [
			'clean'=>true,
			'output-html'=>true,
			'bare'=>true,
			'drop-proprietary-attributes'=>false,
			'fix-uri'=>true,
			'merge-spans'=>false, //ensures editor can work
			'join-styles'=>false,
			'indent'=>true,
			'char-encoding'=>'utf8',
			'force-output'=>true,
			//'quiet'		=>	true,
			'tidy-mark'=>false
		];

		//$tidy = tidy_parse_string($clean,$tidy_config,'UTF8');
		//$tidy->cleanRepair();
		//$clean = (string) $tidy;
		//$fb = new FirePHP();
		//$fb->fb($clean);

		list($start, $trash) = explode("</body>", $clean);

		list($trash, $return) = explode("<body>", $start);

		return $return;
	}

}
