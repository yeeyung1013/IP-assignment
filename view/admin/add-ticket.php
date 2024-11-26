<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 * @author Tan Chee Fung
 */
$pageTitle = "Villian Add Ticket";
require 'databaseconnect.php';
require '../../controller/TicketController.php';
require '../../SecurePractice/TicketInputValidator.php';
require '../../SecurePractice/OutputEncoding.php';

$ticketController = new TicketController($pdo);
$validator = new TicketInputValidator($pdo);
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = $validator->validateTicketInput($_FILES + $_POST);
    
    $schedule_id = $_POST['schedule_id'];
    $usedSlots = $ticketController->getUsedSlots($schedule_id);
    $eventSeats = $ticketController->getEventSeats($schedule_id);
    $availableSlots = $eventSeats - $usedSlots;
    if ($_POST['slot'] > $availableSlots) {
        $errors[] = "Slots are not enough! Available Seats: $availableSlots.";
    }
    if (empty($errors)) {
        $uploadDir = '../uploads/';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile);

        $ticketController->create([
            'price' => $_POST['price'],
            'schedule_id' => $_POST['schedule_id'],
            'image' => $_FILES['image']['name'],
            'slot' => $_POST['slot'],
            'slot_sold' => 0, // Set default value for slot_sold
            'category' => $_POST['category'],
        ]);
        header("Location: ticket.php?schedule_id=" . $_POST['schedule_id']);
        exit;
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

.selectBox {
    position: relative;
    width: 500px; 
    margin-top: 50px; 
}

.selectBox select {
    position: relative;
    width: 100%;
    padding: 20px 10px; 
    background: transparent;
    border: none;
    outline: none;
    color: #000; 
    font-size: 1em;
    letter-spacing: 0.05em;
    appearance: none; 
    border-bottom: 2px solid #45f3ff; 
    margin-bottom: 10px; 
}

.selectBox h1 {
    position: absolute;
    left: 0;
    padding: 3px 3px 3px;
    font-size: 1em;
    color: #FFFFFF; 
    pointer-events: none;
    letter-spacing: 0.05em;
    transition: 0.5s;
}

.selectBox select:focus ~ h1,
.selectBox select:not(:placeholder-shown) ~ h1 {
    color: #000;
    transform: translateY(-34px);
    font-size: 0.75em;
}

.selectBox::after {
    content: '▼'; 
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #000; 
    pointer-events: none; 
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

<form method="POST" action="" enctype="multipart/form-data">
    <h2>ADD TICKET</h2>
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
         <div class = "inputBox">
          <h1>PRICE(RM) 🎫</h1>
          <input type="text" name="price" required>
          <i></i>
         </div>
        <div class ="box"> 
          <h1>TICKET IMAGE📅</h1>
             <input type="file" name="image" required>
        </div>
        
        <div class="selectBox"> 
        <h1>CATEGORY</h1>
            <select name="category" style="color: #00ffff;" required>
            <option value="Standard">Standard</option>
            <option value="VIP">VIP</option>
            <option value="VVIP">VVIP</option>
            <option value="SuperVIP">SuperVIP</option>
            </select>
            <i></i>
        </div>
    <div class= "inputBox"> 
       <h1>TOTAL SEAT 💺</h1>
            <input type="number" name="slot" required>
            <i></i>
        </div>
    <input type="number" name="slot_sold" value="0" hidden>
    <input type="hidden" name="schedule_id" value="<?php echo OutputEncoding::encodeHtml($_GET['schedule_id']); ?>">
    <input type="submit" name="btnSubmit">Add Ticket</input>
    <input type="reset" name="btnCancel" value="Back To Ticket List" onclick="window.location.href='ticket.php?schedule_id=<?php echo $_GET['schedule_id']; ?>'"/>
</form>
</div>
    
</body>

    