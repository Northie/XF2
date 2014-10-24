<?php

namespace libs;

trait factory {

	public static $instance;
	private $registry = [];

	private function __construct() {

	}

	/**
	 *
	 * @param string $key
	 * @param array $list
	 * @return \libs\DoublyLinkedList\linkedList
	 * \libs\DoublyLinkedList\factory::Load('some-list');
	 * \libs\DoublyLinkedList\factory::Load('some-list',array(...));
	 */
	public static function Load($key, $list = false) {
		if (!isset(self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance->get($key, $list);
	}

	public function get($key, $list = false) {
		if (!$this->registry[$key]) {
			$this->registry[$key] = self::Build($list);
		}

		return $this->registry[$key];
	}

}
