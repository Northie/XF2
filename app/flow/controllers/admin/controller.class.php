<?php

namespace flow\controllers\admin;

class FrontController extends \flow\controller {
	
	public $filters = ['view','action'];

	public function __construct() {

		parent::__construct();
		
		$endpointStr = trim($this->request->ENDPOINT, "/") == "" ? '\\endpoints\\control\\index' : '\\endpoints\\control' . str_replace("/", "\\", $this->request->ENDPOINT);

		//web endpoint defaults to web index?

		if (is_null(\settings\fileList::Load()->getFileForClass(trim($endpointStr, "/\\")))) {
			$endpointStr = '\\endpoints\\control\\index';
		}

		$endpoint = new $endpointStr($this->request, $this->response, $this->filters);

		$this->request->setEndpoint($endpoint);
		
	}

}