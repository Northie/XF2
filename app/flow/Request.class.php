<?php

namespace flow;

class Request {
	use \Plugins\helper;

	private $requestKey = '';
	private $ajax = false;
	private $https = false;
	private $dynamic = [];
	private $endpoint = false;

	public function __construct($server = false) {

		if (!$this->before('RequestConstruct', $this)) {
			return false;
		}

		if (!$server) {
			//if no $_SERVER then throw exception? should come from cli.php?
			$server = $_SERVER;
		}

		foreach ($server as $key=> $val) {
			$this->__set($key, $val);
		}
		
		$this->__set('server',$server);

		$this->requestKey = uniqid();

		$realms = \settings\general::Load()->getRealms(true);

		$this->HTTP_SCHEME = 'http://';

		if ($this->HTTPS == 'on') {
			$this->HTTP_SCHEME = 'https://';
			$this->setIsHTTPS();
		}


		$url = $this->HTTP_SCHEME . $this->HTTP_HOST . $this->REQUEST_URI;
		
		$this->__set('URI',$url);


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
			$this->notify('NoRealm', $this);
		}

		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			$this->ajax = true;
			$this->notify('DetectingAjax', $this);
		}

		//set requested file extension
		$ext = explode(".", $server['REQUEST_URI']);
		if (count($ext) > 1) {
			$this->ext = array_pop($ext);
		}

		$this->after('RequestConstruct', $this);
	}

	public function isHTTPS() {
		return $this->https;
	}

	public function setIsHTTPS($set = true) {
		$this->https = $set;
		$this->notify('SetIsHttps', $this);
	}

	public function isAjax() {
		return $this->ajax;
	}

	public function setIsAjax($set = true) {
		$this->ajax = $set;
	}

	public function __get($key) {
		return $this->dynamic[$key];
	}

	public function __set($key, $val) {
		$this->dynamic[$key] = $val;
	}

	public function setEndpoint($endpoint) {
		$this->endpoint = $endpoint;
	}

	public function getEndpoint() {
		return $this->endpoint;
	}
	
	public function getRequestType() {
		return $this->requestType;
	}
	
	private function setRequestType($verb) {
		$this->requestType = strtoupper($verb);
	}

}