<?php

namespace settings;

class general {
    use \utils\traits\singleton;
    use general;
    use settings;
     
    private function __construct() {
        $this->readSettings();
    }
     
}
