<?php

namespace App\Core;

class Hash {

    public function generate($string, $salt = "") {
        return(hash("sha256", $string . $salt));
    }

    public function salt($length = 64) {
        $salt = "";
        $charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!\"#$%&'()*+,-/:;<=>?@[\]^_`{|}~";
        for ($i = 0; $i < $length; $i++) {
            $salt .= $charset[mt_rand(0, strlen($charset) - 1)];
        }
        return $salt;
    }

    public function unique() {
        return($this->generate(uniqid()));
    }

    public function passwordVerify($knownHash, $password, $salt) {
        return($knownHash === $this->generate($password, $salt));
    }

}
