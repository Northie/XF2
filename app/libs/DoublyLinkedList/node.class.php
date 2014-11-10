<?php

namespace libs\DoublyLinkedList;

class node {

	public $data;
	public $key;
	public $next;
	public $previous;

	function __construct($data) {
		$this->data = $data;
		if ($key) {
			$this->key = $key;
		}
	}

	public function readNode() {
		return $this->data;
	}

}
