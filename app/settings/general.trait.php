<?php

namespace settings;

trait general {

    protected $settings = [];

    protected function readSettings() {
        $settings = [];
        
        $settings['XENECO'] = [];
        $settings['XENECO']['CONTEXT'] = 'DEV';
        
        $this->settings = $settings;
    }
    
}
