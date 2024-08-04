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
  <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/events.css">
  <link rel="stylesheet" type="text/css" href="assets/css/login-signup.css">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&family=Poppins:wght@400;500;700&display=swap"
    rel="stylesheet">
</head>

<body id="top">

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
        <img src="./assets/images/logo.png" style="width: 115px; height: 115px;" alt="VILLAIN logo">
      </a>

      <button class="nav-open-btn" data-nav-open-btn>
        <ion-icon name="menu-outline"></ion-icon>
      </button>

      <nav class="navbar" data-nav>

        <div class="navbar-top">

          <a href="#" class="logo">
            <img src="./assets/images/logo.png" style="width: 115px; height: 115px;" alt="VILLAIN logo">
          </a>

          <button class="nav-close-btn" data-nav-close-btn>
            <ion-icon name="close-outline"></ion-icon>
          </button>

        </div>
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



  <main>
    <article>
        
      <div class="container" style="display: none;">
          <form action="action_page.php">

            <label for="fname">First Name</label>
            <input type="text" id="fname" name="firstname" placeholder="Your name..">

            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lastname" placeholder="Your last name..">

            <label for="country">Country</label>
            <select id="country" name="country">
              <option value="australia">Australia</option>
              <option value="canada">Canada</option>
              <option value="usa">USA</option>
            </select>

            <label for="subject">Subject</label>
            <textarea id="subject" name="subject" placeholder="Write something.." style="height:200px"></textarea>

            <input type="submit" value="Submit">

          </form>
        </div>  


      <div class="section-wrapper">
  
        <div class="events" id="events">
            <ul>
                <?php
                if(isset($_SESSION["email"]) && isset($_SESSION["pass"])){
                    require_once ('./source/mysqli_connect.php');
                    
                    // Get customer ID
                    $q = "SELECT id FROM customer WHERE email = '".$_SESSION["email"]."' AND pass = '".$_SESSION["pass"]."';";
                    $r = mysqli_query ($dbc, $q);// Run the query.
                    $custID = mysqli_fetch_array($r, MYSQLI_ASSOC)["id"];
                    
                    // SQL statement that fetch all booked events
                    $q = "SELECT schedule_id, amount, quantity, date FROM payment1 WHERE passenger_id =".$custID;
                    $r = mysqli_query ($dbc, $q);// Run the query.
                    $allBookedEvents = mysqli_fetch_all($r, MYSQLI_ASSOC);
                    if($allBookedEvents){
                    
                        foreach ($allBookedEvents as $event) {
                            $ticketPriceBought = $event["amount"];
                            $ticketQuantity = $event["quantity"];

                            $q = "SELECT EventID, time, goldprice, silverprice, bronzeprice from schedule WHERE id = ".$event["schedule_id"];
                            $r = mysqli_query ($dbc, $q);// Run the query.
                            //echo var_dump($r);
                            $obj = mysqli_fetch_array($r, MYSQLI_ASSOC);
                            $eventID = $obj["EventID"];
                            $eventGoldPrice = $obj["goldprice"];
                            $eventSilverPrice = $obj["silverprice"];
                            $eventBronzePrice = $obj["bronzeprice"];
                            $eventStartTime = $obj["time"];

                            $q = "SELECT EventName, Description, StartDate FROM villain WHERE EventID = ".$eventID;
                            $r = mysqli_query ($dbc, $q);// Run the query.
                            $obj = mysqli_fetch_array($r, MYSQLI_ASSOC);
                            $eventName = $obj["EventName"];
                            $location = explode("\n",$obj["Description"])[0];
                            $startDate = $obj["StartDate"];
                            $day = explode("-", $startDate)[2];
                            $month = explode("-", $startDate)[1];

                            //echo "<script>console.log('$ticketPriceBought','$eventGoldPrice')</script>";
                            //echo "<script>console.log('$ticketPriceBought','$eventSilverPrice')</script>";
                            //echo "<script>console.log('$ticketPriceBought','$eventBronzePrice')</script>";
                            if($ticketPriceBought == $eventGoldPrice){
                                $ticketType = "Gold";
                            }else if($ticketPriceBought == $eventSilverPrice){
                                $ticketType = "Silver";
                            }else{
                                $ticketType = "Bronze";
                            }                          

                            switch ($month) {
                                case 1:
                                    $month = "January";
                                    break;
                                case 2:
                                    $month = "February";
                                    break;
                                case 3:
                                    $month = "March";
                                    break;
                                case 4:
                                    $month = "April";
                                    break;
                                case 5:
                                    $month = "May";
                                    break;
                                case 6:
                                    $month = "June";
                                    break;
                                case 7:
                                    $month = "July";
                                    break;
                                case 8:
                                    $month = "August";
                                    break;
                                case 9:
                                    $month = "September";
                                    break;
                                case 10:
                                    $month = "October";
                                    break;
                                case 11:
                                    $month = "November";
                                    break;
                                case 12:
                                    $month = "December";
                                    break;
                                default:
                                    $month = "Invalid";
                                    break;
                            }


                            echo ' 
                            <li>
                                <div class="time">
                                    <h2>
                                        '.$day.' <br><span>'.$month.'</span><span>'.$eventStartTime.'</span>
                                    </h2>
                                </div>
                                <div class="details">
                                    <h3>
                                        '.$eventName.' ('.$location.')
                                    </h3> 
                                    <p style="font-size: 20px;font-weight: 400;">
                                        Ticket Type: '.$ticketType.'<br>
                                        Ticket Quantity: '.$ticketQuantity.' 
                                    </p>
                                    <br/>

                                    <a href="./source/deleteBooking.php">Delete Booking</a>
                                </div>
                                <div style="clear: both;"></div>
                            </li>
                            ';
                        }
                    }else{
                        echo "<h1 style='text-align-last: center;color: hsl(0, 0%, 80%);padding-top: 80px;bottom:0px'>You have no bookings</h1>";
                    }
                    
                }else{
                    echo "<h1 style='text-align-last: center;color: hsl(0, 0%, 80%);padding-top: 80px;bottom:0px'>Login to view your booked events</h1>";
                }
                ?>
            </ul>
        </div>

<?php include("./source/footer.php");?>

  <!-- 
    - #GO TO TOP
  -->

  <a href="#top" class="btn btn-primary go-top" data-go-top>
    <ion-icon name="chevron-up-outline"></ion-icon>
  </a>





  <!-- 
    - custom js link
  -->
  <script src="./assets/js/script.js"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>

