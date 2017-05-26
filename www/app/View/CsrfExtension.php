<?php

namespace App\View;

use Slim\Csrf\Guard;
use \Twig_Extension;
use \Twig_SimpleFunction;

/**
 * 
 */
class CsrfExtension extends Twig_Extension {

    /** @var type */
    protected $guard;

    /**
     * 
     */
    public function __construct(Guard $guard) {
        $this->guard = $guard;
    }

    /**
     * 
     */
    public function getFunctions() {
        return [
            new Twig_SimpleFunction("csrf_token", [$this, "csrfToken"])
        ];
    }

    /**
     * 
     */
    public function csrfToken() {
        $html = "";

        $nameKey = $this->guard->getTokenNameKey();
        $name = $this->guard->getTokenName();
        $html .= '<input type="hidden" name="' . $nameKey . '" value="' . $name . '" />' . "\n";

        $valueKey = $this->guard->getTokenValueKey();
        $value = $this->guard->getTokenValue();
        $html .= '<input type="hidden" name="' . $valueKey . '" value="' . $value . '" />' . "\n";

        return $html;
    }

}
