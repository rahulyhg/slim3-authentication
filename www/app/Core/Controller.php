<?php

namespace App\Core;

use Interop\Container\ContainerInterface;

/**
 * 
 */
abstract class Controller {

    /** @var type */
    protected $container;

    /**
     * 
     */
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    /**
     * 
     */
    public function __get($property) {
        if ($this->container->{$property}) {
            return($this->container->{$property});
        }
    }

}
