<?php
include("./source/header.php");

// Check if user is logged in (email should be set in session)
if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('Location: .login.php'); // Redirect to login if not logged in
    exit();
}

// Fetch user data from the database
try {
    $pdo = new PDO('mysql:host=localhost;dbname=villain', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch user data based on email from the session
    $stmt = $pdo->prepare('SELECT email, username, phone, gender FROM customer WHERE email = :email');
    $stmt->execute([':email' => $_SESSION['email']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "User not found!";
        exit();
    }
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = $_POST['username'];
    $newPhone = $_POST['phone'];
    $newPassword = $_POST['password'];

    // Hash the new password
    if (!empty($newPassword)) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    } else {
        $hashedPassword = null; // If password is empty, do not update it
    }

    try {
        // Update the user information in the database
        if ($hashedPassword) {
            $updateStmt = $pdo->prepare('UPDATE customer SET username = :username, phone = :phone, pass = :pass WHERE email = :email');
            $updateStmt->execute([
                ':username' => $newUsername,
                ':phone' => $newPhone,
                ':pass' => $hashedPassword,
                ':email' => $user['email']
            ]);
        } else {
            // Update without changing the password
            $updateStmt = $pdo->prepare('UPDATE customer SET username = :username, phone = :phone WHERE email = :email');
            $updateStmt->execute([
                ':username' => $newUsername,
                ':phone' => $newPhone,
                ':email' => $user['email']
            ]);
        }

        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        echo "Error updating profile: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
             background: linear-gradient(135deg, #000000, #434343);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile-container {
            background: #ffffff;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-top: 150px;
            margin-bottom: 30px;
            padding: 50px;
            width: 600px;
            max-width: 100%;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .profile-container:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 40px;
            font-weight: 600;
            letter-spacing: 1px;
            position: relative;
        }

        h1::after {
            content: '';
            width: 60px;
            height: 4px;
            background-color: #00bcd4;
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .profile-info {
            margin-bottom: 40px;
        }

        .profile-info label {
            display: block;
            font-weight: 600;
            margin: 10px 0;
            text-align: left;
        }

        .profile-info input[type="text"], .profile-info input[type="password"] {
            width: 100%;
            padding: 15px;
            font-size: 16px;
            border: 2px solid #e0f7fa;
            border-radius: 10px;
            box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .profile-info input[type="text"]:focus, .profile-info input[type="password"]:focus {
            border-color: #00bcd4;
            box-shadow: 0 0 10px rgba(0, 188, 212, 0.3);
            outline: none;
        }

        .edit-btn {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(135deg, #00bcd4, #26c6da);
            color: #fff;
            font-weight: 600;
            text-decoration: none;
            border-radius: 30px;
            cursor: pointer;
            transition: box-shadow 0.3s ease;
            border: none;
            margin-top: 20px;
        }

        .edit-btn:hover {
            box-shadow: 0 8px 20px rgba(0, 188, 212, 0.5);
        }

        .profile-info span {
            font-weight: 600;
            color: #00bcd4;
        }

        .error-message {
            color: #ff5252;
            font-size: 16px;
            margin-bottom: 20px;
        }

        @media (max-width: 600px) {
            .profile-container {
                padding: 30px;
            }

            .profile-info label, .profile-info input {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

<div class="profile-container">
    <h1>Edit Your Profile</h1>

    <form method="post">
        <div class="profile-info">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" readonly>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>

            <label for="gender">Gender</label>
            <input type="text" id="gender" value="<?= htmlspecialchars($user['gender']) ?>" readonly>

            <label for="password">New Password (Optional):</label>
            <input type="password" id="password" name="password" placeholder="Leave blank to keep current password">
        </div>

        <button type="submit" class="edit-btn">Save Changes</button>
    </form>
</div>

</body>
</html>
