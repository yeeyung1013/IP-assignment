<!DOCTYPE html>
<html>
<?php
include './includes/helpers.php';
//include './includes/dbConnector.php';
if (@$_GET['page'] == 'print' && isset($_GET['code'])) {
    printClearance($_GET['code']);
    // echo "<script>window.location='admin.php'</script>";
}
if (@$_GET['page'] == 'report' && isset($_GET['id'])) {
    printReport($_GET['id']);
    // echo "<script>window.location='admin.php'</script>";
}
?>
<head>
<title>Villain Admin Page</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="dss/adminlte.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
</head>
<body class="w3-light-grey">

<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
<!--  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>-->
<!--  <span class="w3-bar-item w3-right">Villain</span>-->
   <p class="alert alert-info">
            <marquee behavior="" scrollamount="2" direction="">Villain Admin Home Page!!!
            </marquee>
        </p>
</div>
<!-- Sidebar/menu -->
<!--<br/>
<br/>
<br/>
<br/>-->
<br/>
<br/>
<br/>
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <img src="image/staff.png" alt="User Image" class="w3-circle w3-margin-right" style="width:46px">
    </div>
    <div class="w3-col s8 w3-bar">
      <span>Welcome, <strong>Villain Staff</strong></span><br>
          <a href="admin.php" class="brand-link">

                <span class="brand-text font-weight-light"><?php echo date("D d, M y"); ?></span>
            </a>
     <br/>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Dashboard</h5>
  </div>
  <div class="w3-bar-block">
    <a href="home.php" class="w3-bar-item w3-button w3-padding">Home</a>
    <a href="admin1.php" class="w3-bar-item w3-button w3-padding">Admin</a>
    <a href="Events.php" class="w3-bar-item w3-button w3-padding">Events</a>
    <a href="schedule.php" class="w3-bar-item w3-button w3-padding">Schedule</a>
    <a href="ticket.php" class="w3-bar-item w3-button w3-padding">Tickets</a>
    <a href="payment.php" class="w3-bar-item w3-button w3-padding">Payments</a>
    <a href="home.php?page=logout" class="w3-bar-item w3-button w3-padding">Logout</a><br><br>
  </div>
</nav>

            
            <?php
            if (!isset($_GET['page']))
                include 'index.php';
            elseif ($_GET['page'] == 'users')
                include 'admin1.php';
            elseif ($_GET['page'] == 'logout') {
                @session_destroy();
                echo "<script>alert('You are being logged out'); window.location='../';</script>";
                exit;
            } 
            else {
//                include 'admin/index.php';
            }
            ?>
            
        <div class="w3-main" style="margin-left:300px;margin-top:43px;">

   <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
    <div class="content">
    <h5 class="mt-4 mb-2">Hi, System Administrator</h5>
        </header>
    
