<?php

namespace endpoints\web;

class index {
	use \endpoints\endpoint;
	
	public function __construct($request, $response, $filters) {

		$this->Init($request, $response, $filters);
		
		$filters = $this->filterInsertBefore('view', 'action');
	}

	public function Execute() {
		$this->data = ['dummy'=>'data'];
	}

}
