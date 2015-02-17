<?php

namespace settings;

trait _database {

	private $settings = [];

	protected function readSettings() {
		$this->settings = parse_ini_file($settings['CONF_DIR'] . "/ini/database.ini", 1);
	}

}