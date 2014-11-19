<?php

namespace tokenizer;

class syntaxTree {

	//accept token stream
	//parse into an "Abstract Syntax Tree"

	private $closeAt = -1;
	private $tree;

	public function __construct() {
		$this->tree = \libs\DoublyLinkedList\factory::Build();
	}

	public function setStream($stream) {
		$this->stream = $stream;
	}

	private function buildSegment($idx, $token) {
		$ignore = 0;
		$segment = [];

		$key = key($token);

		$foundClose = false;

		for ($i = $idx; $i < $this->treeSize; $i++) {

			if (key($this->stream[$i]) == $key) {
				$ignore++;
			}
			if (key($this->stream[$i]) == $token[$key]['closed_by']) {
				if ($ignore > 0) {
					$ignore--;
				}
				if ($ignore == 0) {
					$foundClose = true;
					break;
				}
			}
			$segment[$i] = $this->stream[$i];
		}



		if (!$foundClose) {
			throw new \Exception("Could not close " . $key . " opened at " . $idx . ".");
		}

		//\utils\debug::printNice($segment);

		end($segment);
		$this->closeAt = key($segment);
		reset($segment);

		//var_dump($this->closeAt);

		return $segment;
	}

	public function toTree() {

		$this->treeSize = count($this->stream);

		foreach ($this->stream as $idx=> $token) {

			if ($idx < $this->closeAt) {
				continue;
			}

			$key = key($token); //token name

			$obj = new \stdClass();
			$obj->type = $key;
			$obj->data = $token[$key];

			if (isset($token[$key]['is_opener']) && $token[$key]['is_opener']) {
				$segment = $this->buildSegment($idx + 1, $token);
				$obj->branch = $this->toBranch($segment);
				$obj->leaf = false;
			} else {
				$obj->leaf = true;
				$obj->branch = false;
			}

			$this->tree->push($idx, $obj);
		}
	}

	private function toBranch($segment) {
		$branch = \libs\DoublyLinkedList\factory::Build();

		foreach ($segment as $idx=> $token) {

			if ($idx < $this->closeAt) {
				continue;
			}

			$key = key($token); //token name

			$obj = new \stdClass();
			$obj->type = $key;
			$obj->data = $token[$key];

			if (isset($token[$key]['is_opener']) && $token[$key]['is_opener']) {

				$segment = $this->buildSegment($idx + 1, $token);

				$obj->branch = $this->toBranch($segment);

				$obj->leaf = false;
			} else {
				$obj->leaf = true;
				$obj->branch = false;
			}

			$branch->push($idx, $obj);
		}

		$this->tree->push($idx, $branch);
	}

	public function getTree() {
		return $this->tree;
	}

}