<?php

namespace flow;

class Response {

	public function __construct() {

	}

	public function setData($data) {
		$this->data = $data;
	}

	public function getData() {
		return $this->data;
	}

	public function getResponseFormat() {
		return $this->format;
	}

	public function setResponseFormat($format) {
		$this->format = $format;
	}

}