<?php
 $pageTitle = "Edit Events";

// Moved header code to header.php
// If any changes required in the future, only need to make it in one file.
include './includes/dbConnector.php';
include './includes/helpers.php';

if(isset($_GET['id'])){
    $eventId = trim($_GET['id']);
    
    $dbConnection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    $selectCommand = "SELECT * FROM villain WHERE EventID = '$eventId'";
    
    $result = mysqli_query($dbConnection, $selectCommand);
    
    
    if ($result->num_rows==1){
        $villain = mysqli_fetch_object($result);
        
        //var_dump($student);
        
        $eventId = $villain->EventID;
        $eventName = $villain->EventName;
        $description = $villain->Description;
        $startDate = $villain->StartDate;
        $seat = $villain->Seat;
    }
}
if (isset($_POST['btnSubmit'])){
    $eventName = isset($_POST['eventName']) ? trim($_POST['eventName']) : "";
    $description = isset($_POST['description']) ? trim($_POST['description']) : "";
    $startDate = isset($_POST['startDate']) ? trim($_POST['startDate']) : "";
    $seat = isset($_POST['seat']) ? trim($_POST['seat']) : "";
    
    $errMsgName = validateTitle($eventName);
    $errMsgDescription = validateDescription($description);
    $errMsgStartDate = validateStartDate($startDate);
    $errMsgSeat = validateSeat($seat);
    
//    $finalErrorMessages = array_merge(array_merge($errMsgName, $errMsgDescription), $errMsgStartDate);
    $finalErrorMessage = array_merge($errMsgSeat,array_merge($errMsgStartDate, array_merge($errMsgDescription, array_merge($errMsgName))));
    
    if (count($finalErrorMessages) > 0){
        echo "<div class='error'>";
        echo "<ul>";
        foreach ($finalErrorMessages as $message) {
            echo "<li>$message</li>";
        }
        echo "</ul>";
        echo "</div>";
    }
        else{
        $updateCommand = "UPDATE villain SET EventName='$eventName',Description='$description',StartDate='$startDate',Seat='$seat' WHERE EventID = '$eventId'";
        
        $result = mysqli_query($dbConnection, $updateCommand);
        
        echo "<div class='question'>";
        echo "Events has been update successfully. [<a href='Events.php'>Event List</a>]";
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
.box textarea{
    position: relative;
    width: 500px;
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

.box textarea:valid ~ h1,
.box textarea:focus ~ h1
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
  <a href="Events.php">Go Back</a>
  </li>
</ul>
<body>
     <div class="block">
     <h2>EDIT EVENT</h2>
<form method="POST" action="">
    <div class="box">
    <h1>Events ID:</h1>
    </br>
            <p><?php global $eventId; echo $eventId;?></p>
    </div>
    
    <div class ="box">
    <h1>Event Name:</h1>
            <input name="eventName" id="eventNameBox" type="text" maxlength="40" placeholder="Events Name" required 
                   value="<?php global $eventName; echo $eventName;?>"/>
            <i></i>
    </div>
    
     <div class ="box">
    <h1>Seat Number:</h1>
            <input name="seat" id="seatBox" type="text" maxlength="10" placeholder="" required 
                   value="<?php global $seat; echo $seat;?>"/>
             <i></i>
    </div> 
    
    <div class="box">
    <h1>Description:</h1>
<textarea name="description" id="descriptionBox" maxlength="500" placeholder="Description" required="true" 
                      value="<?php global $description; echo $description;?>">
</textarea>
    </div>
    
     <div class="box">
     <h1>Start Date:</h1>
     <input type="date" name="startDate"  id="dateBox" required="true" 
       value="<?php global $startDate; echo $startDate;?>"/>
      </div> 
    
    <input type="submit" name="btnSubmit" value="Update"/>
    <input type="reset" name="btnCancel" value="Cancel"
           onclick="location='Events.php'"/>
</form>
     </div>
</body>

