<?php

namespace App\Validation;

use App\Utility\Session;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator {

    protected $errors;

    public function validate($request, array $rules) {
        foreach ($rules as $field => $rule) {
            try {
                $rule->setName(ucfirst($field))->assert($request->getParam($field));
            } catch (NestedValidationException $ex) {
                $this->errors[$field] = $ex->getMessages();
            }
        }
        Session::put("errors", $this->errors);
        return $this;
    }

    public function passed() {
        return(empty($this->errors));
    }

}
