<!-- <!DOCTYPE html>
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
            <marquee behavior="" scrollamount="1" direction="">Villain!!!
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
      <span>Welcome, <strong>Mike</strong></span><br>
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
    <a href="admin.php" class="w3-bar-item w3-button w3-padding">Home</a>
    <a href="admin1.php" class="w3-bar-item w3-button w3-padding">Admin</a>
    <a href="Events.php" class="w3-bar-item w3-button w3-padding">Events</a>
    <a href="schedule.php" class="w3-bar-item w3-button w3-padding">Schedule</a>
    <a href="payment.php" class="w3-bar-item w3-button w3-padding">Payments</a>
    <a href="admin.php?page=logout" class="w3-bar-item w3-button w3-padding">Logout</a><br><br>
  </div>
</nav>

            
            <?php
            if (!isset($_GET['page']))
                include 'index.php';
            elseif ($_GET['page'] == 'dynamic')
                include 'Events.php';
            elseif ($_GET['page'] == 'schedule')
                include 'schedule.php';
            elseif ($_GET['page'] == 'users')
                include 'admin1.php';
            elseif ($_GET['page'] == 'logout') {
                @session_destroy();
                echo "<script>alert('You are being logged out'); window.location='../';</script>";
                exit;
            } elseif ($_GET['page'] == 'payment')
                include 'payment.php';
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
    
<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
        <div class="w3-clear"></div>
        <span class="info-box-number">
                        <?php
                        echo $reg =$dbConnection->query("SELECT * FROM admin")->num_rows;
                        ?></span>
        <h4>Admin</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
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
    </header>
    <script src="plug/jquery/jquery.min.js"></script>
    <script src="dss/js/adminlte.min.js"></script>
    <script src="plug/jquery/jquery.min.js"></script>
    
</body>
</html>


 -->
