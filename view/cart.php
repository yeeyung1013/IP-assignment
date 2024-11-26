<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Other/html.html to edit this template
-->
<html>
<?php
session_start();
$event = $_SESSION['event_details'];

?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!---favicon link-->
  <link rel="shortcut icon" href="./villain/assets/images/logo.png" type="image/png">

  <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/cart.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!---google font link-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&family=Poppins:wght@400;500;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body id="top" onload="printItem()">
  <header class="header">
    <!---overlay-->
    <div class="overlay" data-overlay></div>
    <div class="container">
      <a href="index.php" class="logo">
        <img src="../assets/images/logo.png" style="width: 115px; height: 115px;" alt="VILLAIN logo">
      </a>
      <button class="nav-open-btn" data-nav-open-btn>
        <ion-icon name="menu-outline"></ion-icon>
      </button>
      <nav class="navbar" data-nav>
        <ul class="navbar-list">
          <li>
            <a href="#" class="navbar-link" onclick="document.location = '/villain/view/index.php'">Back</a>
          </li>
        </ul>
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
    </div>

  </header>
  <!----- Payment Form --->
  <div class="payment-form">
    <div class="cart-col-75">
      <form method="POST" action="../controller/paymentController.php?controller=payment&action=summary">
        <div class="payment-container">
          <div class="buyer-details">
            <div class="payment-heading">
              <h1>
                <i class="fa fa-user color-eblue"></i>
                Buyer Details
              </h1>
            </div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Name" required />
            <?php if (isset($_SESSION['nameError'])): ?>
            <span style="color:red;">
              <?php echo $_SESSION['nameError']; ?>
            </span>
            <?php endif; ?>
            <br>
            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="Example@email.com" required />
            <?php if (isset($_SESSION['emailError'])): ?>
            <span style="color:red;">
              <?php echo $_SESSION['emailError']; ?>
            </span>
            <?php endif; ?>
            <br>
            <label for="contactNum">Contact Number</label>
            <input type="text" id="contactNum" name="contactNum" placeholder="0123456789" required />
            <?php if (isset($_SESSION['contactNumError'])): ?>
            <span style="color:red;">
              <?php echo $_SESSION['contactNumError']; ?>
            </span>
            <?php endif; ?>
            <br>
            <!--
            <div class="exp-cvc">
              <div class="expiration">
                <label for="expiry">Expiration date</label>
                <input class="inputCard" name="expiry" id="expiry" type="text" required placeholder="00/00" />
                <br>
              </div>
              <div class="security">
                <label for="cvc">CVC</label>
                <input type="text" minlength="3" maxlength="4" id="cvc" name="cvc" placeholder="XXX" />
                <br>
              </div>
            </div>
            -->
            <div class="payment-btn">
              <button type="submit" id="submit">Next</button>
            </div>
          </div>
        </div>
      </form>
    </div>

    <div class="cart-col-25">
      <div class="countdown-container">
        <h2>
          <i class="fa fa-clock-o"></i>
          <span id="countdown">10:00</span>
        </h2>
      </div>

      <div class="payment-container">

        <div class="card-header event-title">
          <h2><?php echo $event[0]['EventName']; ?></h2>
        </div>
        <div class="card-body event-venue">
          <label>
            <i class="fa fa-map-marker color-eblue"></i>
            Venue
          </label>
          <div class="padding-s">
            <?php echo $event[0]['location']; ?>
          </div>
        </div>
        <div class="card-footer">
          <label>
            <i class="fa fa-money color-eblue"></i>
            Total Amount
          </label>
          <div class="align-center margin-s">
            <div class="font-bold font-s">
              RM <?= htmlspecialchars($_SESSION['total_amount']) ?>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</body>

</html>

<!--- Countdown Javascript -->
<script>
  function startCountdown(duration, display) {
    let timer = duration, minutes, seconds;
    const countdownInterval = setInterval(function () {
      minutes = parseInt(timer / 60, 10);
      seconds = parseInt(timer % 60, 10);

      minutes = minutes < 10 ? "0" + minutes : minutes;
      seconds = seconds < 10 ? "0" + seconds : seconds;

      display.textContent = minutes + ":" + seconds;

      if (--timer < 0) {
        clearInterval(countdownInterval);
        alert("Time's up! Payment session has expired.");
        window.location.href = 'index.php';
      }
    }, 1000);
  }

  window.onload = function () {
    const tenMinutes = 60 * 10, // 10 minutes
      display = document.querySelector('#countdown');
    startCountdown(tenMinutes, display);
  };
</script>