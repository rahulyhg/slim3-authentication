<?php

namespace App\Middleware;

use App\Core;

/**
 * 
 */
class RestrictNonAdmin extends Core\Middleware {

    /**
     * 
     */
    public function handle($request, $response, $next) {
        if (!$this->auth()->check()) {
            $this->flash("danger", $this->text(""));
            return($this->redirect($response, "auth.login"));
        }
        if ($this->user()->isAdmin() or $this->user()->isSuperAdmin()) {
            $response = $next($request, $response);
            return $response;
        }
        $this->flash("danger", $this->text(""));
        return($this->redirect($response, "index"));
    }

}
