<?php

namespace flow\controllers\web;

class FrontController extends \flow\controller {

	public function __construct() {

		parent::__construct();
		//untested

		$req = explode("/", trim($this->request->ENDPOINT, "/"));
		$params = [];

		while (true) {
			$endpointStr = '\\endpoints\\web\\' . implode("\\", $req);
			if (is_null(\settings\fileList::Load()->getFileForClass($endpointStr))) {
				array_unshift($params, array_pop($req));
			} else {
				break;
			}
			if (count($req) == 0) {
				$endpointStr = '\\endpoints\\web\\index';
				break;
			}
		}

		$endpoint = new $endpointStr($this->request, $this->response, $this->filters);

		$this->request->setEndpoint($endpoint);

	}

}
