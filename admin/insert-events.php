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
    $eventId = isset($_POST['eventId']) ? trim($_POST['eventId']) : "";
    $eventName = isset($_POST['eventName']) ? trim($_POST['eventName']) : "";
    $description = isset($_POST['description']) ? trim($_POST['description']) : "";
    $startDate = isset($_POST['startDate']) ? trim($_POST['startDate']) : "";
    $seat = isset($_POST['seat']) ? trim($_POST['seat']) : "";
    
    $errMsgId = validateId($eventId);
    $errMsgName = validateTitle($eventName);
    $errMsgDescription = validateDescription($description);
    $errMsgStartDate = validateStartDate($startDate);
    $errMsgSeat = validateSeat($seat);
    
    $finalErrorMessage = array_merge($errMsgSeat ,array_merge($errMsgStartDate, array_merge($errMsgDescription, 
            array_merge(array_merge($errMsgId, $errMsgName)))));
    if(count($finalErrorMessage) > 0){
        echo "<ul>";
        foreach ($finalErrorMessage as $message) {
            echo "<li>$message</li>";
        }
    } else {
        $dbConnection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        $insertCommand ="INSERT INTO villain(EventID, EventName, Description, StartDate) VALUES "
                . "('$eventId','$eventName','$description','$startDate')";
        
        $result = mysqli_query($dbConnection, $insertCommand);

        echo "New Events has been inserted successfully. [<a href='Events.php'>Event List</a>]";
    }
}
?>
<head lang="en">
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <title>Villain Society Insert Events Form</title>
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
  <a href="Events.php">Go Back</a>
  </li>
</ul>
<body>
      <h1>Insert Events Information</h1>
      <p><b>Thank you for using this page to create the new events and Please follow the rule to create the new events information.
         <br/>
         If you got any problem in create the information Please follow this rule.<br/>
         1.)The Events ID cant more than 11 number.<br/>
         2.)The Events Name cant more than 40 character.<br/>
         3.)The Description cant enter more than 500 character include the special character such as @.<br/>
         If you still cant insert the new events information you can try to this contact number.<br/>
         Our admin Gary-<a href="tel:+014973977">(014) 973-3977</a>.</b></p>
<form method="POST" action="">
         <div>
         <label for="eventNameBox">Event Name</label>
            <input name="eventName" id="eventNameBox" type="text" maxlength="40" placeholder="Events Name" required/>
         </div>
         <div>
         <label for="seatNumBox">Seat Number</label>
            <input name="seat" id="seatNumBox" type="number" maxlength="11" placeholder="" required/>
         </div>
         <fieldset id="descriptionBox">
            <label>Description</label>
            <textarea name="description" id="descriptionBox" maxlength="500" placeholder="Description" required="true">
            </textarea>
            <div>
               <label for="dateBox">Start Date</label>
               <input type="date" name="startDate"  id="dateBox" required="true"/>
            </div>
        </fieldset>
    <input type="submit" name="btnSubmit" value="Insert"/>
    <input type="reset" name="btnCancel" value="Cancel" onclick="location='Events.php'"/>
</form>
</body>
    