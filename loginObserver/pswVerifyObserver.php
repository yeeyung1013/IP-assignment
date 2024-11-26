<?php

class pswVerifyObserver implements SplObserver {

    private $passwordHashObserver;
    private $db;

    public function __construct(pswHashObserver $passwordHashObserver, $db) {
        $this->passwordHashObserver = $passwordHashObserver;
        $this->db = $db;
    }

    public function verifyPsw($password, $hash) {
        // Check if the password matches the hash
        if (password_verify($password, $hash)) {
            return true;
        } else {
            return false;
        }
    }

    public function checkPswPolicy($password) {
        $minLength = 8;
        $containsNumber = preg_match('/\d/', $password);
        $containsSpecialChar = preg_match('/[^a-zA-Z\d]/', $password);

        return strlen($password) >= $minLength && $containsNumber && $containsSpecialChar;
    }


    public function update(SplSubject $subject) {
        
    }

}

?>
