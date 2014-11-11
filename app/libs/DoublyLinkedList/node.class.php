<?php

namespace libs\DoublyLinkedList;

class node {

	//public $data;
	public $label;
	public $next;
	public $previous;

	function __construct($label) {
		$this->label = $label;
	}

	public function readNode() {
		return $this->label;
	}

}
