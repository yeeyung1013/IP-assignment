<?php
session_start(); // Start the session
require_once '../../loginObserver/MFAObserver.php';
require_once './database.php';

$db = new database();
$pdo = $db->getConnection();
$mfaObserver = new MFAObserver($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .otp-form {
            display: flex;
            flex-direction: column;
        }
        .otp-form label {
            margin-bottom: 8px;
            font-weight: bold;
            text-align: left;
        }
        .otp-form input[type="email"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .otp-form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .otp-form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Send OTP</h1>
    <form action="send_otp.php" method="post" class="otp-form">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit" name="send_otp">Send OTP</button>
    </form>

    <?php
    // Check if the form to send OTP is submitted
    if (isset($_POST['send_otp'])) {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        if ($email) {
            $_SESSION['email'] = $email; // Save email to session
            try {
                // Use the MFAObserver to send OTP
                $mfaObserver->sendOTP($email);
                echo "<script>alert('OTP sent to $email.');</script>";
                echo "<script>window.location.href='verify_otp.php';</script>"; // Redirect to verify OTP page
            } catch (Exception $e) {
                echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
            }
        } else {
            echo "<script>alert('Please enter a valid email.');</script>";
        }
    }
    ?>
</div>
</body>
</html>
