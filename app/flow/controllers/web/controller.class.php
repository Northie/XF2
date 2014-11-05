<?php

namespace flow\controllers\web;

class FrontController extends \flow\controller {

	public function __construct() {

		parent::__construct();

		var_dump($this->request);
        die();
	}

}
