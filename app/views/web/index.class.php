<?php

namespace views\web;

class index extends \views\view {

	public function toHtml() {
		include(\settings\registry::Load()->get('VIEW_PATH', 'WEB') . "default.php");
	}

}