<?php

namespace flow\controllers\cli;

class FrontController extends \flow\controller {

	public function __construct() {

		//parent::__construct();
        
		$this->request = new \flow\Request($cliServerArgs);
		$this->response = new \flow\Ressponse;

		$this->filterList = \libs\DoublyLinkedList\factory::Build();

		foreach ($this->filters as $f) {
            //stack cli filter?
			$_f = '\\flow\\filters\\' . $f . 'Filter';
			$filter = new $_f;
			$this->filterList->push($f, $filter);
		}

		var_dump($this->request);
        die();
	}

}
