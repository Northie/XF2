<?php

namespace models\data;

abstract class relational extends data {

	protected $db;
	protected $primarykey = 'id';
	protected $_fields = [];

	public function __construct($label) {
		
		$this->db = \services\data\relational\factory::Build($label);
		$this->setProvider($this->db);
		$this->provider->setModel($this);
		
		foreach($this->fields as $i=> $field) {
			$this->_fields[$field] = true;
		}
	}
	
	public function getPrimaryKey() {
		return $this->primarykey;
	}

}