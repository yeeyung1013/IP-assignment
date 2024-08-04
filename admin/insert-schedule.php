<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
$pageTitle = "Insert Events";
include './includes/dbConnector.php';
include './includes/helpers.php';

if (isset($_POST['btnSubmit'])){
    $id = isset($_POST['id']) ? trim($_POST['id']) : "";
    $eventId = isset($_POST['eventId']) ? trim($_POST['eventId']) : "";
    $date = isset($_POST['date']) ? trim($_POST['date']) : "";
    $time = isset($_POST['time']) ? trim($_POST['time']) : "";
    $goldprice = isset($_POST['goldprice']) ? trim($_POST['goldprice']) : "";
    $silverprice = isset($_POST['silverprice']) ? trim($_POST['silverprice']) : "";
    $bronzeprice = isset($_POST['bronzeprice']) ? trim($_POST['bronzeprice']) : "";
    
    $errMsgSeheduleId = validateScheduleId($id);
    $errMsgScheduleEventId=validateScheduleEventId($eventId);
    $errMsgDate = validateDate($date);
    $errMsgTime = validateTime($time);
    $errMsgGPT= validateGPT($goldprice);
    $errMsgSPT= validateSPT($silverprice);
    $errMsgMPT= validateMPT($bronzeprice);
    
    $finalErrorMessage = array_merge($errMsgGPT, array_merge($errMsgSPT, array_merge($errMsgMPT,
            array_merge($errMsgSeheduleId ,array_merge($errMsgScheduleEventId, array_merge($errMsgDate, 
            array_merge(array_merge($errMsgTime))))))));
    if(count($finalErrorMessage) > 0){
        echo "<ul>";
        foreach ($finalErrorMessage as $message) {
            echo "<li>$message</li>";
        }
    } else {
        $dbConnection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        $insertCommand ="INSERT INTO schedule(id,EventID, date, time, goldprice,silverprice,bronzeprice) VALUES "
                . "('$id','$eventId','$date','$time','$goldprice','$silverprice','$bronzeprice')";
        
        $result = mysqli_query($dbConnection, $insertCommand);
        
        echo "New Events Schedule has been inserted successfully.[<a href='schedule.php'>Schedule List</a>]";
    }
}
?>
<head lang="en">
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <title>Villain Society Insert Events Schedule Form</title>
</head>
<style>

input:focus, select:focus, textarea:focus {
   background-color: rgb(255, 255, 180);
}
fieldset {
   background-color: rgb(234, 189, 142);
   -webkit-flex: 1 1 300px;
   flex: 1 1 300px; 
   margin: 10px;  
}

div {
   margin: 5px;
   width: 100%;
}

legend {
   color: rgb(255, 200, 200);
   background-color: rgb(179, 20, 25);
}

label {
   display: inline-block;
   width: 120px;
}

fieldset#pickupInfo label, fieldset#deliveryInfo label {
   margin-bottom: 10px;
   width: 100%;
}

textarea {
   display: block;
   width: 90%;
   height: 100px;
}

input[type="submit"],
input[type="reset"]{
   height: 50px;
   width: 200px;
}

input#sizeBox {
   width: 240px;
}
body{
    background-image:  url("./image/me-gaming.gif");
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
}
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}

li {
  float: left;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover {
  background-color: #111;
}
</style>
<ul>
  <li>
  <a href="schedule.php">Go Back</a>
  </li>
</ul>
<body>
      <h1>Insert Events Schedule Information</h1>
      <p><b>Thank you for using this page to create the new events schedule and Please follow the rule to create the new events schedule information.
         <br/>
         If you got any problem in create the information Please follow this rule.<br/>
         1.)The Schedule ID only can enter number cant accept the Alphabetic.<br/>
         2.)The Events ID cant more than 11 number.<br/>
         3.)The Gold,Silver,Bronze Ticket Price only can enter number , cant enter the Alphabetic and Special character such as @.<br/>
         If you still cant insert the new events schedule information you can try to this contact number.<br/>
         Our admin Gary-<a href="tel:+014973977">(014) 973-3977</a>.</b></p>
<form method="POST" action="">
          <div>
         <label for="SIdBox">Schedule ID:</label>
            <input name="id" id="SIdBox" type="text" maxlength="11" placeholder="" required/>
         </div>
         <div>
         <label for="SEventIdBox">Events ID:</label>
            <input name="eventId" id="eventIdBox" type="text" maxlength="11" placeholder="" required/>
         </div>
          <div>
               <label for="dateBox">Date:</label>
               <input type="date" name="date"  id="dateBox" required="true"/>
          </div>
          <div>
               <label for="timeBox">Time:</label>
               <input type="time" name="time"  id="timeBox" required="true"/>
          </div>
          <div>
               <label for="goldBox">Gold Ticket &#128184;</label>
               <input type="type" name="goldprice"  id="goldBox" required="true"/>
          </div>
          <div>
               <label for="sliverBox">Sliver Ticket &#128184;</label>
               <input type="type" name="silverprice"  id="sliverBox" required="true"/>
          </div>
          <div>
               <label for="bronzeBox">Bronze Ticket &#128184;</label>
               <input type="type" name="bronzeprice"  id="bronzeBox" required="true"/>
          </div>
    <input type="submit" name="btnSubmit" value="Insert"/>
    <input type="reset" name="btnCancel" value="Cancel" onclick="location='schedule.php'"/>
</form>
</body>
    