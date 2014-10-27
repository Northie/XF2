<?php

namespace settings;

trait database {

    private $settings = [];

    protected function readSettings() {
        $settings['default'] = [];

        $settings['default']['type'] = '';
        $settings['default']['host'] = '';
        $settings['default']['user'] = '';
        $settings['default']['pass'] = '';
        $settings['default']['name'] = '';
        
        $this->settings = $settings;
    }
    
}
