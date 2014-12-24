<?php
namespace libs\factory\test;

class TestFactory {
	
	public function __construct($caller) {
		
		$this->caller = $caller;
		
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
			$_f = __NAMESPACE__.$p;
			$step = new $_f($this->processList, $this, $this->caller);
			$this->filterList->push($f, $filter);
			$filter->init();
		}
		
	}

	public function Build() {
		$start = $this->processList->getFirstNode(true);
		$start->build();
	}

}