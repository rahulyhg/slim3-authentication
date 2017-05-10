<?php

namespace App\Core;

use Interop\Container\ContainerInterface;

abstract class Controller {

    protected $ContainerInterface;

    public function __construct(ContainerInterface $ContainerInterface) {
        $this->ContainerInterface = $ContainerInterface;
    }

}
