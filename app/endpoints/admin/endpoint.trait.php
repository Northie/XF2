<?php

namespace endpoints\admin;

trait endpoint {
	//use all endpoints generic functionality
	use \endpoints;

	//TODO add in stuff here generic to all admin-only endpoints

	public function __construct($request, $response, $filters) {
		$this->filters = $filters;
		$filters = $this->filterInsertAfter('default', 'user');
		$filters = $this->filterInsertAfter('user', 'permission');
	}

}