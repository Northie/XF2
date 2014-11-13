<?php

namespace flow;

class Request {

	private $requestKey = '';
	private $ajax = false;
	private $https = false;
	private $dynamic = [];

	public function __construct($server = false) {

		if (!$server) {
			//if no $_SERVER then throw exception? should come from cli.php?
			$server = $_SERVER;
		}

		foreach ($server as $key=> $val) {
			$this->__set($key, $val);
		}

		$this->requestKey = uniqid();

		$realms = \settings\general::Load()->getRealms(true);

		$this->HTTP_SCHEME = 'http://';

		if ($this->HTTPS == 'on') {
			$this->HTTP_SCHEME = 'https://';
			$this->setIsHTTPS();
		}


		$url = $this->HTTP_SCHEME . $this->HTTP_HOST . $this->REQUEST_URI;

		$request = parse_url($url);

		//handle cli into $request?
		$realmSet = false;
		foreach ($realms as $realm=> $details) {

			if ($details['DOMAIN'] == $request['host'] && strpos($request['path'], $details['WEB_PATH']) === 0) {

				$endpoint = preg_replace("%^" . $details['WEB_PATH'] . "%", "/", $request['path']);

				\settings\registry::Load()->set(['REQUEST', 'REALM'], $realm);
				\settings\registry::Load()->set(['REQUEST', 'ENDPOINT'], $endpoint);

				$this->REALM = $realm;
				$this->ENDPOINT = $endpoint;

				$realmSet = true;
				break;
			}
		}

		if (!$realmSet) {
			die('Could not determine a realm');
		}

		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			$this->ajax = true;
		}
	}

	public function isHTTPS() {
		return $this->ajax;
	}

	public function setIsHTTPS($set = true) {
		$this->https = $set;
	}

	public function __get($key) {
		return $this->dynamic[$key];
	}

	public function __set($key, $val) {
		$this->dynamic[$key] = $val;
	}

}