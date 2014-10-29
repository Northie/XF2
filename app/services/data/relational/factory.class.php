<?php

namespace services\data\relational;

class factory {

	public static function Build($label = 'default') {

		$settings = \settings\database::Load()->get($label);

		$cls = "vendor/" . $settings['type'] . "/adapter";

		$o = new $cls(XF_DBA::Load($label));

		return $o;
	}

}
