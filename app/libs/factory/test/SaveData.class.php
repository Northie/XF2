<?php

namespace libs\factory\test;

class SaveData extends \libs\factory\processStep {
	
	use \libs\factory\flow;
	
	public function Build() {
		try {
			echo "Building ".__CLASS__."<br />\n";
		} catch (\libs\factory\BuildException $e) {
			return $this->failed();
		}
		
		$this->success();
		
	}
	
	public function Unbuild() {
		echo "Un-Building ".__CLASS__."<br />\n";
		
		$this->RWD();
	}
	
	public function __destruct() {
		echo "Destructing ".__CLASS__."<br />\n";
	}

}