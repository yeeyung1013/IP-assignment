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
  <link rel="shortcut icon" href="/villain/assets/images/logo.png" type="image/png">

  <!-- 
    - custom css link
  -->
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
            <a href="#" class="navbar-link" onclick="document.location = 'index.php'">Back</a>
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
      <form method="POST" action="../controller/paymentController.php?controller=payment&action=process">
        <div class="payment-container">
          <div class="buyer-details">
            <div class="payment-heading">
              <h1>
                <i class="fa fa-user color-eblue"></i>
                Select Payment Method
              </h1>
            </div>
            <p>Choose your preferred payment method and click 'Payment'</p>
            <div class="payment-method-total-amount">Total Amount : <b>MYR <?= $_SESSION['total_amount']?></b></div>
            <!-- Payment Method Options -->
            <div class="payment-options">
              <!-- Paypal -->
              <div class="payment-option" onclick="selectPayment('paypalPayment')">
                <div class="radio-input">
                  <input id="paypalPayment" type="radio" name="payment_method" value="PayPal" required />
                </div>
                <img src="../assets/images/payment/paypal_logo.png" alt="Paypal logo">
                <div>Paypal</div>
              </div>
              <!-- Credit/Debit Card  -->
              <div class="payment-option" onclick="selectPayment('cardPayment')">
                <div class="radio-input">
                  <input id="cardPayment" type="radio" name="payment_method" value="Credit Card" required />
                </div>
                <img src="../assets/images/payment/creditCard_logo.jpg" alt="Visa/Mastercard logo">
                <div>Credit/Debit Card</div>
              </div>
            </div>
            <div class="payment-btn">
              <button type="submit" id="submit">Payment</button>
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
      </div>
    </div>
  </div>
</body>

<script>
  function selectPayment(optionId) {
    const allPaymentOptions = document.querySelectorAll('.payment-option');
    const selectedRadio = document.getElementById(optionId);

    allPaymentOptions.forEach(option => {
      option.classList.remove('selected');
      option.querySelector('input[type="radio"]').checked = false;
    });

    const selectedOption = selectedRadio.closest('.payment-option');
    selectedOption.classList.add('selected');
    selectedRadio.checked = true;
  }
</script>

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