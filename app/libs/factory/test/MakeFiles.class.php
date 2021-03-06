<?php

namespace libs\factory\test;

class MakeFiles extends \libs\factory\processStep {
	
	use \libs\factory\flow;
	
	public function Build() {
		try {
			echo "Building ".__CLASS__."<br />\n";
			
			//throw new \libs\factory\BuildException('Oops - only testing');
			
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
