<?php

namespace libs\factory\nestedTest;

class Bar extends \libs\factory\processStep {
	use \libs\factory\flow;

	public function Build() {
		try {
			$this->parent->notify("Building " . __CLASS__);
		} catch (\libs\factory\BuildException $e) {
			return $this->failed();
		}

		$this->success();
	}

	public function Unbuild() {
		$this->parent->notify("Un-Building " . __CLASS__);

		$this->RWD();
	}

	public function __destruct() {
		$this->parent->notify("Destructing " . __CLASS__);
	}

}