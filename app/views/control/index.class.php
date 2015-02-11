<?php

namespace views\control;

class index extends \views\view {

	public function toHtml() {
		include(\settings\registry::Load()->get('VIEW_PATH', 'CONTROL') . "default.php");
	}

}