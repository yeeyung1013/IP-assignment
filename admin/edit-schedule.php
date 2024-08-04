<?php
 $pageTitle = "Edit Schedule";

// Moved header code to header.php
// If any changes required in the future, only need to make it in one file.
include './includes/dbConnector.php';
include './includes/helpers.php';

if(isset($_GET['id'])){
    $id = trim($_GET['id']);
    
    $dbConnection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    $selectCommand = "SELECT * FROM schedule WHERE id = '$id'";
    
    $result = mysqli_query($dbConnection, $selectCommand);
    
    
    if ($result->num_rows==1){
        $schedule = mysqli_fetch_object($result);
        
        //var_dump($student);
        $id = $schedule->id;
        $eventId = $schedule->EventID;
        $date = $schedule->date;
        $time = $schedule->time;
//        $goldprice = $schedule->goldprice;
//        $silverprice = $schedule->silverprice;
//        $bronzeprice = $schedule->bronzeprice;
    }
}
if (isset($_POST['btnSubmit'])){
    $eventId = isset($_POST['eventId']) ? trim($_POST['eventId']) : "";
    $date = isset($_POST['date']) ? trim($_POST['date']) : "";
    $time = isset($_POST['time']) ? trim($_POST['time']) : "";
//    $goldprice = isset($_POST['goldprice']) ? trim($_POST['goldprice']) : "";
//    $silverprice = isset($_POST['silverprice']) ? trim($_POST['silverprice']) : "";
//    $bronzeprice = isset($_POST['bronzeprice']) ? trim($_POST['bronzeprice']) : "";
    
    $errMsgScheduleEventId = validateScheduleEventId($eventId);
    $errMsgDate = validateDate($date);
    $errMsgTime = validateTime($time);
//    $errMsgGPT = validateGPT($goldprice);
//    $errMsgSPT =  validateSPT($silverprice);
//    $errMsgMPT = validateMPT($bronzeprice);
    
//    $finalErrorMessages = array_merge(array_merge($errMsgName, $errMsgDescription), $errMsgStartDate);
     $finalErrorMessage = array_merge($errMsgMPT, array_merge($errMsgSPT, array_merge($errMsgGPT, array_merge($errMsgTime, array_merge($errMsgScheduleEventId,$errMsgDate)))));
    
    if (count($finalErrorMessage) > 0){
        echo "<div class='error'>";
        echo "<ul>";
        foreach ($finalErrorMessage as $message) {
            echo "<li>$message</li>";
        }
        echo "</ul>";
        echo "</div>";
    }
        else{
        /**$updateCommand = "UPDATE schedule SET EventID='$eventId',date='$date',time='$time',goldprice='$goldprice',silverprice='$silverprice'"
                . ",bronzeprice='$bronzeprice' WHERE id = '$id'";**/
        $updateCommand = "UPDATE schedule SET EventID='$eventId',date='$date',time='$time' WHERE id = '$id'";
        $result = mysqli_query($dbConnection, $updateCommand);
        
        echo "<div class='question'>";
        echo "The Schedule Events has been update successfully. [<a href='Events.php'>Event List</a>]";
        echo "</div>";
    }
}

?>
<head lang="en">
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <title>Gaming X Society Edit Events Form</title>
</head>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

*
{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}
body{
    margin:0;
    padding:0;
    background-color: #1c1c1c;
}
.block{
    position: relative;
    margin:5% auto 0;
    width: 70%;
    height: 400px auto;
    background: linear-gradient(0deg, black, rgb(44,43,43));
    padding: 50px 40px;
    display: flex;
    flex-direction: column;
}

