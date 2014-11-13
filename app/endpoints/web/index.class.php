<?php

namespace endpoints\web;

class index {
	use \endpoints\endpoint;

	public function __construct($request, $response, $filters) {
		var_dump($filters);
	}

}