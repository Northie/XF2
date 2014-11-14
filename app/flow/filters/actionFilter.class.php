<?php

namespace flow\filters;

class actionFilter {
	use filter;

	public function in() {

        $_SESSION['filters'][] = __METHOD__;
        
		var_dump($this->request);
		var_dump(\settings\registry::Load()->get());

		$this->FFW();
	}

	public function out() {
		$this->RWD();
	}

}