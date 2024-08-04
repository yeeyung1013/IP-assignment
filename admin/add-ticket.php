<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
$pageTitle = "Villian Add Ticket";
include './includes/dbConnector.php';
include './includes/check.php';


if (isset($_POST['btnSubmit'])){
    $eventName = isset($_POST['eventName']) ? trim($_POST['eventName']) : "";
    $ticketDate = isset($_POST['ticketDate']) ? trim($_POST['ticketDate']) : "";
    $ticketTime = isset($_POST['ticketTime']) ? trim($_POST['ticketTime']) : "";
    $totalSeat = isset($_POST['totalSeat']) ? trim($_POST['totalSeat']) : "";
    $goldPrice = isset($_POST['goldPrice']) ? trim($_POST['goldPrice']) : "";
    $silverPrice = isset($_POST['silverPrice']) ? trim($_POST['silverPrice']) : "";
    $bronzePrice = isset($_POST['bronzePrice']) ? trim($_POST['bronzePrice']) : "";
    
    $errMsgEventName = validateEventName($eventName);
    $errMsgTicketDate = validateTicketDate($ticketDate);
    $errMsgTicketTime = validateTicketTime($ticketTime);
    $errMsgTotalSeat = validateTotalSeat($totalSeat);
    $errMsgGPT = validateGPT($goldPrice);
    $errMsgSPT = validateSPT($silverPrice);
    $errMsgBPT = validateBPT($bronzePrice);
    
    $finalErrorMessage = array_merge($errMsgBPT, array_merge($errMsgSPT,array_merge($errMsgGPT ,array_merge($errMsgTotalSeat, array_merge($errMsgTicketTime, 
            array_merge(array_merge($errMsgEventName, $errMsgTicketDate)))))));
    if(count($finalErrorMessage) > 0){
        echo "<div class='error'>";
        echo "<ul>";
        foreach ($finalErrorMessage as $message) {
            echo "<li>$message</li>";
        }
         echo "</ul>";
        echo "</div>";
    } else {
        
        $insertCommand ="INSERT INTO ticket(EventName, TicketDate, TicketTime, TotalSeat, goldprice, silverprice,bronzeprice) VALUES 
                ('$eventName','$ticketDate','$ticketTime','$totalSeat','$goldPrice','$silverPrice','$bronzePrice')";
        
        $result = mysqli_query($dbConnection, $insertCommand);
        
        echo "<div class='question'>";
        echo "New Ticket has been inserted successfully!";
        echo "</div>";
    }
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

<head lang="en">
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>Villain Add Ticket</title>
</head>
   
<body>
 <div class = "block">

<form method="POST" action="">
    <h2>ADD TICKET</h2>
         <div class = "inputBox">
          <h1>EVENT NAME</h1>
          <input name="eventName" type="text" maxlength="40" required="required"/>
          <i></i>
         </div>
        <div class ="box"> 
          <h1>TICKET DATE 📅</h1>
             <input type="date" name="ticketDate" required="true"/>
        </div>
        <div class ="box"> 
         <h1>TICKET TIME ⌚</h1>
             <input type="time" name="ticketTime"  required="true"/>
        </div>
        <div class= "inputBox"> 
       <h1>TOTAL SEAT 💺</h1>
            <input name="totalSeat" type="type" maxlength="11" required="true"/>
            <i></i>
        </div>
        <div class="inputBox"> 
        <h1>GOLD TICKET PRICE (RM) 🎫</h1>
           <input type="type" name="goldPrice" required="true"/>
           <i></i>
        </div>
        <div class="inputBox"> 
        <h1>SILVER TICKET PRICE (RM) 🎫</h1>
            <input type="type" name="silverPrice" required="true"/>
            <i></i>
        </div>
        <div class="inputBox"> 
           <h1>BRONZE TICKET PRICE (RM) 🎫</h1>
            <input type="type" name="bronzePrice" required="true"/>
            <i></i>
        </div>

    <input type="submit" name="btnSubmit" value="Add"/>
    <input type="reset" name="btnCancel" value="Back To Ticket List" onclick="location='ticket.php'"/>
  
</form>
</div>
    
</body>

    