<?php
 $pageTitle = "Edit Schedule";

include './includes/dbConnector.php';
include './includes/helpers.php';
include './class/schedule.php'; 

if(isset($_GET['id'])){
    $schedule_id = trim($_GET['id']);
    
    $dbConnection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    $selectCommand = "SELECT * FROM schedule WHERE schedule_id = '$schedule_id'";
    
    $result = mysqli_query($dbConnection, $selectCommand);
    
    
    if ($result->num_rows==1){
        $schedule = mysqli_fetch_object($result);

        $schedule_id = $schedule->schedule_id;
        $eventId = $schedule->EventID;
        $date = $schedule->date;
        $time = $schedule->time;
    }
}
if (isset($_POST['btnSubmit'])) {
  $date = isset($_POST['date']) ? trim($_POST['date']) : "";
  $time = isset($_POST['time']) ? trim($_POST['time']) : "";

  $errMsgDate = validateDate($date);
  $errMsgTime = validateTime($time);

  $finalErrorMessage = array_merge($errMsgTime, array_merge($errMsgDate));

  if (count($finalErrorMessage) > 0) {
      echo "<div class='error'>";
      echo "<ul>";
      foreach ($finalErrorMessage as $message) {
          echo "<li>$message</li>";
      }
      echo "</ul>";
      echo "</div>";
  } else {
      $dbConnection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
      $schedule = new Schedule($dbConnection);
      $schedule->setSchedule($schedule_id, $eventId, $date, $time);
      $result = $schedule->updateSchedule();

      if ($result === true) {
          echo "<script type='text/javascript'>
          alert('The Schedule Events has been updated successfully.');
          window.location.href = 'schedule.php';
          </script>";
      } else {
      }
  }
}
$dbConnection->close();
?>
<head lang="en">
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <title>Edit Schedule Form</title>
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
  background: #f2f2f2; }

  .form-control:active, .form-control:focus {
    outline: none;
    -webkit-box-shadow: none;
    box-shadow: none;
    border-color: #000; 
    background: #f2f2f2;}

.col-form-label {
  color: #000;
  font-size: 13px; }

.btn, .custom-select {
  height: 45px; }

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

  .contact-wrap .col-form-label {
    font-size: 14px;
    color: #686868;
    margin: 0 0 10px 0;
    display: inline-block;
    padding: 0; }
  .contact-wrap .form, .contact-wrap .contact-info {
    padding: 60px;
    margin:10px; }
  .contact-wrap .contact-info {
    color: rgba(255, 255, 255, 0.5); }
  .contact-wrap .form {
    background: #fff;
    width: 90%; 
    }
    .contact-wrap .form h3 {
      color: #35477d;
      font-size: 20px;
      margin-bottom: 30px; }
</style>
<a href="schedule.php" class="previous">&laquo; Go Back</a>
    <div class="content">
        <div class="container">
            <div class="row align-items-stretch no-gutters contact-wrap">
                <div class="form h-100">
                    <h3>Edit Events Schedule</h3>
                    <form method="POST" class="mb-5">
                        <div class="row">
                            <div class="col-md-6 form-group mb-5">
                                <label for="schedule_box" class="col-form-label">Schedule ID</label>
                                <p class="form-control"><?php echo htmlspecialchars($schedule_id); ?></p>
                            </div>

                            <div class="col-md-6 form-group mb-5">
                                <label for="eventBox" class="col-form-label">Event ID</label>
                                <input class="form-control" type="text" name="eventId" id="eventBox" required
                                       value="<?php echo htmlspecialchars($eventId); ?>"/>
                            </div>

                            <div class="col-md-6 form-group mb-5">
                                <label for="dateBox" class="col-form-label">Date</label>
                                <input class="form-control" type="date" name="date" id="dateBox" required
                                       value="<?php echo htmlspecialchars($date); ?>"/>
                            </div>

                            <div class="col-md-6 form-group mb-5">
                                <label for="timeBox" class="col-form-label">Time</label>
                                <input class="form-control" type="time" name="time" id="timeBox" required
                                       value="<?php echo htmlspecialchars($time); ?>"/>
                            </div>

                            <div class="col-md-12 text-center form-group">
                                <input type="submit" name="btnSubmit" value="Update" class="btn btn-primary rounded-0 py-2 px-4" style="background-color: green; color: white;" />
                                <input type="reset" name="btnCancel" value="Cancel" onclick="location='Events.php'" class="btn btn-primary rounded-0 py-2 px-4" style="background-color: red; color: white;" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>