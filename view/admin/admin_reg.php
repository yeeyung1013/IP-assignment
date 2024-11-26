<?php
require_once 'conn.php';
include './includes/helpers.php';
$class = "reg";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <style>
            body {
                background: #ecf0f1;
                font-family: 'Montserrat', sans-serif;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }
            ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
                background-color: #333;
                display: flex;
                justify-content: center;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
                position: absolute;
                top: 0;
                width: 100%;
            }
            li {
                margin: 0;
            }
            li a {
                display: block;
                color: white;
                text-align: center;
                padding: 14px 20px;
                text-decoration: none;
                transition: background-color 0.3s, color 0.3s;
            }
            li a:hover {
                background-color: #575757;
                color: #45b94a;
            }
            .active a {
                background-color: #45b94a;
                color: white;
            }
            .signup-page {
                width: 100%;
                max-width: 600px;
                padding: 20px 20px;
                background: #ffffff;
                border-radius: 10px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
                margin-top: 3%;

            }
            h2 {
                color: #333;
                text-align: center;
                margin-bottom: 20px;
            }
            .form-group {
                margin-bottom: 15px;
                position: relative;
            }
            .form-group label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
                color: #555;
            }
            .form-group input[type="text"],
            .form-group input[type="email"],
            .form-group input[type="password"],
            .form-group input[type="file"] {
                width: 94.5%;
                padding: 15px;
                border: 1px solid #ddd;
                border-radius: 5px;
                font-size: 14px;
                transition: border-color 0.3s, box-shadow 0.3s;
            }
            .form-group input:focus {
                border-color: #45b94a;
                box-shadow: 0 0 5px rgba(69, 185, 74, 0.5);
                outline: none;
            }
            .form-group button {
                background: #45b94a;
                color: #ffffff;
                padding: 15px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 14px;
                width: 100%;
                transition: background 0.3s, transform 0.2s;
            }
            .form-group button:hover {
                background: #61ca4c;
                transform: translateY(-1px);
            }
            .position-options {
                display: flex;
                gap: 15px;
            }
            .position-options input[type="radio"]:hover {
                outline: none; /* Remove outline on hover */
                cursor: pointer; /* Keep cursor as pointer */
            }
        </style>
    </head>
    <body>

        <ul>
            <li class="<?php echo $class == 'reg' ? 'active' : '' ?>">
                <a href="admin_reg.php">Sign Up</a>
            </li>
            <li class="<?php echo $class != 'reg' ? 'active' : '' ?>">
                <a href="adminlogin.php">Sign In</a>
            </li>
            <li>
                <a href="../">Go Back</a>
            </li>
        </ul>

        <div class="signup-page">
            <h2>Create Account</h2>
            <form class="login-form" method="post" role="form" enctype="multipart/form-data" id="signup-form" autocomplete="off">
                <div id="errorDiv"></div>

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" required minlength="10" name="name" placeholder="Enter your full name">
                </div>

                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="text" minlength="10" pattern="[0-9]{10}" required name="phone" placeholder="Enter your contact number">
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" required name="email" placeholder="Enter your email">
                </div>

                <div class="form-group">
                    <label>Select Position</label>
                    <div class="position-options">
                        <input type="radio" id="admin" name="position" value="Admin" required>
                        <label for="admin">Admin</label>
                        <input type="radio" id="staff" name="position" value="Staff" required>
                        <label for="staff">Staff</label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Select Picture</label>
                    <input type="file" name='file' required>
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <input type='text' name="address" required placeholder="Enter your address">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="Enter your password">
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="cpassword" required placeholder="Confirm your password">
                </div>

                <div class="form-group">
                    <button type="submit" id="btn-signup">CREATE ACCOUNT</button>
                </div>
            </form>
        </div>
        <?php
        $cur_page = 'signup';
        if (isset($_POST['name'], $_POST['position'])) {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $position = $_POST['position'];
            $address = $_POST['address'];
            $cpassword = $_POST['cpassword'];
            $password = $_POST['password'];

            if (!isset($name, $address, $phone, $email, $password, $cpassword) || ($password != $cpassword)) {
                echo "<script>alert('Ensure you fill the form properly.');</script>";
            } else {
                $check_email = $conn->prepare("SELECT * FROM admin WHERE email = ? OR phone = ?");
                $check_email->bind_param("ss", $email, $phone);
                $check_email->execute();
                $res = $check_email->store_result();
                $res = $check_email->num_rows();

                if ($res) {
                    echo "<script>alert('Email already exists!');</script>";
                } elseif ($cpassword != $password) {
                    echo "alert('Password does not match.')";
                } else {
                    $password = md5($password);
                    $image = uploadFile('file');
                    if ($image == -1) {
                        echo "<script>alert('We could not complete your registration, try again later!')</script>";
                        exit;
                    }

                    $stmt = $conn->prepare("INSERT INTO admin (name, email, password, phone, address, image, position) VALUES (?,?,?,?,?,?,?)");
                    $stmt->bind_param("sssssss", $name, $email, $password, $phone, $address, $image, $position);

                    if ($stmt->execute()) {
                        echo "<script>
                              alert('Congratulations! You are now registered.');
                              window.location = 'adminlogin.php';
                              </script>";
                        exit; // Stop further execution
                    } else {
                        echo "<script>alert('We could not register you!');</script>";
                    }
                }
            }
        }
        ?>

        <script src="assets/js/jquery-1.12.4-jquery.min.js"></script>

    </body>
</html>
