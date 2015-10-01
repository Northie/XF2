<?php

namespace endpoints\admin;

class index {
	use \endpoints\admin\endpoint {
		\endpoints\admin\endpoint::__construct as adminConstructor;
	}

	public function __construct($request, $response, $filters) {
		$this->adminConstructor($request, $response, $filters);
	}

}