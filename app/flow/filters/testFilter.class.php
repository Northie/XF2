<?php
namespace flow\filters;

class testFilter {
    use filter;
    
    public function in() {
        $_SESSION['filters'][] = __METHOD__;
        $this->FFW();        
    }
    
    public function out() {

        $this->RWD();
    }
}