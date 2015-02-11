<?php

namespace flow;

class Response {
	use \Plugins\helper;

	private $viewScript = false;

	public function __construct() {

		if (!$this->before('ResponseConstruct', $this)) {
			return false;
		}

		$this->after('ResponseConstruct', $this);
	}

	public function setData($data) {
		if (!\Plugins\Plugins::Load()->DoPlugins('onBeforeResponseSetData', $this)) {
			return false;
		}
		$this->data = $data;
		$this->after('ResponseSetData', $this);
	}

	public function getData() {
		if (!$this->before('ResponseGetData', $this)) {
			return false;
		}
		return $this->data;
	}

	public function getResponseFormat() {
		if (!$this->before('ResponseGetResponseFormat', $this)) {
			return false;
		}
		return $this->format;
	}

	public function setResponseFormat($format) {
		if (!$this->before('ResponseSetResponseFormat', $this)) {
			return false;
		}

		$this->format = $format;

		$this->after('ResponseSetResponseFormat', $this);
	}

	public function setViewScript($view) {

		if (!$this->before('ResponseSetViewScript', $this)) {
			return false;
		}

		$this->viewScript = $view;

		$this->after('ResponseSetViewScript', $this);
	}

	public function getViewScript() {

		if (!$this->before('ResponseGetViewScript', $this)) {
			return false;
		}

		return $this->viewScript;

		$this->after('ResponseSetViewScript', $this);
	}

}