.block::before, .block::after
{
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    width: calc(100% + 5px);
    height: calc(100% + 5px);
    background: linear-gradient(45deg, #e6fb04, #ff6600, #00ff66, #00ffff,
    #ff00ff, #ff0099, #6e0dd0, #ff3300, #099fff);
    background-size: 200%;
    animation: animate 20s linear infinite;
    z-index: -1;
}

h2{
    color: #45f3ff;
    font-weight: 800;
    font-size: 35px;
    text-align: center;
    letter-spacing: 0.1em;
}

.inputBox{
    position: relative;
    width: 300px;
    margin-top: 50px;
}

.inputBox input{
    position: relative;
    width: 500px;
    padding: 20px 10px 10px;
    background: transparent;
    border: none;
    outline: none;
    color: #23242a;
    font-size: 1em;
    letter-spacing: 0.05em;
    z-index: 10;
    margin-top: 20px;
    color: black;
}

.inputBox h1{
    position: absolute;
    left: 0;
    padding: 3px 3px 3px;
    font-size: 1em;
    color: #FFFFFF; 
    pointer-events: none;
    letter-spacing: 0.05em;
    transition: 0.5s;
}

.inputBox input:valid ~ h1,
.inputBox input:focus ~ h1
{
    color: #45f3ff;
    transform: translateY(-34px);
    font-size: 0.75em;
}

.inputBox i{
    position: absolute;
    left: 0;
    bottom: 0;
    width: 400px;
    height: 2px;
    background: #45f3ff;
    border-radius: 4px;
    transition: 0.5s;
    pointer-events: none;
    z-index:9;
}

.inputBox input:valid ~i,
.inputBox input:focus ~i
{
   color: #45f3ff;
   height: 40px;
}

.box{
    position: relative;
    width: 300px;
    margin-top: 50px;
}

.box input{
    position: relative;
    width: 100%;
    padding: 20px 10px 10px;
    background: #45f3ff;
    border: none;
    outline: none;
    color: #23242a;
    font-size: 1em;
    letter-spacing: 0.05em;
    z-index: 10;
    margin-top: 35px;
    color: black;
}

.box h1{
    position: absolute;
    left: 0;
    padding: 3px 3px 3px;
    font-size: 1em;
    color: #FFFFFF; 
    pointer-events: none;
    letter-spacing: 0.05em;
    transition: 0.5s;

}

.box input:valid ~ h1,
.box input:focus ~ h1
{
    color: #45f3ff;
    transform: translateY(-34px);
    font-size: 0.75em;
}

.box p{
    position: relative;
    width: 500px;
    padding: 20px 10px 10px;
    background: transparent;
    border: none;
    outline: none;
    color: #23242a;
    font-size: 1em;
    letter-spacing: 0.05em;
    z-index: 10;
    margin-top: 20px;
    color: black;
    background-color: #45f3ff;
}

input[type="submit"]{
    border: none;
    outline: no;
    background: #45f3ff;
    padding: 11px 25px;
    width:300px;
    margin-top: 30px;
    border-radius: 4px;
    font-weight: 600;
    margin-left: 30px;
}

input[type="reset"]{
    border: none;
    outline: no;
    background: #45f3ff;
    padding: 11px 25px;
    width:300px;
    margin-top: 10px;
    border-radius: 4px;
    font-weight: 600;
    margin-left: 30px;
}

@keyframes animate{
    0%{
       background-position: 0 0; 
    }
    50%{
       background-position: 400% 0; 
    }
    100%{
       background-position: 0 0; 
    } 
}
</style>
<ul>
  <li>
  <a href="schedule.php">Go Back</a>
  </li>
</ul>
<body>
  <div class="block">
     <h2>EDIT SCHEDULE</h2>  
<form method="POST" action="">
    <div class="box">
    <h1>Schedule ID:</h1>
    </br>
            <p><?php global $id; echo $id;?></p>
    </div>
    
    <div class="box">
    <h1>Event ID:</h1>
            <input name="eventId" id="eventIdBox" type="text" maxlength="40" placeholder="" required 
                   value="<?php global $eventId; echo $eventId;?>"/>
            <i></</i>
    </div> 
    
<!--    <div class="box">
            <h1>Golden Ticket Price:</h1>
            <input name="goldprice" id="goldpriceBox" maxlength="10" placeholder="" required="true" 
                      value="<?php global $goldprice; echo $goldprice;?>"/>
            <i></</i>
   </div>
    
   <div class="box">
            <h1>Silver Ticket Price:</h1>
            <input name="silverprice" id="silverpriceBox" maxlength="10" placeholder="" required="true" 
                      value="<?php global $silverprice; echo $silverprice;?>"/>
            <i></</i>
    </div>
    
    <div class="box">
            <h1>Bronze Ticket Price:</h1>
            <input name="bronzeprice" id="bronzepriceBox" maxlength="10" placeholder="" required="true" 
                      value="<?php global $bronzeprice; echo $bronzeprice;?>"/>
            <i></</i>
    </div>-->
    
            <div class="box">
               <h1>Events Date:</h1>
               <input type="date" name="date"  id="dateBox" required="true" 
                      value="<?php global $date; echo $date;?>"/>
               <i></</i>
    </div>
    
             <div class="box">
               <h1>Events Time:</h1>
               <input type="time" name="time"  id="timeBox" required="true" 
                      value="<?php global $time; echo $time;?>"/>
               <i></i>
    </div> 
    
    <input type="submit" name="btnSubmit" value="Update"/>
    <input type="reset" name="btnCancel" value="Cancel"
           onclick="location='schedule.php'"/>
</form>
  </div>
</body>