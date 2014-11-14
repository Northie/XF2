<?php

namespace flow\controllers\web;

class FrontController extends \flow\controller {

	public function __construct() {

		parent::__construct();

		$endpointStr = trim($this->request->ENDPOINT,"/") == "" ? '\\endpoints\\web\\index' : '\\endpoints\\web' . str_replace("/", "\\", $this->request->ENDPOINT);

		$this->endpoint = new $endpointStr($this->request, $this->response, $this->filterList);
	}

}