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
		
		$this->data['user_meta'] = $user->describe();
		//*
		$pw = new \utils\password;
		
		$user->mapToDb([
			'name'=>'Chris',
			'email'=>'a+'.uniqid().'@b.com',
			'password'=> $pw->generatePlain()
		])->save();
		
		$this->data['user'] = $user->get();
		
		//*/
		
		$this->data['user_r'] = $user->getById($this->data['user']['id']);
		

		$user = \models\data\factory::Build('user');

		$user->map([
			'name'=>'Chris',
			'email'=>'chris@xeneco.co.uk',
			'password'=>'password',
		])->save();

		$this->data['user'] = $user->get();
	}

}
