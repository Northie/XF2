<?php

namespace models\data;

class user extends relational {
	use relational_tools;

	private $fields = ['id', 'email', 'password'];
	private $resources = ['invoices'=>['class'=>'invoice']];
	private $data = [];

}