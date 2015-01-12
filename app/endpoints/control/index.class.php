<?php

namespace endpoints\control;

class index {
	use \endpoints\endpoint;
	
	public function __construct($request, $response, $filters) {
		$this->Init($request, $response, $filters);
	}

	public function Execute() {
		$this->data = ['dummy'=>'data'];
		
		$user = \models\data\factory::build('user');
		
		//$this->data['user'] = $user->getById(1);
		$this->data['user_meta'] = $user->describe();
		
		$user->map([
			'name'=>'Chris',
			'email'=>'a@b.com',
			'password'=>'password'
		])->save();
		
		$this->data['user'] = $user->get();
		
	}
}