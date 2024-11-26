<!DOCTYPE html>
<html>
<?php
session_start();
include '../../controller/helpers.php';
//include './includes/dbConnector.php';
if (@$_GET['page'] == 'print' && isset($_GET['code'])) {
    printClearance($_GET['code']);
    // echo "<script>window.location='admin.php'</script>";
}
if (@$_GET['page'] == 'report' && isset($_GET['id'])) {
    printReport($_GET['id']);
    // echo "<script>window.location='admin.php'</script>";
}

$conn = new mysqli("localhost", "root", "", "villain");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$customer = "SELECT cust_id, email FROM customer ORDER BY cust_id DESC LIMIT 10";
$customer_result = $conn->query($customer);
$new_customer_count = $customer_result->num_rows;

$total_customers_query = "SELECT COUNT(*) as totalCustomer FROM customer";
$total_customers_result = $conn->query($total_customers_query);
$total_customers_row = $total_customers_result->fetch_assoc();
$total_customers_count = $total_customers_row['totalCustomer'];
$percentage_customer = $total_customers_count > 0 ? ($new_customer_count / $total_customers_count) * 100 : 0;

$events = "SELECT * FROM villain ORDER BY EventID DESC LIMIT 1";
$event_result = $conn->query($events);
$new_events_count = $event_result->num_rows;

$total_events_query = "SELECT COUNT(*) as totalEvent FROM villain";
$total_events_result = $conn->query($total_events_query);
$total_events_row = $total_events_result->fetch_assoc();
$total_events_count = $total_events_row['totalEvent'];
$percentage_events = $total_events_count > 0 ? ($new_events_count / $total_events_count) * 100 : 0;

$schedule = "SELECT * FROM schedule ORDER BY schedule_id DESC LIMIT 1";
$schedule_result = $conn->query($schedule);

$admin_count_query = "SELECT COUNT(*) as adminCount FROM admin WHERE position = 'Admin'";
$admin_count_result = $conn->query($admin_count_query);
$admin_count_row = $admin_count_result->fetch_assoc();
$admin_count = $admin_count_row['adminCount'];

$staff_count_query = "SELECT COUNT(*) as staffCount FROM admin WHERE position = 'Staff'";
$staff_count_result = $conn->query($staff_count_query);
$staff_count_row = $staff_count_result->fetch_assoc();
$staff_count = $staff_count_row['staffCount'];

$total_users_query = "SELECT COUNT(*) as totalUser FROM admin";
$total_users_result = $conn->query($total_users_query);
$total_users_row = $total_users_result->fetch_assoc();
$total_users_count = $total_users_row['totalUser'];
$percentage_admin = $total_users_count > 0 ? ($admin_count / $total_users_count) * 100 : 0;
$percentage_staff = $total_users_count > 0 ? ($staff_count / $total_users_count) * 100 : 0;

require_once 'conn.php';

if (isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];
} else {
    die("Admin ID not set. Please log in.");
}

