<?php

namespace libs\DoublyLinkedList;

class linkedList {

	private $firstNode;
	private $lastNode;
	private $count;
	private $index = [];
	private $container = [];

	function __construct() {
		$this->firstNode = NULL;
		$this->lastNode = NULL;
		$this->count = 0;
	}

	public function isEmpty() {
		return ($this->firstNode == NULL);
	}

	public function insertFirst($data, $contains = false) {
		$newLink = new node($data);

		$this->index[$data] = $newLink;
		$this->container[$data] = $contains;

		if ($this->isEmpty()) {
			$this->lastNode = $newLink;
		} else {
			$this->firstNode->previous = $newLink;
		}

		$newLink->next = $this->firstNode;
		$this->firstNode = $newLink;
		$this->count++;
	}

	public function push($data, $contains) {
		$this->insertLast($data);
	}

	public function insertLast($data, $contains = false) {
		$newLink = new node($data);

		$this->index[$data] = $newLink;
		$this->container[$data] = $contains;

		if ($this->isEmpty()) {
			$this->firstNode = $newLink;
		} else {
			$this->lastNode->next = $newLink;
		}

		$newLink->previous = $this->lastNode;
		$this->lastNode = $newLink;
		$this->count++;
	}

	public function insertAfter($key, $data, $contains = false) {

		/*
		  $current = $this->index[$key];

		  if ($current == NULL) {
		  return false;
		  }
		  // */

		//*

		$current = $this->firstNode;

		while ($current->data != $key) {
			$current = $current->next;

			if ($current == NULL) {
				return false;
			}
		}
		//*/

		$newLink = new node($data);

		$this->index[$data] = $newLink;
		$this->container[$data] = $contains;

		if ($current == $this->lastNode) {
			$newLink->next = NULL;
			$this->lastNode = $newLink;
		} else {
			$newLink->next = $current->next;
			$current->next->previous = $newLink;
		}

		$newLink->previous = $current;
		$current->next = $newLink;
		$this->count++;

		return true;
	}

	public function insertBefore($key, $data, $contains = false) {

		/*
		  $current = $this->index[$key];

		  if ($current == NULL) {
		  return false;
		  }
		  // */

		//*
		$current = $this->firstNode;

		while ($current->data != $key) {
			$current = $current->next;

			if ($current == NULL)
				return false;
		}
		//*/

		$newLink = new node($data);

		$this->index[$data] = $newLink;
		$this->container[$data] = $contains;

		if ($current == $this->firstNode) {
			$newLink->next = NULL;
			$this->firstNode = $newLink;
		} else {
			$newLink->previous = $current->previous;
			$current->previous->next = $newLink;
		}

		$newLink->next = $current;
		$current->previous = $newLink;
		$this->count++;

		return true;
	}

	public function deleteFirstNode() {

		$temp = $this->firstNode;

		unset($this->index[$this->firstNode->data]);

		if ($this->firstNode->next == NULL) {
			$this->lastNode = NULL;
		} else {
			$this->firstNode->next->previous = NULL;
		}

		$this->firstNode = $this->firstNode->next;
		$this->count--;



		return $temp;
	}

	public function deleteLastNode() {

		$temp = $this->lastNode;

		unset($this->index[$this->lastNode->data]);

		if ($this->firstNode->next == NULL) {
			$this->firstNode = NULL;
		} else {
			$this->lastNode->previous->next = NULL;
		}

		$this->lastNode = $this->lastNode->previous;
		$this->count--;
		return $temp;
	}

	public function deleteNode($key) {

		//$current = $this->index[$key];
		//*
		$current = $this->firstNode;

		while ($current->data != $key) {
			$current = $current->next;
			if ($current == NULL)
				return null;
		}
		//*/

		if ($current == $this->firstNode) {
			$this->firstNode = $current->next;
		} else {
			$current->previous->next = $current->next;
		}

		if ($current == $this->lastNode) {
			$this->lastNode = $current->previous;
		} else {
			$current->next->previous = $current->previous;
		}

		unset($this->index[$key]);

		$this->count--;
		return $current;
	}

	public function exportForward($withContainer = false) {

		$current = $this->firstNode;

		$a = array();

		while ($current != NULL) {
			if ($withContainer) {
				$a[$current->readNode()] = $this->container[$current->readNode()];
			} else {
				$a[] = $current->readNode();
			}
			$current = $current->next;
		}

		return $a;
	}

	public function exportBackward($withContainer = false) {

		$current = $this->lastNode;

		$a = array();

		while ($current != NULL) {
			if ($withContainer) {
				$a[$current->readNode()] = $this->container[$current->readNode()];
			} else {
				$a[] = $current->readNode();
			}
			$current = $current->previous;
		}

		return $a;
	}

	public function total() {
		return $this->count;
	}

}
