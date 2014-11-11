<?php

namespace flow;

abstract class controller {

	//public $filters = ['default', 'domain', 'security', 'data', 'view', 'action'];
    public $filters = ['test','action'];
	public $request;
	public $response;

	public function __construct() {

		$this->request = new \flow\Request;
		$this->response = new \flow\Response;

		$this->filterList = \libs\DoublyLinkedList\factory::Build();

		foreach ($this->filters as $f) {
			$_f = '\\flow\\filters\\' . $f . 'Filter';
			$filter = new $_f($this->filterList,$this->request,$this->response);
			$this->filterList->push($f, $filter);
            $filter->init();
		}
	}
    
    public function Execute() {
        
        //$c = $this->filterList->exportForward(1);

        
        $start = $this->filterList->getNodeValue($this->filters[0],1);
        $start->in();
    }

}
