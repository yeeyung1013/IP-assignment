<?php
session_start();
ob_start();

if (isset($_SESSION['email'])) {
    unset($_SESSION['email']);
}

require_once 'conn.php'; // Include your database connection
// Your existing code here
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Sign In</title>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500&display=swap" rel="stylesheet">
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
            .active a{
                background-color: #45b94a;
                color: white;
            }
            .signup-page {
                width: 100%;
                max-width: 400px;
                padding: 5% 20px;
                background: #ffffff;
                border-radius: 10px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            }
            h2 {
                margin-top: -30px;
                color: #333;
                text-align: center;
            }
            .form {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .form input {
                width: 100%;
                padding: 15px;
                margin: 10px 0;
                border: 1px solid #ddd;
                border-radius: 5px;
                font-size: 14px;
                transition: border-color 0.3s, box-shadow 0.3s;
            }
            .form input:focus {
                border-color: #45b94a;
                box-shadow: 0 0 5px rgba(69, 185, 74, 0.5);
                outline: none;
            }
            .form button {
                background: #45b94a;
                color: #ffffff;
                margin-top: 30px;
                padding: 15px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 14px;
                width: 100%;
                transition: background 0.3s, transform 0.2s;
            }
            .form button:hover {
                background: #61ca4c;
                transform: translateY(-1px);
            }
            .help-block {
                color: red;
                font-size: 12px;
                margin: 0;
                padding: 0;
            }
            .imgcontainer {
                margin-bottom: 20px;
                text-align: center;
            }
            .imgcontainer img {
                width: 40%;
            }

            .form input {
                width: 90%; /* Change this value to your desired width */
                max-width: 400px; /* Optional: Set a maximum width */
                padding: 15px;
                margin: 10px 0;
                border: 1px solid #ddd;
                border-radius: 5px;
                font-size: 14px;
                transition: border-color 0.3s, box-shadow 0.3s;
            }
        </style>
    </head>
    <body>
        <ul>
            <li class="<?php echo $cur_page == 'reg' ? 'active' : ''; ?>"><a href="admin_reg.php">Sign Up</a></li>
            <li class="<?php echo $cur_page != 'reg' ? 'active' : ''; ?>"><a href="adminlogin.php">Sign In</a></li>
            <li><a href="../">Go Back</a></li>
        </ul>


        <div class="signup-page">
            <div class="form">
                <h2>Admin Sign In</h2>
                <div class="imgcontainer">
                    <img src="./image/admin1.png" alt="admin">
                </div>
                <form class="login-form" method="post" role="form" id="signup-form" autocomplete="off">
                    <div id="errorDiv"></div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="text" required name="email" placeholder="Enter your email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter your password">
                        <span class="help-block" id="error"></span>
                    </div>

                    <div class="form-group">
                        <button type="submit" id="btn-signup">SIGN IN</button>
                    </div>
                </form>
            </div>
        </div>

        <?php
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (!empty($email) && !empty($password)) {
                $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ? AND password = ?");
                $hashedPassword = md5($password);
                $stmt->bind_param("ss", $email, $hashedPassword);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 1) {
                    $row = $result->fetch_assoc();
                    $_SESSION['admin_id'] = $row['admin_id'];
                    $_SESSION['position'] = $row['position'];
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['email'] = $row['email'];

                    session_regenerate_id(true);
                    header("Location: home.php");
                    exit();
                } else {
                    echo "<script>alert('Invalid email or password.');</script>";
                }
                $stmt->close();
            } else {
                echo "<script>alert('Please fill in both fields.');</script>";
            }
        }
        $conn->close();
        ?>
        <script src="assets/js/jquery-1.12.4-jquery.min.js"></script>

    </body>
</html>