<?php
// callback.php
require_once __DIR__ . '../../../vendor/autoload.php';
session_start();

$client = new Google_Client();
$client->setClientId('626947002977-a39grn2osuhqtvpt9lsnt8tf4s1jdl6g.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/villain/view/source/callback.php');

if (isset($_GET['code'])) {
    try {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token);

        // Get user info
        $oauth2 = new Google_Service_Oauth2($client);
        $userInfo = $oauth2->userinfo->get();

        $email = $userInfo->email;
        $name = $userInfo->name;

        // Connect to the database
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=villain', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }

        // Check if user already exists
        $stmt = $pdo->prepare('SELECT * FROM customer WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Check if phone, username, or gender is missing
            if (empty($user['phone']) || empty($user['username']) || empty($user['gender'])) {
                // Redirect to register.php to complete missing details
                $_SESSION['email'] = $email; // Pass email to register.php
                $_SESSION['name'] = $name; // Optionally pass the name to prefill in registration
                header("Location: ./register.php");
                exit();
            } else {
                // User exists and has complete information, log them in
                $_SESSION['email'] = $user['email'];
                header("Location: ../index.php");
                exit();
            }
        } else {
            // User doesn't exist, register them with just the email
            $phone = ""; // Default value for phone if not provided by Google
            $pass = "";  // Password can be empty for OAuth users

            $stmt = $pdo->prepare('INSERT INTO customer (email) VALUES (:email)');
            if ($stmt->execute(['email' => $email])) {
                // After registration, redirect to register.php to complete details
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $name; // Pass the name to register.php if needed
                header("Location: ./register.php");
                exit();
            } else {
                echo "Error: Could not register user.";
            }
        }
    } catch (Exception $e) {
        // Handle errors from Google API
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No authorization code found in the URL.";
}
?>
