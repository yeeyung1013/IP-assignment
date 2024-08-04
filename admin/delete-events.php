<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<?php
$pageTitle = "Delete event";

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
    global $eventId;
    
    $deleteCommand = "DELETE FROM villain WHERE EventID = '$eventId'";
    
    $result = mysqli_query($dbConnection, $deleteCommand);
    
    echo "<div class='question'>";
        echo "This Event has been delete successfully. [<a href='Events.php'>All Event List</a>]";
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
  <a href="Events.php">Go Back</a>
  </li>
</ul>
<body>
    <div class="block">
        <h2>DELETE EVENTS</h2>
<form method="POST" action="">  
    <table border="1">
        <div class="box">
            <h1>Events ID:</h1>
            </br>
            <p><?php global $eventId; echo $eventId;?></p>
        </div>
        
        <div class="box">
            <h1>Events Name:</h1>
            </br>
            <p><?php global $eventName; echo $eventName;?></p>
        </div>
        
        <div class="box">
            <h1>Events Seat Number:</h1>
            </br>
            <p><?php global $seat; echo $seat;?></p>
        </div>
      
        <div class="box">
            <h1>Events Description:</h1>
            </br>
            <p><?php global $description; echo $description;?></p>
        </div>
        
        <div class="box">
            <h1>Events Start Date:</h1>
            </br>
            <p><?php global $startDate; echo $startDate;?></p>
        </div>
        
    </table>
    <br/>
    <input type="submit" name="btnSubmit" value ="Yes"/>
    <input type="reset" name="btnCancel" value ="Cancel" 
       onclick="location='Events.php'"/>
</form>
</body>