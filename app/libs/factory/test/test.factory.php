<?php
namespace libs\factory\test;

class TestFactory extends \libs\factory\factory {
	
	public function __construct($controller) {
		
		$this->controller = $controller;
		
		$this->steps = array(
		    'SaveData',
		    'Directory',
		    'Backup',
		    'MakeFiles',
		    'Compile',
		    'SaveTheme',
		);
		
		$this->processList = \libs\DoublyLinkedList\factory::Build();
		
		foreach ($this->steps as $p) {
			$_s = __NAMESPACE__.$p;
			$step = new $_s($this->processList, $this, $this->controller);
			$this->filterList->push($p, $step);
			$step->init();
		}
		
	}
	
	public function success($step=false) {
		//
	}
	
	public function failed($step=false) {
		
	}

}