<?php
namespace Plugins;

class NoRealm extends DefaultPlugin {
	public static function RegisterMe() {
		\Plugins\Plugins::Load()->register(__CLASS__,'onNoRealm');
	}
	
	public function Execute() {
		\settings\registry::Load()->set(['REQUEST', 'REALM'], 'web');
	}
}

