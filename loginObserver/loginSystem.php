<?php

// Include the observer files
require_once 'pswHashObserver.php';
require_once 'pswVerifyObserver.php';
require_once 'MFAObserver.php';

class loginSystem implements SplSubject {

    private $observers;
    private $db;
    // Declare observers as class properties
    private $passwordHashObserver;
    private $passwordVerifyObserver;
    private $mfaObserver;

    public function __construct() {
        $this->observers = new SplObjectStorage();
        $this->db = $this->connectDatabase(); // Establishing database connection
        // Initialize observers and store them as properties
        $this->passwordHashObserver = new pswHashObserver($this->db);
        $this->passwordVerifyObserver = new pswVerifyObserver($this->passwordHashObserver, $this->db);
        $this->mfaObserver = new MFAObserver($this->db);

        // Attach observers
        $this->attach($this->passwordHashObserver);
        $this->attach($this->passwordVerifyObserver);
        $this->attach($this->mfaObserver);
    }

    public function attach(SplObserver $observer) {
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer) {
        $this->observers->detach($observer);
    }

    public function notify() {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function getEmail() {
        return $this->email;
    }

    // Register method now correctly uses passwordVerifyObserver
    public function register($email, $password) {
        // Check password policy
        if (!$this->passwordVerifyObserver->checkPswPolicy($password)) {
            echo "<script>alert('Password does not meet the required policy. Must contain at least 8 characters, including a number and a special character.');</script>";
            return; // Stop execution if the policy is not met
        }

        // Hash the password with bcrypt using pswHashObserver after policy verification
        $hashedPassword = $this->passwordHashObserver->hashPassword($password);

        // Store the email and hashed password in the database
        $stmt = $this->db->prepare('INSERT INTO customer (email, pass) VALUES (:email, :pass)');
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $hashedPassword);

        if ($stmt->execute()) {
            // Fetch additional information after successful registration
            $query = 'SELECT username, gender, phone FROM customer WHERE email = ?';
            $fetchStmt = $this->db->prepare($query);
            $fetchStmt->execute([$email]);

            $result = $fetchStmt->fetch(PDO::FETCH_ASSOC);

            $username = $result['username'] ?? '';
            $gender = $result['gender'] ?? '';
            $phone = $result['phone'] ?? '';

            // Check if any required fields are empty
            if (empty($username) || empty($gender) || empty($phone)) {
                header('Location: ./source/register.php');
                exit;
            }
        } else {
            // Use JavaScript to display an error message
            echo "<script type='text/javascript'>
        alert('Error: Could not register user.');
        </script>";
        }
    }

    public function login($email, $password) {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Fetch the user data from the database
        $userData = $this->getUserFromDB($email);

        if (!$userData) {
            echo "<script>alert('Email not found.');</script>";
            return; // Stop execution if the email is not found
        }

        // Verify the password using pswVerifyObserver
        if ($this->passwordVerifyObserver->verifyPsw($password, $userData['pass'], $email)) {

            $_SESSION['customer'] = ['email' => $email];

        } else {
            echo "<script>alert('Invalid password.');</script>";
        }
    }

    private function getUserFromDB($email) {
        $stmt = $this->db->prepare('SELECT * FROM customer WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function connectDatabase() {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=villain', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    function appendToXML($email, $phone, $registrationTime, $username, $gender) {
        $xmlFile = 'customer_report.xml';

        // If XML file doesn't exist, create a new one with the root element
        if (!file_exists($xmlFile)) {
            $xmlContent = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<customers>\n</customers>";
            file_put_contents($xmlFile, $xmlContent);
        }

        // Load the existing XML file
        $xml = new DOMDocument();
        $xml->preserveWhiteSpace = false;
        $xml->formatOutput = true;
        $xml->load($xmlFile);

        // Create new customer element
        $customer = $xml->createElement("customer");

        // Create and append email element
        $emailElement = $xml->createElement("email", htmlspecialchars($email));
        $customer->appendChild($emailElement);

        // Create and append phone element
        $phoneElement = $xml->createElement("phone", htmlspecialchars($phone));
        $customer->appendChild($phoneElement);

        // Create and append username element
        $usernameElement = $xml->createElement("username", htmlspecialchars($username));
        $customer->appendChild($usernameElement);

        // Create and append gender element
        $genderElement = $xml->createElement("gender", htmlspecialchars($gender));
        $customer->appendChild($genderElement);

        // Create and append registration time element
        $timeElement = $xml->createElement("registrationTime", $registrationTime);
        $customer->appendChild($timeElement);

        // Append the new customer to the root element
        $xml->documentElement->appendChild($customer);

        // Save the updated XML file with pretty-printed formatting
        $xml->save($xmlFile);
    }

}

?>
