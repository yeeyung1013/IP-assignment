<?php
session_start(); // Start the session
require_once '../../loginObserver/loginSystem.php';
require_once '../../loginObserver/MFAObserver.php';
require_once './database.php';

$db = new database();
$pdo = $db->getConnection();
$loginSystem = new loginSystem($pdo);
$mfaObserver = new MFAObserver($pdo);

// Check if the email is set in the session
if (!isset($_SESSION['email'])) {
    echo "<script>alert('No email found in session. Please go back.'); window.location.href='send_otp.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
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
        .otp-form input[type="text"] {
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
        <h1>Verify OTP</h1>
        <form action="verify_otp.php" method="post" class="otp-form">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" readonly required>

            <label for="otp">OTP:</label>
            <input type="text" id="otp" name="otp" maxlength="6" required>

            <button type="submit" name="verify_otp">Verify OTP</button>
        </form>

        <?php
        if (isset($_POST['verify_otp'])) {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL); // Retrieve email from the form
            $otp = filter_input(INPUT_POST, 'otp', FILTER_SANITIZE_STRING);

            if ($email && $otp) {
                try {
                    // Attempt to verify the OTP
                    $verificationResult = $mfaObserver->verifyOTP($email, $otp);

                    if (is_object($verificationResult) && isset($verificationResult->success)) {
                        if ($verificationResult->success) {
                            // Redirect to reset_password.php if OTP verification is successful
                            echo "<script>alert('OTP verified successfully.'); window.location.href='reset_password.php';</script>";
                        } else {
                            // Handle unsuccessful verification
                            echo "<script>alert('Error: " . htmlspecialchars($verificationResult->message) . "');</script>";
                        }
                    } else {
                        echo "<script>alert('Unexpected response format.');</script>";
                    }
                } catch (Exception $e) {
                    // Handle exceptions
                    echo "<script>alert('Error: " . htmlspecialchars($e->getMessage()) . "');</script>";
                }
            } else {
                echo "<script>alert('Please fill in both fields.');</script>";
            }
        }
        ?>
    </div>
</body>
</html>