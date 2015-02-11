<?php

namespace settings;

trait _general {

	protected $settings = [];

	protected function readSettings() {
		$settings = [];

		//$settings['ENVIRONMENT'] = 'LIVE';
		//$settings['ENVIRONMENT'] = 'STAGING';	//User Acceptance
		//$settings['ENVIRONMENT'] = 'TESTING';	//Quality Assurance
		$settings['ENVIRONMENT'] = 'DEVELOPMENT';

		//Basic Routing is done through Realms
		//the request class will use this to seed the realm value of the registry

		$settings['ENVIRONMENT'] = \settings\registry::Load()->get('ENVIRONMENT');
		$settings['CONF_DIR'] = \settings\registry::Load()->get('CONF_DIR');

		$settings['REALMS'] = [];

		if (@include($settings['CONF_DIR'] . "/var/realms.php")) {

			/**
			 * Get realm settings
			 */
			if (@include($settings['CONF_DIR'] . "/var/realms.php")) {
				$settings['REALMS'] = $conf_realms;
			} else {
				$settings['REALMS'] = parse_ini_file($settings['CONF_DIR'] . "/ini/realms.ini", 1);
				foreach ($settings['REALMS'] as $realm=> $details) {
					$settings['REALMS'][$realm]['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT'] . $settings['REALMS']['DOCUMENT_ROOT'];

					$settings['REALMS'][$realm]['APP_PATH'] = $settings['REALMS'][$realm]['DOCUMENT_ROOT'] . $settings['REALMS'][$realm]['APP_PATH'];
				}

				$str = '<?php' . "\n\n" . '$conf_realms = ' . var_export($settings['REALMS'], 1) . ';';
				file_put_contents($settings['CONF_DIR'] . "/var/realms.php", $str);
			}

			$this->settings = $settings;
		}


		$this->settings = $settings;
	}

}