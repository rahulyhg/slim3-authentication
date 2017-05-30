<?php

namespace App\Core;

class Config {
    
    private $_settings = [];
    
    public function __construct(array $settings) {
        $this->_settings = $settings;
    }

    public function get($key, $default = null) {
        if(isset($this->_settings[$key])) {
            return $this->_settings[$key];
        }
    }

}
