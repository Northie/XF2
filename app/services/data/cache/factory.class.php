<?php

namespace services\data\cache;

class factory {

	public static function Build($type = false) {

		if ($type) {
			$cls = "vendor/" . $type . "/adapter";
		} else {
			$type = 'apc'; //TODO get default;
			$cls = "vendor/" . $type . "/adapter";
		}

		$o = new $cls;

		return $o;
	}

}
