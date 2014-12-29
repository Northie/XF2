<?php
namespace libs\factory;

abstract class processStepUI extends \libs\factory\processStep implements iProcessStepUI {
	
	protected $form = false;


	public final function start() {
		
		if(!$this->form) {
			throw new BuildException('User Interface/Input Step form not set');
		}

		if($this->form->isValid()) {
			$this->Build();
		} else {
			$this->getUI();
		}
	}
	
	public function setForm($form) {
		$this->form = $form;

	}
	
	public function getForm() {
		return $this->form;

	}

}