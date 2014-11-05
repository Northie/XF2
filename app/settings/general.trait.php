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

		$settings['REALMS'] = [];

		$settings['REALMS']['DEFAULT'] = [
			'DOMAIN'=>'local.xf2',
			'DOCUMENT_ROOT'=>$_SERVER['DOCUMENT_ROOT'],
			'APP_PATH'=>$_SERVER['DOCUMENT_ROOT'] . '/../',
			'WEB_PATH'=>'/'
		];
		$settings['REALMS']['ADMIN'] = [
			'DOMAIN'=>'local.xf2',
			'DOCUMENT_ROOT'=>$_SERVER['DOCUMENT_ROOT'],
			'APP_PATH'=>$_SERVER['DOCUMENT_ROOT'] . '/../',
			'WEB_PATH'=>'/admin/'
		];
		$settings['REALMS']['CONTROL'] = [
			'DOMAIN'=>'local.control.xf2',
			'DOCUMENT_ROOT'=>$_SERVER['DOCUMENT_ROOT'], //assuming control.domain.tld
			'APP_PATH'=>$_SERVER['DOCUMENT_ROOT'] . '/../',
			'WEB_PATH'=>'/'
		];
		$settings['REALMS']['API'] = [
			'DOMAIN'=>'local.api.xf2',
			'DOCUMENT_ROOT'=>$_SERVER['DOCUMENT_ROOT'], //assuming control.domain.tld
			'APP_PATH'=>$_SERVER['DOCUMENT_ROOT'] . '/../',
			'WEB_PATH'=>'/'
		];


		$this->settings = $settings;
	}

}
