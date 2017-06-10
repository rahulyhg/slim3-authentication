<?php

namespace App\Utility;

class Hash {

    public static function generate($string, $salt = "") {
        return(hash("sha256", $string . $salt));
    }

    public static function generateSalt($length) {
        $salt = "";
        $charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!\"#$%&'()*+,-/:;<=>?@[\]^_`{|}~";
        for ($i = 0; $i < $length; $i++) {
            $salt .= $charset[mt_rand(0, strlen($charset) - 1)];
        }
        return $salt;
    }

    public static function generateUnique() {
        return(self::generate(uniqid()));
    }

}
