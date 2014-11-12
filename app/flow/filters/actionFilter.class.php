<?php
namespace flow\filters;

class actionFilter {
    use filter;
    
    public function in() {

        
        var_dump($this->request);
        
        $this->FFW();
    }
    
    public function out() {
        $this->RWD();
    }
}