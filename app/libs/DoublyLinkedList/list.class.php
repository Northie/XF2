<?php

namespace libs\DoublyLinkedList;

class linkedList implements \Iterator { //which implements Traversable

	private $firstNode;
	private $lastNode;
	private $count;
	private $index = [];
	private $values = [];
    private $position = '';

	function __construct() {
		$this->firstNode = NULL;
		$this->lastNode = NULL;
		$this->count = 0;
	}

	public function isEmpty() {
		return ($this->firstNode == NULL);
	}

	public function insertFirst(string $key, $value = false) {
		$newLink = new node($key);

		$this->index[$key] = $newLink;
		$this->values[$key] = $value;

		if ($this->isEmpty()) {
			$this->lastNode = $newLink;
		} else {
			$this->firstNode->previous = $newLink;
		}

		$newLink->next = $this->firstNode;
		$this->firstNode = $newLink;
        
		$this->count++;
	}

	public function push($key, $value) {
		$this->insertLast($key, $value);
	}

	public function insertLast($key, $value = false) {
		$newLink = new node($key);

		$this->index[$key] = $newLink;
		$this->values[$key] = $value;

		if ($this->isEmpty()) {
			$this->firstNode = $newLink;
		} else {
			$this->lastNode->next = $newLink;
		}

		$newLink->previous = $this->lastNode;
		$this->lastNode = $newLink;
		$this->count++;
	}

	public function insertAfter($search, $key, $value = false) {

        $current = $this->index[$search];

        if ($current == NULL) {
            return false;
        }
        
		$newLink = new node($key);

		$this->index[$key] = $newLink;
		$this->values[$key] = $value;

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

	public function insertBefore($search, $key, $value = false) {
        
        $current = $this->index[$search];

        if ($current == NULL) {
            return false;
        }
		$newLink = new node($key);

		$this->index[$key] = $newLink;
		$this->values[$key] = $value;

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

		unset($this->index[$this->firstNode->label]);

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

		unset($this->index[$this->lastNode->label]);

		if ($this->firstNode->next == NULL) {
			$this->firstNode = NULL;
		} else {
			$this->lastNode->previous->next = NULL;
		}

		$this->lastNode = $this->lastNode->previous;
		$this->count--;
		return $temp;
	}

	public function deleteNode($search) {

		$current = $this->index[$search];

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

		unset($this->index[$search]);

		$this->count--;
		return $current;
	}

	public function exportForward($withValues = false) {

		$current = $this->firstNode;

		$a = array();

		while ($current != NULL) {
			if ($withValues) {
				$a[$current->readNode()] = $this->values[$current->readNode()];
			} else {
				$a[] = $current->readNode();
			}
			$current = $current->next;
		}

		return $a;
	}

	public function exportBackward($withValues = false) {

		$current = $this->lastNode;

		$a = array();

		while ($current != NULL) {
			if ($withValues) {
				$a[$current->readNode()] = $this->values[$current->readNode()];
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
    
    public function getNode($search) {
        $current = $this->index[$search];
        return $current;
    }
    
    public function getNodeValue($search) {
        return $this->values[$search];
    }
    
    public function getLastNode($value=false) {
        if($value) {
            return $this->values[$this->lastNode->label];
        }
        return $this->lastNode;
    }
    
    public function getFirstNode($value=false) {
        
        if($value) {
            return $this->values[$this->firstNode->label];
        }
        
        return $this->firstNode;
    }
    
    //methods to implemnet Iterator and Traversable:
    
    public function current () {
        if(!$this->position) {
            $this->position = $this->firstNode->label;
        }
        return $this->index[$this->position];
    }
    
    public function key () {
        if(!$this->position) {
            $this->position = $this->firstNode->label;
        }
        return $this->position;
    }
    
    public function next ( ) {
        if(!$this->position) {
            $this->position = $this->firstNode->label;
        }
        
        $return = $this->index[$this->position]->next;
        
        $this->position = $return->label;
        
        return $r;
    }
    
    public function rewind ( ) {
        $this->position = $this->firstNode->label;
    }
    
    public function valid () {
        return isset($this->index[$this->position]);
    }
}