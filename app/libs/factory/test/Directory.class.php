<?php

namespace libs\factory\test;

class Directory extends \libs\factory\processStep {
	use \libs\factory\flow;

	public function Build() {
		try {

			$nestedTest = new \libs\factory\nestedTest\NestedTestFactory($this->controller);
			$nestedTest->Build();
			$this->parent->notify($nestedTest->getNotifications());
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