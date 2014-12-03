<?php

namespace endpoints\web;

class index {
	use \endpoints\endpoint;

	public function __construct($request, $response, $filters) {
		$this->filters = $filters;
		$filters = $this->filterInsertBefore('view', 'action');
	}

	public function Execute() {
		$this->data = ['dummy'=>'data'];

		$this->data['filters'] = $this->getAppliedFilters();
		
		//dive into reading from CMS
	}

}