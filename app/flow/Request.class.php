<?php

namespace flow;

class Request {

	private $requestKey = '';

	public function __construct() {

		$this->requestKey = uniqid();

		$realms = \settings\general::Load()->getRealms(true);

		$url = $_SERVER['REQUEST_URI'];

		$request = parse_url($url);

		//handle cli into $request?
		$realmSet = false;
		foreach ($realms as $realm=> $details) {
			if ($details['DOMAIN'] == $request['host'] && strpos($request['path'], $details['PATH']) === 0) {

				$endpoint = preg_replace("/^" . $details['PATH'] . "/", "", $request['path']);

				\settings\registry::Load()->set(['REQUEST', 'REALM'], $realm);
				\settings\registry::Load()->set(['REQUEST', 'ENDPOINT'], $endpoint);

				$realmSet = true;
				break;
			}
		}

		if (!$realmSet) {

		}
	}

}