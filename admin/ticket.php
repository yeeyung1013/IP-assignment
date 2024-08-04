<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<?php
$pageTitle = "Ticket List";
include './includes/dbConnector.php';


if (isset($_POST['btnDelete'])){
    $ticketIds = $_POST['ticketIds'];
    
    foreach ($ticketIds as $ticketId) {
        $deleteCommand = "DELETE FROM ticket WHERE TicketID = '$ticketId'";
        mysqli_query($dbConnection, $deleteCommand);
    }
}
$selectCommand = "SELECT * FROM ticket";

$results = mysqli_query($dbConnection, $selectCommand);
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
table{
  border:1px solid #DDD;
  margin:auto;
  color:black;
  background-color: #333;
  width:2%;
}

th,td{
  padding:50px;
  margin:20px;
  color:cyan;
  background-color: black;
}
/*tr:hover {
    background-color: #D6EEEE;
}*/

.dropdown-menu > li > a:hover,
.dropdown-menu > li > a:focus {
  color: #262626;
  text-decoration: none;
  background-color: #66ccff; /*change color of links in drop down here*/
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

.help-block {
  color: red;
  font-size: 12px;
  margin: 0;
  padding: 0;
}

body {
  background: #ecf0f1; /* fallback for old browsers */
  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
/*  background-image:  url("./image/events bg.jpg");
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;*/
  background-color: #333;
}
.button {
  border-radius: 4px;
  background-color: black;
  color: #FFFFFF;
  text-align: center;
  font-size: 18px;
  padding: 20px;
  width: 200px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 5px;
}

.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.button:hover span {
  padding-right: 25px;
}

.button:hover span:after {
  opacity: 1;
  right: 0;
}
p{
    color: white;
}

a{
    text-decoration: none;
    color:black;
}

button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 16px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
  width: 100px;
}
.mycss {
  background-color: white; 
  color: cyan; 
  border: 2px solid #4CAF50;
  border-radius: 25px;
}

.mycss:hover {
  background-color: #4CAF50;
  color: white;
}

.mycss2 {
  background-color: white; 
  color: black; 
  border: 2px solid #f44336;
  border-radius: 25px;
}

.mycss2:hover {
  background-color: #f44336;
  color: white;
}

form{
    position: relative;
    margin:5% auto 0;
    width: 95%;
    height: 400px auto;
    background: linear-gradient(0deg, black, rgb(44,43,43));
    padding: 50px 40px;
    display: flex;
    flex-direction: column;
}

form::before, form::after
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

input[type="submit"]{
    font-size: 18px;
    background-color: black;
    color: cyan;
}
</style>

<!--80% perfect view-->
<head>
    <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>Villain Ticket List</title>
</head>
<ul>
  <li>
  <a href="home.php">Go Back</a>
  </li>
</ul>
<div class="content">
 <p class="alert alert-info">
            <marquee behavior="" scrollamount="2" direction="">All Events Schedules!!!
            </marquee>
        </p>
<body>
<button class="button" onclick="location='add-ticket.php'"><span>Add New Ticket 🎟</span></button>
<form method="POST" action="">
<table border="1" id="ticketList">
    <tr>
        <th></th>
        <th>Ticket ID</th>
        <th>Event Name</th>
        <th>Date</th>
        <th>Time</th>
        <th>Total Seats</th>
        <th>Gold Ticket Price</th>
        <th>Silver Ticket Price</th>
        <th>Bronze Ticket Price</th>
        <th>Action</th>
    </tr>
    <tbody>    
<?php 

    $counter = 0;
    
    while ($row = mysqli_fetch_array($results)) {
        echo "<tr>";
        echo "<td><input type='checkbox' name='ticketIds[]' value='".$row['TicketID']."'/></td>";
        echo "<td>" . $row['TicketID'] . "</td>";
        echo "<td>" . $row['EventName'] . "</td>";
        echo "<td>" . $row['TicketDate'] .  "</td>";
        echo "<td>" . $row['TicketTime'] .  "</td>";
        echo "<td>" . $row['TotalSeat'] .  "</td>";
        echo "<td>" . $row['goldprice'] .  "</td>";
        echo "<td>" . $row['silverprice'] .  "</td>";
        echo "<td>" . $row['bronzeprice'] .  "</td>";
        echo "<td>"
        ."<button class='mycss'>"."<a href='edit-ticket.php?id=".$row['TicketID']."'>Edit</a>"."</button>"
        ."<button class='mycss2'>"."<a href='delete-ticket.php?id=".$row['TicketID']."'>Delete</a>"."</button>"
        . "</td>";
        echo "</tr>";
        
        $counter += 1;
    }
    
    echo "<tr>";
    echo "<td colspan='10'>$counter record(s) created.</td>";
    echo "</tr>";
    ?>
   </tbody>
</table>
    <button class="button"><span><input type="submit" name="btnDelete" value="Delete checked" onclick="return confirm('This will delete all checked records.\nAre you sure?')"/></span></button>
</form>
</body>
