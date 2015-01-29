<?php

namespace Plugins;

trait helper {

	public function notify($event, $object, $options = array()) {
		$event = "on" . $event;
		return \Plugins\Plugins::Load()->doPlugins($event, $object, $options);
	}

	public function before($event, $object, $options = array()) {
		$event = "Before" . $event;
		return $this->notify($event, $object, $options);
	}

	public function after($event, $object, $options = array()) {
		$event = "After" . $event;
		return $this->notify($event, $object, $options);
	}

}