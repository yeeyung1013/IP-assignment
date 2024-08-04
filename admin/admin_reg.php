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
.alert {
	padding:15px;
	margin-bottom:20px;
	border:1px solid transparent;
	border-radius:4px
}
.alert h4 {
	margin-top:0;
	color:inherit
}
.alert .alert-link {
	font-weight:700
}
.alert>p, .alert>ul {
	margin-bottom:0
}
.alert>p+p {
	margin-top:5px
}
.alert-dismissable, .alert-dismissible {
	padding-right:35px
}
.alert-dismissable .close, .alert-dismissible .close {
	position:relative;
	top:-2px;
	right:-21px;
	color:inherit
}
.alert-success {
	color:#3c763d;
	background-color:#dff0d8;
	border-color:#d6e9c6
}
.alert-success hr {
	border-top-color:#c9e2b3
}
.alert-success .alert-link {
	color:#2b542c
}
.alert-info {
	color:#31708f;
	background-color:#d9edf7;
	border-color:#bce8f1
}
.alert-info hr {
	border-top-color:#a6e1ec
}
.alert-info .alert-link {
	color:#245269
}
.alert-warning {
	color:#8a6d3b;
	background-color:#fcf8e3;
	border-color:#faebcc
}
.alert-warning hr {
	border-top-color:#f7e1b5
}
.alert-warning .alert-link {
	color:#66512c
}
.alert-danger {
	color:#a94442;
	background-color:#f2dede;
	border-color:#ebccd1
}
.alert-danger hr {
	border-top-color:#e4b9c0
}
.alert-danger .alert-link {
	color:#843534
}
.form-group {
    margin-bottom: 15px;
}
.col-md-12,.col-md-6{
float:left
}
.col-md-12 {
width:100%
}
.col-md-6 {
width:50%
}
.col-md-pull-12 {
right:100%
}
.col-md-pull-6 {
right:50%
}
.col-md-push-12 {
left:100%
}
.col-md-push-6 {
left:50%
}
.col-md-offset-12 {
margin-left:100%
}
.col-md-offset-6 {
margin-left:50%
}
body {
  background: #ecf0f1; 
  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
</style>
<?php
require_once 'conn.php';
include './includes/helpers.php';
$class = "reg";
?>
<?php
$cur_page = 'signup';
if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $file = 'file';
    $address = $_POST['address'];
    $cpassword = $_POST['cpassword'];
    $password = $_POST['password'];
    if (!isset($name, $address, $phone, $email, $password, $cpassword) || ($password != $cpassword)) { ?>
<script>
alert("Ensure you fill the form properly.");
</script>
<?php
    } else {
        $check_email = $conn->prepare("SELECT * FROM admin WHERE email = ? OR phone = ?");
        $check_email->bind_param("ss", $email, $phone);
        $check_email->execute();
        $res = $check_email->store_result();
        $res = $check_email->num_rows();
        if ($res) {
        ?>
<script>
alert("Email already exists!");
</script>
<?php

        } elseif ($cpassword != $password) { ?>
<script>
alert("Password does not match.");
</script>
<?php
        } else {
            $password = md5($password);
            $can = 1;
            $image = uploadFile('file');
            if ($image == -1) {
                echo "<script>alert('We could not complete your registration, try again later!')</script>";
                exit;
            }
            $stmt = $conn->prepare("INSERT INTO admin (name, email, password, phone, address, image) VALUES (?,?,?,?,?,?)");
            $stmt->bind_param("ssssss", $name, $email, $password, $phone, $address, $image);
            if ($stmt->execute()) {
            ?>
<script>
alert("Congratulations.\nYou are now registered.");
window.location = 'adminlogin.php';
</script>
<?php
            } else {
            ?>
<script>
alert("We could not register you!.");
</script>
<?php
            }
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
    <div class="form">
        <h2>Create Account </h2>
        <br>
        <p class="alert alert-info">
            <marquee behavior="" scrollamount="2" direction="">You need to create an account to login the admin page!!!
            </marquee>
        </p>
        <form class="login-form" method="post" role="form" enctype="multipart/form-data" id="signup-form"
            autocomplete="off">
            <div id="errorDiv"></div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" required minlength="10" name="name">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group" style="padding:5%">
                    <label>Contact Number</label>
                    <input type="text" minlength="11" pattern="[0-9]{11}" required name="phone">
                </div>
            </div>
            <div>
            </div>
            <div class="col-md-6">
                <div class="form-group" style="padding:5%">
                    <label>Email Address</label>
                    <input type="email" required name="email">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group" style="padding:5%">
                    <label>Select Picture</label>
                    <input type="file" name='file' required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group" style="padding:5%">
                    <label>Address</label>
                    <input type='text' name="address" class="form-group" required>
                    </select>
                    <span class="help-block" id="error"></span>
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
                    <label>Confirm Password</label>
                    <input type="password" name="cpassword" id="cpassword">
                    <span class="help-block" id="error"></span>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <button type="submit" id="btn-signup">
                        CREATE ACCOUNT
                    </button>
                </div>
            </div>
            <p class="message">
                <a href="#">.</a><br>
            </p>
        </form>
    </div>
</div>
</div>
<script src="assets/js/jquery-1.12.4-jquery.min.js"></script>

</body>
</html>