<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-male w3-xxxlarge"></i></div>
        <div class="w3-clear"></div>
        <span class="info-box-number">
                        <?php
                        echo $reg =$dbConnection->query("SELECT * FROM users")->num_rows;
                        ?></span>
        <h4>Admin</h4>
      </div>
    </div>
    
    <div class="w3-quarter">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
        <div class="w3-clear"></div>
        <span
                        class="info-box-number">
                            <?php echo $dbConnection->query("SELECT * FROM schedule")->num_rows ?>
                    </span>
        <h4>Schedules</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-clear"></div>
        <span class="info-box-number"> $ <?php
                    $row = $dbConnection->query("SELECT SUM(amount) AS amount FROM payment")->fetch_assoc();
                    echo $row['amount'] == null ? '0' : $row['amount'];
                    ?></span>
        <h4>Payments</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-green w3-padding-16">
        <div class="w3-left"><i class="fa fa-search w3-xxxlarge"></i></div>
        <div class="w3-clear"></div>
        <span
                        class="info-box-number">
                            <?php echo $dbConnection->query("SELECT * FROM villain")->num_rows ?>
                    </span>
        <h4>Events</h4>
      </div>
    </div>

    <div class="w3-quarter">
    <br/>
      <div class="w3-container w3-purple w3-padding-16">
        <div class="w3-left"><i class="fa fa-male w3-xxxlarge"></i></div>
        <div class="w3-clear"></div>
        <span class="info-box-number">
                            <?php echo $dbConnection->query("SELECT * FROM ticket")->num_rows ?>
                    </span>
        <h4>Tickets</h4>
      </div>
    </div>

    <div class="w3-quarter">
        <br/>
      <div class="w3-container w3-gray w3-padding-16">
        <div class="w3-left"><i class="fa fa-male w3-xxxlarge"></i></div>
        <div class="w3-clear"></div>
        <span class="info-box-number">
                        <?php
                        echo $reg =$dbConnection->query("SELECT * FROM customer")->num_rows;
                        ?></span>
        <h4>Customer</h4>
      </div>
    </div>
    
   <div class="w3-panel">
    <div class="w3-row-padding" style="margin:0 -16px">
      <div class="w3-third">
             <br/>
        <h5>Society Logo</h5>
                <img src="image/villain.jpeg" alt="Villain Logo"style="width:100%">
      </div>
        <div class="w3-twothird">
               <br/>
        <h5>Daily Report</h5>
        <table class="w3-table w3-striped w3-white">
                 <table class="w3-table w3-striped w3-white">
          <tr>
            <td><i class="fa fa-user w3-text-blue w3-large"></i></td>
            <td>New record, over 50 views.</td>
            <td><i>10 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-bell w3-text-red w3-large"></i></td>
            <td>Loopholes problem (Database error)</td>
            <td><i>15 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-users w3-text-yellow w3-large"></i></td>
            <td>New register user.</td>
            <td><i>17 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-comment w3-text-red w3-large"></i></td>
            <td>User new comments.</td>
            <td><i>25 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-bookmark w3-text-blue w3-large"></i></td>
            <td>Check transactions.</td>
            <td><i>28 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-laptop w3-text-red w3-large"></i></td>
            <td>CPU overload.</td>
            <td><i>35 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-share-alt w3-text-green w3-large"></i></td>
            <td>New shares for the events.</td>
            <td><i>39 mins</i></td>
          </tr>
        </table>
      </div>
            </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>General Statistics</h5>
    <p>New Visitors</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-green" style="width:25%">+25%</div>
    </div>

    <p>New Users</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-orange" style="width:50%">50%</div>
    </div>

    <p>Bounce Rate</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-red" style="width:75%">75%</div>
    </div>
    
    <p>User Payment</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-blue" style="width:100%">100%</div>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Recent Users</h5>
    <ul class="w3-ul w3-card-4 w3-white">
      <li class="w3-padding-16">
        <img src="image/weidian.jpeg" class="w3-left w3-circle w3-margin-right" width="50px" height="45px">
        <span class="w3-xlarge">Wei Dian</span><br>
      </li>
      <li class="w3-padding-16">
          <img src="image/junxiang.jpeg" class="w3-left w3-circle w3-margin-right" width="50px" height="45px">
        <span class="w3-xlarge">Jun Xiang</span><br>
      </li>
      <li class="w3-padding-16">
        <img src="image/junkit.jpeg" class="w3-left w3-circle w3-margin-right" width="50px" height="45px">
        <span class="w3-xlarge">Jun Kit</span><br>
      </li>
    </ul>
  </div>
  <hr>

  <div class="w3-container">
    <h5>Recent Comments</h5>
    <div class="w3-row">
      <div class="w3-col m2 text-center">
        <img class="w3-circle" src="image/junkit.jpeg" style="width:96px;height:96px">
      </div>
      <div class="w3-col m10 w3-container">
        <h4>Jun Kit<span class="w3-opacity w3-medium">   Sep 29, 2022, 9:12 PM</span></h4>
        <p>Continue to maintain a good service attitude! I am cheering for you! !</p><br>
      </div>
    </div>

    <div class="w3-row">
      <div class="w3-col m2 text-center">
        <img class="w3-circle" src="image/junxiang.jpeg" style="width:96px;height:96px">
      </div>
      <div class="w3-col m10 w3-container">
        <h4>Jun Xiang<span class="w3-opacity w3-medium">   Oct 01, 2022, 10:15 PM</span></h4>
        <p>Nice event, but the venue is too small to accommodate so many people</p><br>
      </div>
    </div>
  </div>
  <br/>
   <div class="w3-container w3-dark-grey w3-padding-32">
    <div class="w3-row">
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-green">Activity Support Rate</h5>
        <p>Events</p>
        <p>Users</p>
        <p>Age</p>
        <p>Interests</p>
      </div>
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-red">System</h5>
        <p>Browser</p>
        <p>OS</p>
        <p>More</p>
      </div>
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-orange">Target</h5>
        <p>Users</p>
        <p>Active</p>
        <p>Total Support</p>
      </div>
    </div>
  </div>
<!--    <script src="plug/jquery/jquery.min.js"></script>
    <script src="dss/js/adminlte.min.js"></script>
    <script src="plug/jquery/jquery.min.js"></script>-->
    
</body>
</html>