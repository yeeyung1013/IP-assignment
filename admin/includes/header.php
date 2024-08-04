<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GameX - Gaming website</title>

  <!-- 
    - favicon link
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

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
        <img src="/villain/assets/images/logo.png" style="width: 115px; height: 115px;" alt="GameX logo">
      </a>

      <button class="nav-open-btn" data-nav-open-btn>
        <ion-icon name="menu-outline"></ion-icon>
      </button>

      <nav class="navbar" data-nav>

        <ul class="navbar-list">

          <li>
            <a href="/villain/admin/Events.php" class="navbar-link">Event</a>
          </li>

          <li>
            <a href="#about" class="navbar-link">About</a>
          </li>
          <!--
          <li>
            <a href="#tournament" class="navbar-link">Tournament</a>
          </li>
          -->
          <li>
            <a href="#speaker" class="navbar-link">Speakers</a>
          </li>

          <li>
            <a href="#tickets" class="navbar-link">Tickets</a>
          </li>

          <li>
            <a href="/villain/events.php" class="navbar-link">Other Events</a>
          </li>
          
          <li>
            <a href="/villain/bevent.html" class="navbar-link">Booked Events</a>
          </li>
          
          <li>
              <a href="/villain/cart.php" class="navbar-link" id="cartBadge">Cart</a>
          </li>

        <ul class="nav-social-list">

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-twitter"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-instagram"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-github"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-youtube"></ion-icon>
            </a>
          </li>

        </ul>

      </nav>

      <div class="header-actions">
        <button class="btn-sign_in" onclick="document.getElementById('login-id').style.display='block'">

          <div class="icon-box">
            <ion-icon name="log-in-outline"></ion-icon>
          </div>

          <span>Log-in / Sign-up</span>

        </button>

      </div>

    </div>

  </header>
  
  <!-- Login/Sign in -->
    <div id="login-id" class="login" style=''>
      <span onclick="document.getElementById('login-id').style.display='none'"
    class="login-close" title="Close Modal">&times;</span>
      <!-- Login Content -->
      <form class="login-content login-animate" action="/action_page.php">
      
        <div class="login-container">
            <h3 style="font-size: 30px; padding-bottom: 10px; font-weight: normal">Sign in</h3>
          <label for="uname"><b>Username</b></label>
          <input class="login-input" type="text" placeholder="Enter Username" name="uname" required>

          <label for="psw"><b>Password</b></label>
          <input class="login-input" type="password" placeholder="Enter Password" name="psw" required>

          <button type="submit" class="login-btn">Login</button>
          <label>
            <input type="checkbox" checked="checked" name="remember" style="all:revert;">Remember me
          </label>
        </div>

        <div class="login-container" style="background-color:#f1f1f1">
          <button type="button" onclick="document.getElementById('login-id').style.display='none'" class="login-cancelbtn">Cancel</button>
          <span class="login-psw"><a class="login-reset-a" href="#" onclick="signup()">Sign up</a> / <a class="login-reset-a" href="#">Forgot password?</a></span>
        </div>
      </form>
    </div>
  
  <!-- Sign up -->
  <div id="signup-id" class="signup" style=''>
      <span onclick="document.getElementById('signup-id').style.display='none'" class="signup-close" title="Close Modal">&times;</span>
      <form class="signup-content" action="/action_page.php">
        <div class="signup-container">
          <h3 style="font-size: 30px; padding-bottom: 10px; font-weight: normal">Sign Up</h1>
          <p>Please fill in this form to create an account.</p>
          <hr class="signup-hr">
          <label for="email"><b>Email</b></label>
          <input type="text" placeholder="Enter Email" name="email" class="signup-input" required>

          <label for="psw"><b>Password</b></label>
          <input type="password" placeholder="Enter Password" name="psw" class="signup-input" required>

          <label for="psw-repeat"><b>Repeat Password</b></label>
          <input type="password" placeholder="Repeat Password" name="psw-repeat" class="signup-input" required>

          <label>
            <input type="checkbox" checked="checked" name="remember" style="all:revert; margin-bottom:15px"> Remember me
          </label>

          <p>By creating an account you agree to our <a href="#" style="all:revert; color:dodgerblue">Terms & Privacy</a>.</p>

          <div class="signup-clearfix">
            <button type="button" onclick="document.getElementById('signup-id').style.display='none'" class="signup-cancelbtn signup-btn">Cancel</button>
            <button type="submit" class="signupbtn signup-btn">Sign Up</button>
          </div>
        </div>
      </form>
  </div>
