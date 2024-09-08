<!DOCTYPE html>
<?php
$pageTitle = "Insert Schedule";
include './includes/dbConnector.php';
include './includes/helpers.php';
include './class/schedule.php'; 

if(isset($_GET['id'])){
   $eventId = trim($_GET['id']);
   
   $dbConnection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
   $selectCommand = "SELECT * FROM villain WHERE EventID = '$eventId'";
   
   $result = mysqli_query($dbConnection, $selectCommand);
   
}

if (isset($_POST['btnSubmit'])){
    $schedule_id = isset($_POST['schedule_id']) ? trim($_POST['schedule_id']) : "";
    $eventId = isset($_POST['eventId']) ? trim($_POST['eventId']) : "";
    $date = isset($_POST['date']) ? trim($_POST['date']) : "";
    $time = isset($_POST['time']) ? trim($_POST['time']) : "";
    
    $errMsgSeheduleId = validateScheduleId($schedule_id);
    $errMsgScheduleEventId=validateScheduleEventId($eventId);
    $errMsgDate = validateDate($date);
    $errMsgTime = validateTime($time);
    
    $finalErrorMessage =array_merge($errMsgSeheduleId ,array_merge($errMsgScheduleEventId, array_merge($errMsgDate, 
            array_merge(array_merge($errMsgTime)))));
    if(count($finalErrorMessage) > 0){
        echo "<ul>";
        foreach ($finalErrorMessage as $message) {
            echo "<li>$message</li>";
        }
    } else {
        $dbConnection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $schedule = new Schedule($dbConnection);
        $schedule->setSchedule($schedule_id, $eventId, $date, $time);
        $result = $schedule->saveSchedule();
        
        if ($result === true) {
          echo "<script type='text/javascript'>
          alert('New Events Schedule has been inserted successfully.');
          window.location.href = 'schedule.php';
        </script>";
      } else {
        echo "<script>alert('Failed to insert new schedule.');</script>";
      }
  }
}
?>
<head lang="en">
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <title>Insert Events Form</title>

   <link rel="stylesheet" href="../assets/css/admin/bootstrap.min.css">
</head>
<style>
body {
  font-family: "Roboto", sans-serif;
  background-color: #686868;
  line-height: 1.9;
  color: #8c8c8c;
  position: relative; }
  body:before {
    z-index: -1;
    position: absolute;
    height: 50vh;
    content: "";
    top: 0;
    left: 0;
    right: 0;
    background: #F0F0F0; }

a {
  text-decoration: none;
  display: inline-block;
  padding: 5px 20px;
}

a:hover {
  background-color: #ddd;
  color: black;
  text-decoration: none;
}

.previous {
  background-color: #F0F0F0;
  color: black;
}

.text-black {
  color: #000; }

.content {
  padding: 7rem 0; }

.heading {
  font-size: 2.5rem;
  font-weight: 900; }

.form-control {
  border: none;
  border-bottom: 1px solid #ccc;
  padding-left: 0;
  padding-right: 0;
  border-radius: 0;
  background: none; }
  .form-control:active, .form-control:focus {
    outline: none;
    -webkit-box-shadow: none;
    box-shadow: none;
    border-color: #000; }

.col-form-label {
  color: #000;
  font-size: 13px; }

.btn, .form-control, .custom-select {
  height: 45px; }

.custom-select:active, .custom-select:focus {
  outline: none;
  -webkit-box-shadow: none;
  box-shadow: none;
  border-color: #000; }

.btn {
  border: none;
  border-radius: 0;
  font-size: 12px;
  letter-spacing: .2rem;
  text-transform: uppercase; }
  .btn.btn-primary {
    background: #35477d;
    color: #fff;
    padding: 15px 20px; }
  .btn:hover {
    color: #fff; }
  .btn:active, .btn:focus {
    outline: none;
    -webkit-box-shadow: none;
    box-shadow: none; }

.contact-wrap {
  -webkit-box-shadow: 0 0px 20px 0 rgba(0, 0, 0, 0.2);
  box-shadow: 0 0px 20px 0 rgba(0, 0, 0, 0.2); }
  .contact-wrap .col-form-label {
    font-size: 14px;
    color: #686868;
    margin: 0 0 10px 0;
    display: inline-block;
    padding: 0; }
  .contact-wrap .form, .contact-wrap .contact-info {
    padding: 40px; }
  .contact-wrap .contact-info {
    color: rgba(255, 255, 255, 0.5); }
  .contact-wrap .form {
    background: #fff; }
    .contact-wrap .form h3 {
      color: #35477d;
      font-size: 20px;
      margin-bottom: 30px; }
  .contact-wrap .contact-info {
    background: #35477d; }
    .contact-wrap .contact-info h3 {
      color: #fff;
      font-size: 20px;
      margin-bottom: 30px; }

</style>
<a href="Events.php" class="previous">&laquo; Go Back</a>
<body>
<div class="content">
  
  <div class="container">
    <div class="row align-items-stretch no-gutters contact-wrap">
      <div class="col-md-8">
        <div class="form h-100">
          <h3>Create new schedule</h3>
          <form class="mb-5" method="post">
    <div class="row">
        <div class="col-md-6 form-group mb-5">
        <label for="box" class="col-form-label">Events ID</label>
        <input class="form-control" type="text" name="eventId" value="<?php echo htmlspecialchars($eventId); ?>">
        </div>
        <div class="col-md-6 form-group mb-5">
            <label for="dateBox" class="col-form-label">Date</label>
            <input class="form-control" name="date" id="dateBox" type="date" required="true"/>
        </div>
        <div class="col-md-6 form-group mb-5">
        <label for="timeBox" class="col-form-label">Time</label>
        <input class="form-control" type="time" name="time"  id="timeBox" required="true"/>
        </div>
    </div>
    <div class="col-md-12 text-center form-group">
        <input type="submit" name="btnSubmit" value="Insert" class="btn btn-primary rounded-0 py-2 px-4" style="background-color: green; color: white;" />
        <input type="reset" name="btnCancel" value="Cancel" onclick="location='Events.php'" class="btn btn-primary rounded-0 py-2 px-4" style="background-color: red; color: white;" />
    </div>
</form>

        </div>
      </div>
      <div class="col-md-4">
        <div class="contact-info h-100">
          <h3>Insert Schedule Information</h3>
          <p class="mb-5">If you got any problem in create the information Please follow this rule.</p>
          <ul class="list-unstyled">
            <li class="d-flex">
              <span class="wrap-icon icon-room mr-3"></span>
              <span class="text">1.)The Schedule ID only can enter number cant accept the Alphabetic.</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
<script>
      $(document).ready(function () {
        $("#descriptionBox").on("input", function () {
          this.style.height = "auto";
          this.style.height = this.scrollHeight + 10 + "px";
        });
      });
    </script>
    