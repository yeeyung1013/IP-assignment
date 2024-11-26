<?php
session_start();

// Check if the user is logged in (email should be set in session)
if (!isset($_SESSION['email'])) {
    header('Location: adminlogin.php'); // Redirect to login if not logged in
    exit();
}

// Connect to the database
$mysqli = new mysqli("localhost", "root", "", "villain");

// Check for connection errors
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Prepare a query to fetch admin data based on the email stored in the session
$stmt = $mysqli->prepare("SELECT name, email, phone, position, address, image FROM admin WHERE email = ?");
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $adminUser = $result->fetch_assoc();
    $name = $adminUser['name'];
    $email = $adminUser['email'];
    $phone = $adminUser['phone'];
    $position = $adminUser['position'];
    $address = $adminUser['address'];
    $image_path = $adminUser['image'];
}

// Close the database connections
$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff; /* White background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .profile-container {
            background: #ffffff; /* White background for the profile container */
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
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
            margin-bottom: 20px;
            font-weight: 600;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 5px solid #4caf50; /* Green border */
            box-shadow: 0 0 10px rgba(76, 175, 80, 0.5);
        }

        .profile-info {
            margin-bottom: 30px;
        }

        .profile-info label {
            font-weight: 600;
            color: #4caf50; /* Green color for labels */
            display: block;
            margin: 10px 0;
            text-align: left;
        }

        .profile-info input[type="text"], .profile-info input[type="email"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 2px solid #e0f7fa;
            border-radius: 10px;
            box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }

        .profile-info input[type="text"]:focus, .profile-info input[type="email"]:focus {
            border-color: #4caf50; /* Green color for focus */
            box-shadow: 0 0 10px rgba(76, 175, 80, 0.3);
            outline: none;
        }

        .profile-info span {
            font-weight: 600;
            font-size: 18px;
            color: #555;
        }

        .edit-btn {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(135deg, #4caf50, #66bb6a); /* Green gradient */
            color: #fff;
            font-weight: 600;
            text-decoration: none;
            border-radius: 30px;
            cursor: pointer;
            transition: box-shadow 0.3s ease;
            border: none;
        }

        .edit-btn:hover {
            box-shadow: 0 8px 20px rgba(76, 175, 80, 0.5);
        }
        
        .go-back-btn {
            background: transparent;
            border: none;
            color: #4caf50; /* Green color */
            font-size: 18px;
            cursor: pointer;
            margin-bottom: 20px;
            text-align: left;
            position: absolute;
            top: 20px;
            left: 20px;
        }

        @media (max-width: 600px) {
            .profile-container {
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    
    <button class="go-back-btn" onclick="window.location.href='home.php';">Go Back</button>

<div class="profile-container">
    <h1>Admin Profile</h1>
    <!-- Display the profile image -->
    <img src="upload/<?php echo htmlspecialchars($image_path) ?>" alt="Profile Image" class="profile-image">

    <div class="profile-info">
        <label for="name">Name:</label>
        <input type="text" id="name" value="<?= htmlspecialchars($adminUser['name']) ?>" readonly>

        <label for="email">Email:</label>
        <input type="email" id="email" value="<?= htmlspecialchars($adminUser['email']) ?>" readonly>

        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" value="<?= htmlspecialchars($adminUser['phone']) ?>" readonly>

        <label for="position">Position:</label>
        <input type="text" id="position" value="<?= htmlspecialchars($adminUser['position']) ?>" readonly>
        
        <label for="address">Address:</label>
        <input type="text" id="address" value="<?= htmlspecialchars($adminUser['address']) ?>" readonly>
    </div>

    <a href="edit_profile.php" class="edit-btn">Edit Profile</a>
</div>

</body>
</html>
