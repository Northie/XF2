<?php

namespace settings;

class database {
    use \utils\traits\singleton;
    use database;
    use settings;
    
    private function __construct() {
        $this->readSettings();
    }
 
}
