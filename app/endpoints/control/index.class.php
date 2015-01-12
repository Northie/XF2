<?php

namespace endpoints\control;

class index {
	use \endpoints\endpoint;
	
	public function __construct($request, $response, $filters) {
		$this->filters = $filters;
	}

	public function Execute() {
		$this->data = ['dummy'=>'data'];
		
		$user = \models\data\factory::build('user');
		
		$user->getById(1);
	}
}