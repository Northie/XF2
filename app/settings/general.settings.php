<?php

namespace settings;

class general {
	use \utils\traits\singleton;
use general;
use settings;

	private function __construct() {
		$this->readSettings();
	}

	public function getRealms($with = false) {
		if ($with) {
			return $this->get('REALMS');
		}

		return array_keys($this->get('REALMS'));
	}

}