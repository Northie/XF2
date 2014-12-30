<?php

namespace libs\factory;

abstract class factory {
	
	protected $deferred = false;
	protected $queue = false;
	
	public function Build() {
		ignore_user_abort(true);
		$start = $this->processList->getFirstNode(true);
		$start->start();
	}

	public function Defer() {
		$this->deferred = true;
		//get list of steps
		//get queue
		//get queue reference
		//queue items with reference to session and queue ref
		//return reference
	}
	
	public function getFeedback($reference) {
		//use reference and queue to get 
	}
	
	public function isDeferred() {
		return $this->deferred;
	}
	
	
	public function success($step=false) {
		if($this->isDeferred()) {
			$this->queue->log(get_class($step).' Complete');
		}
	}
	
	public function failed($step=false) {
		if($this->isDeferred()) {
			$this->queue->log(get_class($step).' Failed');
		}		
	}
	
}
