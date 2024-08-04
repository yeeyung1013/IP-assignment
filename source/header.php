<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VILLAIN - TARUC Gaming Society</title>

  <!-- 
    - favicon link
  -->
  <link rel="shortcut icon" href="/villain/assets/images/logo.png" type="image/png">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" type="text/css" href="/villain/assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="/villain/assets/css/login-signup.css">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&family=Poppins:wght@400;500;700&display=swap"
    rel="stylesheet">
  
  <!-- 
    - JQuery
  -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  
  <!--
    - SweetAlert
  -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body id="top" onload="displayCartBadge()">
  <!-- 
    - #HEADER
  -->

  <header class="header">
    <!-- 
      - overlay
    -->
    <div class="overlay" data-overlay></div>

    <div class="container">

      <a href="/villain/index.php" class="logo">
        <img src="/villain/assets/images/logo.png" style="width: 115px; height: 115px;" alt="VILLAIN logo">
      </a>

      <nav class="navbar" data-nav>

        <ul class="navbar-list">

          <li>
            <a href="#hero" class="navbar-link">Home</a>
          </li>

          <li>
            <a href="#about" class="navbar-link">About</a>
          </li>
          <li>
            <a href="#speaker" class="navbar-link">Speakers</a>
          </li>

          <li>
            <a href="#tickets" class="navbar-link">Tickets</a>
          </li>

          <li>
            <a href="/villain/events.php" class="navbar-link">Other Events</a>
          </li>
          <?php
          if(isset($_SESSION["email"]) && isset($_SESSION["pass"])){
              echo <<< EOT
                  <li>
                    <a href="/villain/bevent.php" class="navbar-link">Booked Events</a>
                  </li>
              EOT;
          }
          ?>
          <li>
              <a href="/villain/cart.php" class="navbar-link" id="cartBadge">Cart</a>
          </li>
          
          <li>
            <a href="/villain/admin/adminlogin.php" class="navbar-link">Admin</a>
          </li>
        </ul>

      </nav>
      <div class="header-actions">
      <?php
      if(isset($_SESSION["email"]) && isset($_SESSION["pass"])){
        echo <<< EOT
            <button class='btn-sign_out' onclick='document.location="/villain/source/logout.php"'>
              <span>Log out</span>
            </button>
        EOT;
      }else{
        echo <<< EOT
            <button class='btn-sign_in' onclick="document.getElementById('login-id').style.display='block'">
              <div class='icon-box'>
                <ion-icon name='log-in-outline'></ion-icon>
              </div>
              <span>Log-in / Sign-up</span>
            </button>
        EOT;
      }
      ?>
      </div>
    </div>

  </header>
  
  <!-- Login/Sign in -->
    <div id="login-id" class="login" style=''>
      <span onclick="document.getElementById('login-id').style.display='none'"
    class="login-close" title="Close Modal">&times;</span>
      <!-- Login Content -->
      <form class="login-content login-animate" method="POST" action="/villain/source/actions.php">
      
        <div class="login-container">
            <h3 style="font-size: 30px; padding-bottom: 10px; font-weight: normal">Sign in</h3>
          <label for="uname"><b>Email</b></label>
          <input class="login-input" type="email" placeholder="Enter Email" name="umail" required>

          <label for="psw"><b>Password</b></label>
          <input class="login-input" type="password" placeholder="Enter Password" name="psw" required>

          <button type="submit" class="login-btn" name="login-btn">Login</button>
          <label>
            <input type="checkbox" checked="checked" name="remember" style="all:revert;">Remember me
          </label>
        </div>

        <div class="login-container" style="background-color:#f1f1f1">
          <button type="button" onclick="document.getElementById('login-id').style.display='none'" class="login-cancelbtn">Cancel</button>
          <span class="login-psw"><a class="login-reset-a" href="#" onclick="signup()">Sign up</a> / <a class="login-reset-a" href="#" onclick="passReset()">Forgot password?</a></span>
        </div>
      </form>
    </div>
  
  <!-- Sign up -->
  <div id="signup-id" class="signup" style=''>
      <span onclick="document.getElementById('signup-id').style.display='none'" class="signup-close" title="Close Modal">&times;</span>
      <form class="signup-content" method="POST" action="/villain/source/actions.php">
        <div class="signup-container">
          <h3 style="font-size: 30px; padding-bottom: 10px; font-weight: normal">Sign Up</h1>
          <p>Please fill in this form to create an account.</p>
          <hr class="signup-hr">
          <label for="email"><b>Email</b></label>
          <input type="email" placeholder="Enter Email" name="email" class="signup-input" required>

          <label for="psw"><b>Password</b></label>
          <input type="password" placeholder="Enter Password" name="psw" class="signup-input" required>

          <label for="psw-repeat"><b>Repeat Password</b></label>
          <input type="password" placeholder="Repeat Password" name="psw-repeat" class="signup-input" required>

          <label>
            <input type="checkbox" checked="checked" name="remember" style="all:revert; margin-bottom:15px"> Remember me
          </label>

          <p>By creating an account you agree to our <a href="/villain/source/privacy.html" style="all:revert; color:dodgerblue">Terms & Privacy</a>.</p>

          <div class="signup-clearfix">
            <button type="button" onclick="document.getElementById('signup-id').style.display='none'" class="signup-cancelbtn signup-btn">Cancel</button>
            <button type="submit" class="signupbtn signup-btn" name="signup-btn">Sign Up</button>
          </div>
        </div>
      </form>
  </div>
  
    <!-- Forgot password -->
    <div id="passreset-id" class="passReset" style=''>
      <span onclick="document.getElementById('login-id').style.display='none'"
    class="login-close" title="Close Modal">&times;</span>
      <!-- Forgot Password Content -->
      <form class="passReset-content passReset-animate" method="POST" action="/villain/source/actions.php">
      
        <div class="passReset-container">
                <h3 style="font-size: 30px; padding-bottom: 10px; font-weight: normal">Forgot Password</h3>
          <label for="uname"><b>Email</b></label>
          <input class="passReset-input" type="email" placeholder="Enter Email" name="umail" required>

          <button type="submit" class="passReset-btn" name="passreset-btn">Reset password</button>
        </div>

        <div class="passReset-container" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('login-id').style.display='none'" class="passReset-cancelbtn">Cancel</button>
        </div>
      </form>
    </div>
