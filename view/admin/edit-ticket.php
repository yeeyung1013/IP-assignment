<?php
/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 * @author Tan Chee Fung
 */
 $pageTitle = "Edit Ticket";

require 'databaseconnect.php';
require '../../controller/TicketController.php';
require '../../securePractice/TicketInputValidator.php';
require '../../SecurePractice/OutputEncoding.php';

$ticketController = new TicketController($pdo);
$validator = new TicketInputValidator($pdo); 

$errors = []; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = $validator->validateTicketInput($_POST, true); 
    $schedule_id = $_POST['schedule_id'];
    $usedSlots = $ticketController->getUsedSlots($schedule_id);
    $eventSeats = $ticketController->getEventSeats($schedule_id);
    $availableSlots = $eventSeats - $usedSlots;

    if ($_POST['slot'] > $availableSlots) {
        $errors[] = "Slots are not enough! Available Seats: $availableSlots.";
    }

    if (empty($errors)) {
        $ticket_id = $_POST['ticket_id'];
        $ticket = $ticketController->read($ticket_id);
        
        if (!$ticket) {
            $errors[] = "Ticket not found.";
        } else {
            $data = [
                'ticket_id' => $ticket_id,
                'price' => !empty($_POST['price']) ? $_POST['price'] : $ticket->getPrice(),
                'schedule_id' => $schedule_id,
                'image' => !empty($_FILES['image']['name']) ? $_FILES['image']['name'] : $ticket->getImage(),
                'slot' => !empty($_POST['slot']) ? $_POST['slot'] : $ticket->getSlot(),
                'slot_sold' => !empty($_POST['slot_sold']) ? $_POST['slot_sold'] : $ticket->getSlotSold(),
                'category' => $ticket->getCategory() 
            ];

            $ticketController->update($data);
            header("Location: ticket.php?schedule_id=" . $schedule_id);
            exit;
        }
    }
} else {
    $ticket_id = $_GET['ticket_id'];
    $ticket = $ticketController->read($ticket_id);
    if (!$ticket) {
        die("Ticket not found.");
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

.question{
    color: white;
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
   <title>Villain Edit Ticket</title>
</head>

<body>
 <div class="block">
     <h2>EDIT TICKET</h2>
     <?php if (!empty($errors)): ?>
        <div style="color: red;">
            <strong>Error(s):</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
<form method="POST" action="edit-ticket.php" enctype="multipart/form-data">
    <table>
      <div class = "inputBox">
          <h1>PRICE(RM) 🎫</h1>
          <input type="text" name="price" value="<?php echo htmlspecialchars($ticket->getPrice()); ?>" required>
          <i></i>
         </div>
        <div class ="box"> 
          <h1>TICKET IMAGE📅</h1>
             <input type="file" name="image">
        </div>
        
        <div class="box"> 
        <h1>CATEGORY</h1>
            <input type="text" name="category" value="<?php echo htmlspecialchars($ticket->getCategory()); ?>" readonly>
            <i></i>
        </div>
    <div class= "inputBox"> 
       <h1>TOTAL SEAT 💺</h1>
            <input type="number" name="slot" value="<?php echo htmlspecialchars($ticket->getSlot()); ?>" required>
            <i></i>
        </div>
    </table>
    <input type="hidden" name="ticket_id" value="<?php echo htmlspecialchars($ticket->getTicketId()); ?>">
    <input type="hidden" name="schedule_id" value="<?php echo OutputEncoding::encodeHtml($_GET['schedule_id']); ?>">
    <input type="number" name="slot_sold" value="<?php echo htmlspecialchars($ticket->getSlotSold()); ?>" hidden>
    <input type="submit" name="btnSubmit" value="Edit Ticket"/>
    <input type="reset" name="btnCancel" value="Back To Ticket List" onclick="window.location.href='ticket.php?schedule_id=<?php echo $_GET['schedule_id']; ?>'"/>
</form>
    </div>
</body>

