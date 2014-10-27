<?php

namespace services\data\relational\vendor\mysql;

class adapter extends services\data\adapter {
	public function __construct($key='default') {
        $this->db = DB::Load($key);
	}

	public function create() {

	}

	public function read() {

	}

	public function update() {
		
	}

	public function delete() {

	}
    
    public function query($sql,$args) {
        $this->db->Execute($sql,$args);
    }
    
    public function getAdapter() {
        return $this->db;
    }
    
}