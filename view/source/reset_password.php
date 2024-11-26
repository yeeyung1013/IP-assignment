<?php
session_start(); // Start the session
require_once './database.php';
require_once '../../loginObserver/pswHashObserver.php'; // Include the password hash observer
require_once '../../loginObserver/pswVerifyObserver.php'; // Include the password verify observer

$db = new database();
$mysqli = $db->getConnection();

// Create observers
$passwordHashObserver = new pswHashObserver($mysqli);
$passwordVerifyObserver = new pswVerifyObserver($passwordHashObserver, $mysqli);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reset Password</title>
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
            .reset-form {
                display: flex;
                flex-direction: column;
            }
            .reset-form label {
                margin-bottom: 8px;
                font-weight: bold;
                text-align: left;
            }
            .reset-form input[type="password"] {
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }
            .reset-form button {
                background-color: #4CAF50;
                color: white;
                padding: 10px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }
            .reset-form button:hover {
                background-color: #45a049;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Reset Password</h1>
            <form action="reset_password.php" method="post" class="reset-form">
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>

                <button type="submit">Update Password</button>
            </form>
        </div>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $newPassword = filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING);
            $email = $_SESSION['email']; // Assuming email is stored in session

            if ($newPassword) {
                // Check password policy
                if (!$passwordVerifyObserver->checkPswPolicy($newPassword)) {
                    echo "<script>alert('Password must be at least 8 characters long, contain at least one number, and one special character.');</script>";
                } else {
                    try {
                        // Hash the new password
                        $hashedPassword = $passwordHashObserver->hashPassword($newPassword);

                        // Prepare the SQL statement using named placeholders
                        $stmt = $mysqli->prepare('UPDATE customer SET pass = ? WHERE email = ?');

                        // Check if the statement was prepared successfully
                        if (!$stmt) {
                            throw new Exception("Failed to prepare SQL statement: " . $mysqli->error);
                        }

                        // Bind the parameters
                        $stmt->bind_param('ss', $hashedPassword, $email);

                        // Execute the statement
                        if ($stmt->execute()) {
                            echo "<script>alert('Password updated successfully.'); window.location.href='../login.php';</script>";
                        } else {
                            throw new Exception("Failed to execute SQL statement: " . $stmt->error);
                        }

                        // Close the statement
                        $stmt->close();
                    } catch (Exception $e) {
                        echo "<script>alert('Error: " . htmlspecialchars($e->getMessage()) . "');</script>";
                    }
                }
            } else {
                echo "<script>alert('Please enter a new password.');</script>";
            }
        }
        ?>

    </body>
</html>
