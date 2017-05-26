<?php

namespace App\Utility;

use Respect\Validation\Exceptions\NestedValidationException;

/**
 * 
 */
class Validator {

    /** @var type */
    private $_errors = [];

    /**
     * 
     */
    public function validate($request, array $rules) {
        foreach ($rules as $field => $rule) {
            try {
                $name = str_replace(["-", "_"], " ", ucfirst(strtolower($field)));
                $rule->setName($name)->assert($request->getParam($field));
            } catch (NestedValidationException $ex) {
                $this->_errors[$field] = $ex->getMessages();
            }
        }
        Session::put("errors", $this->_errors);
        return $this;
    }

    /**
     * 
     */
    public function errors() {
        return($this->_errors);
    }

    /**
     * 
     */
    public function passed() {
        return(empty($this->_errors));
    }

}
