<?php

namespace models\data;

class user extends relational {
	use relational_tools;

	private $fields = ['id', 'name','email', 'password'];
	private $resources = ['invoices'=>['class'=>'invoice']];
	private $data = [];
	
	public function __construct($data=false,$label=false) {
		
		$this->class = trim(str_replace(__NAMESPACE__, "", __CLASS__),"\\");
		
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