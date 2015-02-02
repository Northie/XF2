<?php

namespace models\data;

trait relational_tools {

	public function describe() {
		$_class = trim(str_replace(__NAMESPACE__, "", __CLASS__), "\\");
		return [$_class=>$this->fields];
	}

	public function getResourceTypes() {
		return $this->resources;
	}

	public function mapToDb($data) {
		foreach ($this->fields as $i=> $key) {
			$this->data[$key] = $data[$key];
		}
		return $this;
	}

	public function mapFromDb($data) {
		foreach ($this->_fields as $key=> $val) {
			$this->data[$key] = $data[$key];
		}
		return $this;
	}

	public function get() {
		return $this->data;
	}

	public function getById($id) {
		$this->mapFromDb($this->db->read(['id'=>$id])[0]);
		return $this->get();
	}

	public function __get($field) {

		if (isset($this->_fields[$field])) {
			if (isset($this->data[$field])) {
				return $this->data[$field];
			}
			return null;
		}

		throw new RelationalExeption('Attempt to get non-existant field');
	}

	public function __set($field, $value) {
		if (isset($this->_fields[$field])) {
			$this->data[$field] = $value;
			return true;
		}

		throw new RelationalExeption("Attempt to set non-existant field, $field");
	}

	public function __call($name, $args = false) {

		$test = ['set'=>1, 'get'=>1];

		$mode = $name[0] . $name[1] . $name[2];
		$opperator = strtolower($name[3] . $name[4]);

		if ($test[$mode] && $opperator != 'by') {
			return $this->setGet($mode, substr($name, 3), $args);
		}

		if ($mode == 'get' && $opperator != 'by') {
			$field = substr($name, 5);
			if ($this->fields[$field]) {
				$this->mapTo($this->db->read([$field=>$args]));
			}
		}
	}

	private function setGet($mode, $name, $args) {
		if ($mode == 'get') {
			if (isset($this->_fields[$name])) {
				$this->data[$name];
			}

			if (isset($this->resources[$name])) {
				if (isset($this->data['id'])) {
					$resources = new $this->resources[$name]['class'];
					$resources->getByUserId($this->data['id']);
				}
			}
		}

		if ($mode == 'set') {
			if (isset($this->_fields[$name])) {
				$this->data[$name] = (string) $args;
				return true;
			}

			return false;
		}
	}

	public function save() {
		if (isset($this->id)) {
			$this->db->update($this->get());
		} else {
			$this->id = $this->db->create($this->get());
		}
	}

}