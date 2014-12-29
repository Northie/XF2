<?php

namespace libs\factory\test;

class SaveData extends \libs\factory\processStep {
	
	use \libs\factory\flow;
	
	public function __construct() {
		;
	}
	
	public function Build() {
		try {
			
		} catch (\libs\factory\BuildException $e) {
			$this->failed();
		}
		
		$this->success();
		
		//$this->success();	//moves next
		//$this->failed();	//unbuilds
		//$this->revert();	//?
		//$this->rollBack();	//?
		
	}
	
	public function Unbuild() {
		
	}
	
	public function __destruct() {
		;
	}

}