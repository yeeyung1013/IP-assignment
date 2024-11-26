<?php
session_start();

require_once '../../loginObserver/loginSystem.php';

// Check if the email session variable is set
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process the form submission
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);

    // Validation
    if (empty($username) || empty($phone) || empty($gender)) {
        echo '<script>alert("Please fill in all the fields.");</script>';
    } else {
        // Save data in the database
        require_once './database.php';
        $db = new database();
        $mysqli = $db->getConnection();
        $loginSystem = new loginSystem($mysqli);

        // Prepare the query
        $query = 'UPDATE customer SET username = ?, phone = ?, gender = ? WHERE email = ?';
        $stmt = $mysqli->prepare($query);

        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($mysqli->error));
        }

        // Bind the parameters
        $stmt->bind_param('ssss', $username, $phone, $gender, $email);
        
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $registrationTime = date('d-m-Y H:i:s');

        // Call the appendToXML method to store user information
        $loginSystem->appendToXML($email, $phone, $registrationTime, $username, $gender);

        // Execute the query
        if ($stmt->execute()) {  
            echo '<script>alert("Registration complete.");</script>';
            header('Location: ../login.php');
            exit;
        } else {
            echo '<script>alert("Error saving data.");</script>';
        }

        // Close the statement and connection
        $stmt->close();
        $mysqli->close();
        unset($_SESSION['email']); 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #6e7dff, #8f8fff);
            background-image: url('https://www.transparenttextures.com/patterns/paper.png');
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
            animation: fadeIn 0.5s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        h1 {
            margin-bottom: 20px;
            font-size: 28px;
            color: #333;
            font-weight: 600;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        label {
            font-weight: bold;
            display: flex;
            align-items: center;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"], input[type="email"], input[type="tel"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus, input[type="email"]:focus, input[type="tel"]:focus {
            border-color: #6e7dff;
            outline: none;
        }
        .radio-group {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
        }
        .radio-group label {
            font-weight: normal;
            color: #555;
        }
        button {
            background: linear-gradient(90deg, #00bcd4, #009688);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s, transform 0.2s;
            font-weight: bold;
        }
        button:hover {
            background: linear-gradient(90deg, #009688, #00bcd4);
            transform: scale(1.05);
        }
        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .icon {
            font-size: 20px;
            margin-right: 8px;
            color: #6e7dff;
        }
    </style>
    <script>
        function validateForm() {
            const username = document.getElementById('username').value;
            const phone = document.getElementById('phone').value;
            const genderMale = document.getElementById('gender-male').checked;
            const genderFemale = document.getElementById('gender-female').checked;
            const genderOther = document.getElementById('gender-other').checked;

            if (!username || !phone || (!genderMale && !genderFemale && !genderOther)) {
                alert("Please fill out all fields and select a gender.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-user-plus icon"></i>Register</h1>
        <?php if (!empty($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form action="register.php" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope icon"></i>Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="username"><i class="fas fa-user icon"></i>Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="phone"><i class="fas fa-phone icon"></i>Phone Number:</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label>Gender:</label>
                <div class="radio-group">
                    <label><input type="radio" name="gender" id="gender-male" value="Male"> Male</label>
                    <label><input type="radio" name="gender" id="gender-female" value="Female"> Female</label>
                    <label><input type="radio" name="gender" id="gender-other" value="Other"> Other</label>
                </div>
            </div>
            <button type="submit"><i class="fas fa-check"></i> Complete Registration</button>
        </form>
    </div>
</body>
</html>
