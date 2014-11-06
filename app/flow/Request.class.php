<?php

namespace flow;

class Request {

	private $requestKey = '';
    private $ajax = false;
    private $dynamic = [];

	public function __construct($server = false) {

        if(!$server) {
            //if no $_SERVER then throw exception? should come from cli.php?
            $server = $_SERVER;
        }
        
        foreach($server as $key => $val) {
            $this->__set($key,$val);
        }
        
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
        
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $this->ajax = true;
        }

        
	}
    
    public function isAjax() {
        return $this->ajax;
    }
    
    public function setIsAjax($set=true) {
        $this->ajax = $set;
    }

    public function __get($key) {
        return $this->dynamic[$key];
    }
    
    public function __set($key,$val) {
        $this->dynamic[$key] = $val;
    }
}