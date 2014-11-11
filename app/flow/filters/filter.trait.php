<?php

namespace flow\filters;

trait filter {

    private $currentNode;
    private $list;
    private $request;
    private $response;
    
	public function __construct($list,$request,$response) {
        $this->list = $list;
        $this->request = $request;
        $this->response = $response;
	}
    
    public function init() {
        $this->currentNode = $this->list->getLastNode();
    }

	private function getNext() {
        return $this->list->getNodeValue($this->currentNode->next->label);
	}

	private function getPrev() {
        return $this->list->getNodeValue($this->currentNode->previous->label);
	}

	public function FFW() {
        $filter = $this->getNext();
       
        if($filter) {
            $filter->in();
        } else {
            $this->out();
        }
	}

	public function RWD() {
		$filter = $this->getPrev();
        if($filter) {
            $filter->out();
        }
	}

}
