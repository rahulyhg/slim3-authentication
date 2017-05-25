<?php

namespace App\Middleware;

use App\Core\Middleware;

class CsrfView extends Middleware {

    public function handle($request, $response, $next) {
        $html = '<input type="hidden" name="' . $this->container->csrf->getTokenNameKey() . '" value="' . $this->container->csrf->getTokenName() . '" />';
        $html .= '<input type="hidden" name="' . $this->container->csrf->getTokenValueKey() . '" value="' . $this->container->csrf->getTokenValue() . '" />';
        $this->container->view->getEnvironment()->addGlobal("csrf", ["html" => $html]);
        return $next($request, $response);
    }

}
