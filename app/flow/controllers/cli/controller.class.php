<?php

namespace flow\controllers\cli;

class FrontController extends \flow\controller {

	public function __construct() {

		//parent::__construct();

		$this->init();

		$cliServerArgs = $_SERVER;

		$this->request = new \flow\Request($cliServerArgs);
		$this->response = new \flow\Response;

		$this->filterList = \libs\DoublyLinkedList\factory::Build();

		foreach ($this->filters as $f) {
			//stack cli filter?
			$_f = '\\flow\\filters\\' . $f . 'Filter';
			$filter = new $_f;
			$this->filterList->push($f, $filter);
		}

		var_dump($this->request);
		die();
	}

	public function Init() {

		$_SERVER['DOCUMENT_ROOT'] = $_SERVER['PWD'];

		switch (true) {
			case (preg_match("/^\-{1,2}/", $_SERVER['argv'][1])):
				$this->basic();
				break;
			case (preg_match("/^\-{1,2}/", $_SERVER['argv'][2])):
				$this->command();
				break;
			case (strtoupper($_SERVER['argv'][1]) == 'API'):
				$this->api();
				break;
			default:
				throw new \Exception('Request not understood');
		}
	}

	private function getArgs($startAt) {

		$c = $_SERVER['argc'];

		for ($i = $startAt; $i < $c; $i+=2) {
			$_REQUEST[preg_replace("/^\-{1,2}/", "", $_SERVER['argv'][$i])] = $_SERVER['argv'][$i + 1];
		}
	}

	/*
	 * ./cli.php --arg1 val1 --arg2 val2
	 */

	private function basic() {
		getArgs(1);
		$_GET = $_REQUEST;
	}

	/*
	 * ./cli.php COMMAND --arg1 val1 --arg2 val2
	 */

	private function command() {
		getArgs(2);
		$_GET = $_REQUEST;
		$_SERVER['REQUEST_URI'] = $_SERVER['argv'][1];
	}

	/*
	 * cli.php API v1 GET /search --q 'anystring'
	 */

	private function api() {
		$methods = [
			'POST'=>true,
			'GET'=>true,
			'PUT'=>true,
			'DELETE'=>true,
		];

		$version = (int) str_replace("v", "", $_SERVER['argv'][2]);

		if ($methods[$_SERVER['argv'][3]]) {
			$method = $_SERVER['argv'][3];
			$use = 4;
		} else {
			$method = 'GET';
			$use = 3;
		}

		$endpoint = $_SERVER['argv'][$use];

		$_SERVER['REQUEST_URI'] = "/v" . $version . "/" . $endpoint;
		
		$GLOBALS['_'.$method] = $_REQUEST;

		getArgs($use + 1);
	}

}