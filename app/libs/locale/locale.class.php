<?php

namespace libs\locale;

class locale {
    public function __construct($locale=FALSE) {
        if(!$locale) {
            //get default
        }
        
        //load translations
    }
    
    /**
     * 
     * @param type $value
     * $l = new Locale;
     * $l->format($ts)->with('DATE');
     */
    
    public function format ($value) {
        $this->formatValue = $value;
    }
    
    public function with($type) {
        $this->formatType = $type;
    }
    
    public function symbol($symbol) {
        return $this->symbols[$symbol];
    }
    
    public function token($token) {
        return $this->tokens[$token];
    }
    
}

