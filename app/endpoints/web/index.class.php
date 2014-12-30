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

		$user = \models\data\factory::build('user');

		$this->data = ['user'=>$user->describe()];

		//$this->data['filters'] = $this->getAppliedFilters();

		$test = new \libs\factory\test\TestFactory($this);
		$test->Build();

		//dive into reading from CMS
	}

}