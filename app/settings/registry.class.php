<?php

namespace settings;

/**
 * \settings\registry::Load()->set('REALM','DEFAULT');
 */
class registry {

	use \utils\traits\singleton;

	private $settings = [];

	private function __construct() {

	}

}
