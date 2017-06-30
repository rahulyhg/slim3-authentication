<?php

namespace App\Middleware;

use App\Core;

class CsrfView extends Core\Middleware {

    public function handle($request, $response, $next) {
        $html = '<input type="hidden" name="' . $this->container->csrf->getTokenNameKey() . '" value="' . $this->container->csrf->getTokenName() . '">';
        $html .= '<input type="hidden" name="' . $this->container->csrf->getTokenValueKey() . '" value="' . $this->container->csrf->getTokenValue() . '">';
        $this->container->view->getEnvironment()->addGlobal("csrf_token", $html);
        $response = $next($request, $response);
        return $response;
    }

}
