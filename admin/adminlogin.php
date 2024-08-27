<!DOCTYPE html>    
<html>  
<style>
@import url(https://fonts.googleapis.com/css?family=Roboto:300);

.login-page {
  width: 50%;
  padding: 5% 0 0;
  margin: auto;
}
.signup-page {
  width: 60%;
  padding: 5% 0 0;
  margin: auto;
}
.large-page {
  width: 100%;
  height: 20px;
  padding: 5% 0 0;
  margin: auto;
}
.large-page .form {
  position: relative;
  z-index: 1;
  background: #ffffff;
  max-width: 80%;
  height: 800px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.form {
  position: relative;
  z-index: 1;
  background: #ffffff;
  max-width: 70%;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.logged-user {
  margin-left: 60px;
}
.form input,
select {
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
}
.form button {
  font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  outline: 0;
  /* background: green; */
  background: #45b94a;
  width: 100%;
  border: 0;
  padding: 15px;
  color: #ffffff;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
  cursor: pointer;
}
.form button:hover,
.form button:active,
.form button:focus {
  background: #61ca4c;
}
.form .message {
  margin: 15px 0 0;
  color: #b3b3b3;
  font-size: 12px;
}
.form .message a {
  color: #3faa45;
  text-decoration: none;
}
.form .register-form {
  display: none;
}
.container {
  position: relative;
  z-index: 1;
  max-width: 300px;
  margin: 0 auto;
}
.container:before,
.container:after {
  content: "";
  display: block;
  clear: both;
}
.container .info {
  margin: 50px auto;
  text-align: center;
}
.container .info h1 {
  margin: 0 0 15px;
  padding: 0;
  font-size: 36px;
  font-weight: 300;
  color: #1a1a1a;
}
.container .info span {
  color: #4d4d4d;
  font-size: 12px;
}
.container .info span a {
  color: #000000;
  text-decoration: none;
}
.container .info span .fa {
  color: #ef3b3a;
}

.dropdown-menu > li > a:hover,
.dropdown-menu > li > a:focus {
  color: #262626;
  text-decoration: none;
  background-color: #66ccff; /*change color of links in drop down here*/
}
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}

li {
  float: left;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover {
  background-color: #111;
}
.help-block {
  color: red;
  font-size: 12px;
  margin: 0;
  padding: 0;
}
body {
  background: #ecf0f1; 
  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
</style>
<head>    
    <title>Login Form</title>    
</head> 
<?php
session_start();
require_once 'conn.php';
$file = "admin";
?>
<?php
$cur_page = 'signup';
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (!isset($email, $password)) {
?>
<script>
alert("Ensure you fill the form properly.");
</script>
<?php
    } else {
        $password = md5($password);
        $check = $conn->prepare("SELECT * FROM admin WHERE email = ? AND password = ?");
        $check->bind_param("ss", $email, $password);
        if (!$check->execute()) die("Form Filled With Error");
        $res = $check->get_result();
        $no_rows = $res->num_rows;
        if ($no_rows ==  1) {
            $row = $res->fetch_assoc();
            $id = $row['id'];
            session_regenerate_id(true);
            $_SESSION['category'] = "super";
            $_SESSION['admin'] = $id;

        ?>
<script>
alert("Access Granted!");
window.location = "home.php";
</script>
<?php

        } else { ?>
<script>
alert("Access Denied.");
</script>
<?php
        }
    }
}
?>
<body>
<ul>
  <li class="<?php echo $class == 'reg' ? 'active' : '' ?>">
   <a href="admin_reg.php">Sign Up</a>
  </li>
  <li class="<?php echo $class != 'reg' ? 'active' : '' ?>">
  <a href="adminlogin.php">Sign In</a>
  <li>
  <a href="../">Go Back</a>
  </li>
</ul>
<div class="signup-page">
    <div class="login">
    <div class="form">
        <h2>Admin Sign In</h2>
        <br/>
        <form class="login-form" method="post" role="form" id="signup-form" autocomplete="off">
        <div class="imgcontainer">
        <img src="./image/admin1.png" alt="admin" style="width:40%;">
        <br/>
    </div>
            <div id="errorDiv"></div>

            <div class="col-md-12">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="text" required name="email">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password">
                    <span class="help-block" id="error"></span>
                </div>
            </div>



            <div class="col-md-12">
                <div class="form-group">
                    <button type="submit" id="btn-signup">
                        SIGN IN
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<?php
session_start();
require_once 'conn.php';

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