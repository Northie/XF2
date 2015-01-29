<?php

namespace services\data\relational\vendor\mysql;

class adapter extends \services\data\adapter {
	
	const QUERY_MODE_AND = 1;
	const QUERY_MODE_OR = 2;
	const QUERY_MODE_LIKE = 4;

	public function __construct($db) {
		$this->db = $db;
	}
	
	public function setModel($model) {
		$this->model = $model;
	}

	public function integrate($data) {

		foreach($this->model->describe()[$this->model->getName()] as $i => $key) {
			if(isset($data[$key])) {
				$this->data[$key] = $data[$key];
			}
		}
	}
	
	public function create($data) {
		
		$this->integrate($data);
		
		$pk = $this->model->getPrimaryKey();
		
		foreach($this->data as $key => $val) {
			if($key == $pk) {
				continue;
			}
			$sql_insert_fields[] = $key;
			$args[$key] = $val;
		}
		
		$sql = "INSERT INTO `".$this->model->getName()."` (`".implode("`, `",$sql_insert_fields)."`) VALUES (:".implode(", :",$sql_insert_fields).")";
		
		$this->getAdapter()->Execute($sql,$args);
		
		return $this->getAdapter()->returnLastInsertID();
		
	}

	public function read($where=false,$mode=adapter::QUERY_MODE_AND) {
		if(!$where) {
			$where = [];
		}
		
		$this->integrate($where);
		
		$sql_where = $args = [];
		
		foreach($this->data as $field => $value) {
			$sql_where[] = "`".$field."` = :".$field;
			if($mode & self::QUERY_MODE_LIKE) {
				$value = "LIKE '%".$value."%";
			} 
			$args[$field] = $value;
		}
		
		if($mode & self::QUERY_MODE_OR) {
			$where_sql = implode(" OR ",$sql_where);
		} else {
			$where_sql = implode(" AND ",$sql_where);
		}
		
		$sql = "
			SELECT
				*
			FROM
				`".$this->model->getName()."`
			".((count($args) > 0) ? "WHERE ".$where_sql : "")."
		";

		return $this->getAdapter()->Execute($sql,$args)->returnArray();
		
	}

	public function update($data) {
		var_dump(['here'=>__METHOD__,'data'=>$data]);
	}

	public function delete() {

	}

	public function query($sql, $args) {
		$this->db->Execute($sql, $args);
	}

	public function getAdapter() {
		return $this->db;
	}

}
