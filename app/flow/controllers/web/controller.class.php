<?php

namespace flow\controllers\web;

class FrontController extends \flow\controller {

	public function __construct() {

		parent::__construct();

		$endpointStr = trim($this->request->ENDPOINT, "/") == "" ? '\\endpoints\\web\\index' : '\\endpoints\\web' . str_replace("/", "\\", $this->request->ENDPOINT);

		//web endpoint defaults to web index?

		if (is_null(\settings\fileList::Load()->getFileForClass(trim($endpointStr, "/\\")))) {
			$endpointStr = '\\endpoints\\web\\index';
		}

		$endpoint = new $endpointStr($this->request, $this->response, $this->filters);

		$this->request->setEndpoint($endpoint);
	}

}