try {
    $stmt = $conn->prepare("SELECT position,name, image FROM admin WHERE admin_id = ?");
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $name = $row['name'];
      $position = $row['position'];
      $image_path = $row['image'];
  }

    $stmt->close();
} catch (mysqli_sql_exception $e) {
    die("SQL Error: " . $e->getMessage());
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
html,body,h1,h2,h3,h4,h5 
{font-family: "Raleway", sans-serif}
.square {
  height: 60px;
  width: 60px;
  background-color: #555;
}

.box {
  height: 150px;
  width: 350px;
}
</style>
</head>
<body class="w3-light-grey">

<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
 <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
<span class="w3-bar-item w3-right">Villain</span>
</div>
<br/>
<br/>
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row" style="padding: 8px;">
    <div class="w3-col s4">
      <img src="upload/<?php echo htmlspecialchars($image_path); ?>" alt="User Image" class="square">
    </div>
    <div class="w3-col s8 w3-bar">
      <span>Welcome, <strong><?php echo htmlspecialchars($position); ?></strong></span><br>
          <a href="admin.php" class="brand-link">
                <span class="brand-text font-weight-light"><?php echo date("D d, M y"); ?></span>
            </a>
     <br/>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i></a>
      <a href="./admin_profile.php" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Dashboard</h5>
  </div>
  <div class="w3-bar-block">
    <a href="home.php" class="w3-bar-item w3-button w3-padding">Home</a>
    <a href="admin.php" class="w3-bar-item w3-button w3-padding">Admin</a>
    <a href="Events.php" class="w3-bar-item w3-button w3-padding">Events</a>
    <a href="schedule.php" class="w3-bar-item w3-button w3-padding">Schedule</a>
    <a href="ticketReport.php" class="w3-bar-item w3-button w3-padding">Tickets</a>
    <a href="adminReview.php" class="w3-bar-item w3-button w3-padding">Review</a>
    <a href="adminPayment.php" class="w3-bar-item w3-button w3-padding">Payments</a>
    <a href="home.php?page=logout" class="w3-bar-item w3-button w3-padding">Logout</a><br><br>
  </div>
</nav>

            
            <?php
            if (!isset($_GET['page']))
                include 'index.php';
            elseif ($_GET['page'] == 'users')
                include 'admin.php';
            elseif ($_GET['page'] == 'logout') {
                @session_destroy();
                echo "<script>alert('You are being logged out'); window.location='../';</script>";
                exit;
            } 
            else {
//                include 'admin/index.php';
            }
            ?>
            
        <div class="w3-main" style="margin-left:300px;margin-top:10px;">

   <!-- Header -->
  <header class="w3-container">
    <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
    <div class="content">
    <h5 class="mt-4 mb-2">Hi, <?php echo htmlspecialchars($name); ?></h5>
  </header>
    
<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter"  style="padding: 0 10px;">
      <div class="w3-container w3-red w3-padding-16 box">
        <div class="w3-left"><i class="fa fa-male w3-xxxlarge"></i></div>
        <div class="w3-clear"></div>
        <span class="info-box-number">
                        <?php
                        echo $reg =$dbConnection->query("SELECT * FROM admin")->num_rows;
                        ?></span>
        <h4>Admin</h4>
      </div>
    </div>
    
    <div class="w3-quarter" style="padding: 0 110px;">
      <div class="w3-container w3-blue w3-padding-16 box">
        <div class="w3-left"><i class="fa fa-calendar w3-xxxlarge"></i></div>
        <div class="w3-clear"></div>
        <span
                        class="info-box-number">
                            <?php echo $dbConnection->query("SELECT * FROM schedule")->num_rows ?>
                    </span>
        <h4>Schedules</h4>
      </div>
    </div>
    <div class="w3-quarter" style="padding: 0 210px;">
      <div class="w3-container w3-teal w3-padding-16 box">
        <div class="w3-left"><i class="fa fa-credit-card w3-xxxlarge"></i></div>
        <div class="w3-clear"></div>
        <span class="info-box-number"> $ <?php
                    $row = $dbConnection->query("SELECT SUM(amount) AS amount FROM payment")->fetch_assoc();
                    echo $row['amount'] == null ? '0' : $row['amount'];
                    ?></span>
        <h4>Payments</h4>
      </div>
    </div>
    </div>
    <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter" style="padding: 0 10px;">
      <div class="w3-container w3-green w3-padding-16 box">
        <div class="w3-left"><i class="fa fa-search w3-xxxlarge"></i></div>
        <div class="w3-clear"></div>
        <span
                        class="info-box-number">
                            <?php echo $dbConnection->query("SELECT * FROM villain")->num_rows ?>
                    </span>
        <h4>Events</h4>
      </div>
    </div>

    <div class="w3-quarter" style="padding: 0 110px;">
      <div class="w3-container w3-purple w3-padding-16 box">
        <div class="w3-left"><i class="fa fa-ticket w3-xxxlarge"></i></div>
        <div class="w3-clear"></div>
        <span class="info-box-number">
                            <?php echo $dbConnection->query("SELECT * FROM ticket")->num_rows ?>
                    </span>
        <h4>Tickets</h4>
      </div>
    </div>

    <div class="w3-quarter" style="padding: 0 210px;">
      <div class="w3-container w3-gray w3-padding-16 box">
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
        <a href="../source/customer_report.xml" class="w3-button w3-green">View XML Report</a>
        <table class="w3-table w3-striped w3-white">
        <thead>
        <tr>
            <th>Icon</th>
            <th>Message</th>
        </tr>
        </thead>
       <tbody>
       <?php
        if ($customer_result->num_rows > 0) {
            while ($row = $customer_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td><i class='fa fa-user w3-text-blue w3-large'></i></td>";
                echo "<td>New customer record for " . $row["email"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr>";
                echo "<td><i class='fa fa-user w3-text-blue w3-large'></i></td>";
                echo "<td colspan='3'>No new customer registrations.</td>";
                echo "</tr>";
        }
        ?>
        <?php
        if ($event_result->num_rows > 0) {
          while ($row = $event_result->fetch_assoc()) {
              echo "<tr>";
              echo "<td><i class='fa fa-bookmark w3-text-blue w3-large'></i></td>";
              echo "<td>New event record for " . $row["EventName"] . "</td>";
              echo "</tr>";
          }
      } else {
          echo "<tr>";
              echo "<td><i class='fa fa-bookmark w3-text-blue w3-large'></i></td>";
              echo "<td colspan='3'>No new events registrations.</td>";
              echo "</tr>";
      }
        ?>
         <?php
        if ($schedule_result->num_rows > 0) {
          while ($row = $schedule_result->fetch_assoc()) {
              echo "<tr>";
              echo "<td><i class='fa fa-calendar w3-text-blue w3-large'></i></td>";
              echo "<td>New event schedule for " . $row["EventID"] . "</td>";
              echo "</tr>";
          }
      } else {
          echo "<tr>";
              echo "<td><i class='fa fa-calendar w3-text-blue w3-large'></i></td>";
              echo "<td colspan='3'>No new events schedule registrations.</td>";
              echo "</tr>";
      }
        ?>
    </tbody>
    </table>
      </div>
            </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>General Statistics</h5>
    <p>New Cusomter Register</p>
    <div class="w3-grey">
    <div class="w3-container w3-center w3-padding w3-green" style="width:<?php echo $percentage_customer; ?>%">
    <?php echo round($percentage_customer); ?>%
</div>
    </div>

    <p>New Events Created</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-orange" style="width:<?php echo $percentage_events; ?>%">
      <?php echo round($percentage_events); ?>%
    </div>
    </div>

    <p>New Admin Register</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-blue" style="width:<?php echo $percentage_admin; ?>%">
      <?php echo round($percentage_admin); ?>%
    </div>
    </div>

    <p>New Staff Register</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-red" style="width:<?php echo $percentage_staff; ?>%">
      <?php echo round($percentage_staff); ?>%
    </div>
    </div>
  <hr>
  <div class="w3-container">
    <!-- <h5>Recent Users</h5>
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
  </div> -->
  <hr>

  <div class="w3-container">
    <!-- <h5>Recent Comments</h5>
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
  </div> -->
    
</body>
</html>