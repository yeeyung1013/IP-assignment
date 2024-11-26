<?php

 class pswHashObserver implements SplObserver {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Hash a password using bcrypt
    public function hashPassword($password) {
        $options = [
            'cost' => 12 // Increase the cost for stronger hashing (default is 10)
        ];

        // Hash the password using bcrypt and the defined options
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);

        // Check if password hashing succeeded
        if ($hashedPassword === false) {
            throw new Exception("Password hashing failed.");
        }

        return $hashedPassword;
    }

    public function update(\SplSubject $subject): void {
        
    }

}
?>
