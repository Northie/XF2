<?php

namespace libs\xml;

/**
 * $p = new xml2json;
 * $json = $p->setXml($str)->convert()->getJson()
 */

class xml2array {
	
	private $xml = false;
	private $arr = [];
	
	public function __construct($xml=false) {
		$this->xml = $xml;
	}
	
	public function getFromURL($url) {
		$this->xml = file_get_contents($url);
		return $this;
	}
	
	public function setXml($xml,$url=false) {
		if($url) {
			$this->getFromURL($xml);
		} else {
			$this->xml = $xml;
		}
		return $this;
	}
	
	public function convert() {
		if($this->xml) {
			$doc = simplexml_load_string($this->xml);
			$this->arr = \utils\Tools\object2array($doc);
		}
		return $this;
	}
	
	public function getArray() {
		return $this->arr;
	}
}
