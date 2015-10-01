<?php
namespace libs\factory\nestedTest;

class NestedTestFactory extends \libs\factory\factory {
	
	public function __construct($controller) {
		
		$this->controller = $controller;
		
		$this->steps = array(
		    'Foo',
		    'Bar'
		);
		
		$this->processList = \libs\DoublyLinkedList\factory::Build();
		
		foreach ($this->steps as $p) {
			$_s = __NAMESPACE__."\\".$p;
			$step = new $_s($this->processList, $this, $this->controller);
			$this->processList->push($p, $step);
			$step->init();
		}
		
	}
	
	public function success($step=false) {
		//
	}
	
	public function failed($step=false) {
		
	}

}