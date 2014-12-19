<?php

namespace models\data;

class user extends relational {
	use relational_tools;

	private $fields = ['id', 'email', 'password'];
	private $resources = ['invoices'=>['class'=>'invoice']];
	private $data = [];
	
	public function __construct($data=false,$label=false) {
		if($label) {
			parent::__construct($label);
		} else {
			parent::__construct();
		}
		
		if($data) {
			$data = (array) $data;
			$this->map($data);
		}
	}

}