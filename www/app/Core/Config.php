<?php

namespace App\Core;

class Config {

    private $_data = [];

    public function __construct($path) {
        if (is_dir($path)) {
            $paths = glob($path . "/*.*");
            if (empty($paths)) {
                
            }
        }
        foreach ($paths as $path) {
            $this->_data = array_replace_recursive($this->_data, require_once $path);
        }
    }

    public function get($key, $default = null) {
        $config = $this->_data;
        $path = explode("/", $key);
        if (!$path) {
            return $default;
        }
        foreach ($path as $bit) {
            if (!isset($config[$bit])) {
                return $default;
            }
            $config = $config[$bit];
        }
        return $config;
    }

}
