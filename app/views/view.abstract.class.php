<?php

namespace views;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of view
 *
 * @author Chris
 */
abstract class view {

	public final function __construct($renderer, $data) {
		$this->renderer = $renderer;
		$this->data = $data;
	}

	public function Execute() {
		switch ($this->renderer) {
			case 'JSON':
				$this->toJson();
				break;
			case 'HTML':
				$this->toHtml();
				break;
			default:
			//eg webkitHtmlToPdf for PDFs
			//make it up!
		}
	}

	public function toJson() {
		$this->output = json_encode($data, JSON_PRETTY_PRINT);
	}

	abstract function toHtml();
}