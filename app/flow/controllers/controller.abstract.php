<?php

namespace flow;

abstract class controller {

	//public $filters = ['default', 'domain', 'security', 'data', 'view', 'action'];
	public $filters = ['test'];
	public $request;
	public $response;

	public function __construct() {

		$this->request = new \flow\Request;
		$this->response = new \flow\Ressponse;

		$this->filterList = \libs\DoublyLinkedList\factory::Build();

		foreach ($this->filters as $f) {
			$_f = '\\flow\\filters\\' . $f . 'Filter';
			$filter = new $_f;
			$this->filterList->push($f, $filter);
		}
	}

}