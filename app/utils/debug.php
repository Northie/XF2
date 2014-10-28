<?php

namespace utils;

class debug {

	public static function printNice($var, $return = false) {
		if (is_scalar($var)) {
			$var = [$var];
		}
		$stack = debug_backtrace();

		$var['_debug'] = $stack[1];

		if ($stack[1]['class'] == __CLASS__) {
			$var['_debug'] = $stack[2]; //some other debug methods call this method
		}

		return print_r($var, $return);
	}

	public static function printNiceAndDie($var) {
		self::printNice($var);
		die();
	}

	public static function printComment($var) {
		echo "<!-- \n" . self::printNice($var, 1) . "\n -->";
	}

	public static function FirePHP($var) {
		if (is_scalar($var)) {
			$var = [$var];
		}

		$stack = debug_backtrace();

		$var['_debug'] = $stack[1];

		\libs\FirePHP\FirePHP::getInstance(true)->log($var);
	}

}
