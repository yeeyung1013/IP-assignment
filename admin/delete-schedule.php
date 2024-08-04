<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<?php
$pageTitle = "Delete schedule";

include './includes/dbConnector.php';
include './includes/helpers.php';


if(isset($_GET['id'])){
    $eventId = trim($_GET['id']);
    
   //var_dump($studId); for check the data is correct or not 
    
    $dbConnection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    $selectCommand = "SELECT * FROM schedule WHERE EventID = '$eventId'";
    
    $result = mysqli_query($dbConnection, $selectCommand);
    
    
   if ($result->num_rows==1){
        $schedule = mysqli_fetch_object($result);
        
        //var_dump($student);
        
        $eventId = $schedule->EventID;
        $date = $schedule->date;
        $time = $schedule->time;
        $goldprice = $schedule->goldprice;
        $silverprice = $schedule->silverprice;
        $bronzeprice = $schedule->bronzeprice;
    }
}

if (isset($_POST['btnSubmit'])){
    global $eventId;
    
    $deleteCommand = "DELETE FROM schedule WHERE EventID = '$eventId'";
    
    $result = mysqli_query($dbConnection, $deleteCommand);
    
    echo "<div class='question'>";
        echo "This Event Schedule has been delete successfully. [<a href='schedule.php'>All Event Schedule List</a>]";
        echo "</div>";
}

?>

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

.box{
    position: relative;
    width: 300px;
    margin-top: 50px;
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
    color: white;
    background-color: black;
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
    <h2>DELETE SCHEDULE</h2>
    <form method="POST" action="">
    <div class="box">
    <h1>Events ID:</h1>
    </br>
            <p><?php global $eventId; echo $eventId;?></p>
    </div>  
    <div class="box">
            <h1>Golden Ticket Price Details:</h1>
            </br>
            <p><?php global $goldprice; echo $goldprice;?></p>
   </div>
   <div class="box">
            <h1>Silver Ticket Price Details:</h1>
            </br>
            <p><?php global $silverprice; echo $silverprice;?></p>
    </div>
    <div class="box">
            <h1>Bronze Ticket Price Details:</h1>
            </br>
           <p><?php global $bronzeprice; echo $bronzeprice;?></p>
    </div>
            <div class="box">
               <h1>Events Date:</h1>
               </br>
            <p><?php global $date; echo $date;?></p>
    </div>
             <div class="box">
               <h1>Events Time:</h1>
               </br>
              <p><?php global $time; echo $time;?></p>
    </div>  
    <input type="submit" name="btnSubmit" value ="Yes"/>
    <input type="reset" name="btnCancel" value ="Cancel" 
       onclick="location='schedule.php'"/>
</form>
</div>
</body>
