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

		$this->data['user']['model'] = $user->describe()['user']; //since when has this syntax been allowed?
		//$this->data['filters'] = $this->getAppliedFilters();

		$test = new \libs\factory\test\TestFactory($this);
		$test->Build();
		//$test->Defer();

		//$this->data['process']['notifications'] = $test->getNotifications();
		$this->data['process'] = $test->getReference();

		//dive into reading from CMS
	}

}