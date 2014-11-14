<?php

namespace endpoints\web;

class index {
	use \endpoints\endpoint;

	public function __construct($request, $response, $filters) {
        $filters->insertBefore('action','view', new \flow\filters\viewFilter($request,$response,$filters));
	}
    
    public function Execute() {
        var_dump($_SESSION);
    }

}