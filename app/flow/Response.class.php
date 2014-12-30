<?php

namespace flow;

class Response {
    
    use \Plugins\helper;

	public function __construct() {
        
        if(!$this->before('ResponseConstruct', $this)) {
            return false;
        }
        
        \Plugins\Plugins::Load()->DoPlugins('onAfterResponseConstruct',$this);
	}

	public function setData($data) {
        if(!\Plugins\Plugins::Load()->DoPlugins('onBeforeResponseSetData',$this)) {
            return false;
        }
		$this->data = $data;
        
        \Plugins\Plugins::Load()->DoPlugins('onAfterResponseSetData',$this);
	}

	public function getData() {
        if(!\Plugins\Plugins::Load()->DoPlugins('onBeforeResponseGetData',$this)) {
            return false;
        }
		return $this->data;
	}

	public function getResponseFormat() {
        if(!\Plugins\Plugins::Load()->DoPlugins('onBeforeResponseGetResponseFormat',$this)) {
            return false;
        }
		return $this->format;
	}

	public function setResponseFormat($format) {
        if(!\Plugins\Plugins::Load()->DoPlugins('onBeforeResponseSetResponseFormat',$this)) {
            return false;
        }
        
		$this->format = $format;
        
        \Plugins\Plugins::Load()->DoPlugins('onAfterResponseSetResponseFormat',$this);
	}

}