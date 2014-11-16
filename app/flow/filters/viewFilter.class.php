<?php

namespace flow\filters;

class viewFilter {
	use filter;

	public function in() {

		$this->FFW();
	}

	public function out() {
		$data = $this->response->getData();

		var_dump($data);

		if (is_null($this->request->ext)) {
			if ($this->request->isAjax()) {
				$renderer = 'JSON';
			} else {
				$renderer = 'HTML';
			}
		} else {
			$renderer = strtoupper($this->request->ext);
		}

		var_dump($renderer);

		$this->RWD();
	}

}