<?php

namespace models\data;

class user extends relational {
	use relational_tools {
		relational_tools::mapToDb as parentMapToDb;
	}

	protected $fields = ['id', 'name','email', 'password'];
	protected $resources = ['invoices'=>['class'=>'invoice']];
	protected $data = [];
	
	public function __construct($data=false,$label=false) {
		
		$this->setName(trim(str_replace(__NAMESPACE__, "", __CLASS__),"\\"));
		
		if($label) {
			parent::__construct($label);
		} else {
			parent::__construct();
		}
		
		if($data) {
			$data = (array) $data;
			$this->mapToDb($data);
		}
	}
	
	public function mapToDb($data) {
		
		$pw = new \utils\password();
		
		$data['password'] = $pw->getHashToStore($data['password']);
		
		return $this->parentMapToDb($data);
		
	}

}