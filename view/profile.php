<?php
include("./source/header.php");

// Check if user is logged in (email should be set in session)
if (!isset($_SESSION['email'])) {
    header('Location: ./login.php'); // Redirect to login if not logged in
    exit();
}

// Fetch user data from the database (replace with actual database query)
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
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Profile</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Poppins', sans-serif;
                background: linear-gradient(135deg, #000000, #434343); 
                display: flex;
                justify-content: center;
                align-items: flex-start; 
                padding-top: 170px; 
                height: 100vh;
                margin: 0;
            }

            .profile-container {
                background: #ffffff;
                border-radius: 25px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                padding: 50px;
                width: 600px; /* Wider container */
                max-width: 100%;
                text-align: center;
                transition: transform 0.3s ease;
            }

            .profile-container:hover {
                transform: translateY(-10px);
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            }

            .profile-container h1 {
                font-size: 32px;
                color: #333;
                margin-bottom: 40px;
                font-weight: 600;
                letter-spacing: 1px;
                position: relative;
            }

            .profile-container h1::after {
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
                text-align: left;
            }

            .profile-info p {
                margin: 15px 0;
                font-size: 18px;
                color: #555;
                font-weight: 500;
            }

            .profile-info span {
                font-weight: 600;
                color: #00bcd4;
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
            }

            .edit-btn:hover {
                box-shadow: 0 8px 20px rgba(0, 188, 212, 0.5);
            }

            .success-message {
                color: #28a745;
                font-size: 16px;
                margin-bottom: 20px;
            }

            @media (max-width: 600px) {
                .profile-container {
                    padding: 30px;
                }

                .profile-info p {
                    font-size: 16px;
                }
            }

            /* Avatar Styling */
            .avatar {
                width: 120px;
                height: 120px;
                border-radius: 50%;
                background: linear-gradient(135deg, #00bcd4, #26c6da);
                color: #fff;
                margin-bottom: 30px;
                display: inline-block;
                font-size: 42px;
                line-height: 120px;
                text-align: center;
                font-weight: 600;
                letter-spacing: 2px;
                box-shadow: 0 8px 20px rgba(0, 188, 212, 0.5);
                transition: box-shadow 0.3s ease, transform 0.3s ease;
            }

            .avatar:hover {
                box-shadow: 0 12px 30px rgba(0, 188, 212, 0.7);
                transform: scale(1.05);
            }

            /* Form styling */
            input[type="text"] {
                width: 100%; /* Full width input */
                padding: 15px;
                margin-bottom: 20px;
                font-size: 16px;
                border: 2px solid #e0f7fa;
                border-radius: 10px;
                box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.1);
                transition: border-color 0.3s ease, box-shadow 0.3s ease;
            }

            input[type="text"]:focus {
                border-color: #00bcd4;
                box-shadow: 0 0 10px rgba(0, 188, 212, 0.3);
                outline: none;
            }

        </style>
    </head>
    <body>

        <div class="profile-container">
            <!-- Avatar with the first letter of username -->
            <div class="avatar"><?= strtoupper($user['username'][0]) ?></div>

            <h1>Your Profile</h1>

            <div class="profile-info">
                <p><span>Email Address:</span> <?= htmlspecialchars($user['email']) ?></p>
                <p><span>Username:</span> <?= htmlspecialchars($user['username']) ?></p>
                <p><span>Phone Number:</span> <?= htmlspecialchars($user['phone']) ?></p>
                <p><span>Gender:</span> <?= htmlspecialchars($user['gender']) ?></p>
            </div>

            <a href="./edit_profile.php" class="edit-btn">Edit Profile</a>
        </div>

        <script>
            // Optional: Handle any success messages for profile update
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success')) {
                let successMessage = document.createElement('p');
                successMessage.className = 'success-message';
                successMessage.innerText = 'Profile updated successfully!';
                document.querySelector('.profile-container').prepend(successMessage);
            }
        </script>

    </body>
</html>
