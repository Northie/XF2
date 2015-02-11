<?php

namespace flow\filters;

class viewFilter {
	use filter;

	public function in() {

		$endPoint = get_class($this->request->getEndpoint());
		$viewScript = preg_replace("/^endpoints/", "views", $endPoint);
		$this->response->setViewScript($viewScript);

		$this->FFW();
	}

	public function out() {
		$data = $this->response->getData();

		if (is_null($this->request->ext)) {
			if ($this->request->isAjax()) {
				$renderer = 'JSON';
			} else {
				$renderer = 'HTML';
			}
		} else {
			$renderer = strtoupper($this->request->ext);
		}

		$viewScript = $this->response->getViewScript();

		$viewer = new $viewScript($renderer, $data);

		$viewer->Execute();

		$this->RWD();
	}

}