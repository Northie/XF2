<?php

namespace libs\locale;

class factory extends \libs\_factory {

	use \libs\factory;

	public static function Build($options = false) {
		$locale = false;
        
        if($options && $options['locale']) {
            $locale = $options['locale'];
        }
        
        $o = new locale($locale);

		return $o;
	}

}
