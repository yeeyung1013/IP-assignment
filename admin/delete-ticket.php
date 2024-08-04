<?php
 $pageTitle = "Delete Ticket";

// Moved header code to header.php
// If any changes required in the future, only need to make it in one file.
include './includes/dbConnector.php';
include './includes/check.php';

if(isset($_GET['id'])){
    $ticketId = trim($_GET['id']);
    
    $dbConnection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    $selectCommand = "SELECT * FROM ticket WHERE TicketID = '$ticketId'";
    
    $result = mysqli_query($dbConnection, $selectCommand);
    
    //var_dump($result);
    
    if ($result->num_rows==1){
        $ticket = mysqli_fetch_object($result);
        
        //var_dump($student);
        
        $ticketId = $ticket->TicketID;
        $eventName = $ticket->EventName;
        $ticketDate = $ticket->TicketDate;
        $ticketTime = $ticket->TicketTime;
        $totalSeat = $ticket->TotalSeat;
        $goldPrice = $ticket->goldprice;
        $silverPrice = $ticket->silverprice;
        $bronzePrice = $ticket->bronzeprice;
        
    }
}
if (isset($_POST['btnSubmit'])){
   global $ticketId;
    
    $deleteCommand = "DELETE FROM ticket WHERE TicketID = '$ticketId'";
    
    $result = mysqli_query($dbConnection, $deleteCommand);
    
    echo "<div class='question'>";
        echo "Ticket has been delete sucessfully. [<a href='ticket.php'>Tickets List</a>]";
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

<head lang="en">
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>Villain Delete Ticket</title>
</head>

<body>
<div class="block">
    <h2>DELETE TICKET</h2>
<form method="POST" action="">
    <table>
       <div class = "box">
       <h1>EVENT NAME</h1>
       </br>
       <p><?php global $eventName; echo $eventName;?></p>
         </div>
        <div class = "box"> 
          <h1>TICKET DATE 📅</h1>
           </br>
            <p><?php global $ticketDate; echo $ticketDate;?></p>
        </div>
        <div class = "box"> 
             <h1>TICKET TIME ⌚</h1>
              </br>
             <p><?php global $ticketTime; echo $ticketTime;?></p>
        </div>
        <div class = "box"> 
               <h1>TOTAL SEAT 💺</h1>
                </br>
            <p><?php global $totalSeat; echo $totalSeat;?></p>
        </div>
        <div class = "box"> 
                <h1>GOLD TICKET PRICE (RM) 🎫</h1>
                 </br>
           <p><?php global $goldPrice; echo $goldPrice;?></p>
        </div>
        <div class = "box"> 
             <h1>SILVER TICKET PRICE (RM) 🎫</h1>
              </br>
            <p><?php global $silverPrice; echo $silverPrice;?></p>
        </div>
        <div class = "box"> 
             <h1>BRONZE TICKET PRICE (RM) 🎫</h1>
              </br>
            <p><?php global $bronzePrice; echo $bronzePrice;?></p>
        </div>
    </table>
    <input type="submit" name="btnSubmit" value="Yes"/>
    <input type="reset" name="btnCancel" value="Back To Ticket List" onclick="location='ticket.php'"/>
</form>
</div>
</body>

