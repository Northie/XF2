<?php

namespace models\data;

abstract class data implements iData {

	protected $provider;
	protected $class;

	public function setProvider(\services\data\adapter $adapter) {
		$this->provider = $adapter;
	}
	
	public function getName() {
		return $this->class;
	}

}