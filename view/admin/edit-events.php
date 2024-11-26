<?php
 $pageTitle = "Edit Events";

include './includes/dbConnector.php';
include '../../controller/helpers.php';
include '../../model/event.php';

$dbConnection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($dbConnection->connect_error) {
    die("Connection failed: " . $dbConnection->connect_error);
}

$event = new Event($dbConnection);

if (isset($_GET['id'])) {
    $eventId = trim($_GET['id']);
    
    $villain = $event->getEventById($eventId);

    if ($villain) {
        $eventId = $villain->EventID;
        $eventName = $villain->EventName;
        $location = $villain->location;
        $description = $villain->Description;
        $startDate = $villain->StartDate;
        $seat = $villain->Seat;
    } else {
        echo "<div class='question'>Event not found.</div>";
    }
}

if (isset($_POST['btnSubmit'])) {
    $eventName = isset($_POST['eventName']) ? trim($_POST['eventName']) : "";
    $location = isset($_POST['location']) ? trim($_POST['location']) : "";
    $description = isset($_POST['description']) ? trim($_POST['description']) : "";
    $startDate = isset($_POST['startDate']) ? trim($_POST['startDate']) : "";
    $seat = isset($_POST['seat']) ? trim($_POST['seat']) : "";
    
    $errMsgName = validateTitle($eventName);
    $errMsgDescription = validateDescription($description);
    $errMsgStartDate = validateStartDate($startDate);
    $errMsgSeat = validateSeat($seat);
    
    $finalErrorMessage = array_merge($errMsgSeat, array_merge($errMsgStartDate, array_merge($errMsgDescription, $errMsgName)));

    if (count($finalErrorMessage) > 0){ 
        echo "<div class='error'>";
        echo "<ul>";
        foreach ($finalErrorMessage as $message) {
            echo "<li>$message</li>";
        }
        echo "</ul>";
        echo "</div>";
    } else {
        $event->setEvent($eventId, $eventName,$location, $description, $startDate, $seat);
        
        if ($event->updateEvent()) {
            echo "<script type='text/javascript'>
             alert('Events has been updated successfully. ');
             window.location.href = 'Events.php';
            </script>";
        } else {
            echo "<script>alert('Failed to update the event.');</script>";
        }
    }
}

$dbConnection->close();
?>

<head lang="en">
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <title>Edit Events Form</title>
   <link rel="stylesheet" href="../../assets/css/admin/bootstrap.min.css">
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

    textarea.form-control {
    min-height: 100px;
    padding: 10px;
    width: 1050px;
    font-size: 16px;
    line-height: 1.5;
    resize: none; 
    border: none;
    border-bottom: 1px solid #ccc;
    padding-left: 0;
    padding-right: 0;
    border-radius: 0;
    background: #f2f2f2;
}

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
</style>
  <a href="Events.php" class="previous">&laquo;</a>
<body>
     <div class="content">
     <div class="container">
    <div class="row align-items-stretch no-gutters contact-wrap">
        <div class="form h-100">
          <h3>Edits events information</h3>
    <form method="POST" class="mb-5">
    <div class="row">
        <div class="col-md-6 form-group mb-5">
            <label for="box" class="col-form-label">Events ID</label>
            <p class="form-control"><?php global $eventId; echo $eventId;?></p>
        </div>

    <div class="col-md-6 form-group mb-5">
            <label for="seatNumBox" class="col-form-label">Events Name</label>
            <input class="form-control" name="eventName" id="eventNameBox" type="text" maxlength="40" placeholder="Events Name" required 
                   value="<?php global $eventName; echo $eventName;?>"/>
        </div>

    <div class="col-md-6 form-group mb-5">
            <label for="seatBox" class="col-form-label">Seat Number</label>
            <input class="form-control" name="seat" id="seatBox" type="text" maxlength="10" placeholder="" required 
                   value="<?php global $seat; echo $seat;?>"/>
        </div>

    <div class="col-md-6 form-group mb-5">
            <label for="dateBox" class="col-form-label">Start Date</label>
            <input class="form-control" type="date" name="startDate"  id="dateBox" required="true" 
       value="<?php global $startDate; echo $startDate;?>"/>
        </div>
        <div class="col-md-6 form-group mb-5">
                    <label for="locationBox" class="col-form-label">Event Location</label>
                    <input class="form-control" name="location" id="locationBox" required  value="<?php global $location; echo $location;?>"/>
                </div>
    <div class="row">
        <div class="col-md-12 form-group mb-5">
            <label for="descriptionBox" class="col-form-label">Description</label>
            <textarea class="form-control" name="description" id="descriptionBox" maxlength="500" required="true" 
                      value="<?php global $description; echo $description;?>">
</textarea>
        </div>
    </div>
    <div class="col-md-12 text-center form-group">
        <input type="submit" name="btnSubmit" value="Update" class="btn btn-primary rounded-0 py-2 px-4" style="background-color: green; color: white;" />
        <input type="reset" name="btnCancel" value="Cancel" onclick="location='Events.php'" class="btn btn-primary rounded-0 py-2 px-4" style="background-color: red; color: white;" />
    </div>
</form>
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


