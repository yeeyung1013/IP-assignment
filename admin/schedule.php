<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<?php
$pageTitle = "Schedule List";
include './includes/dbConnector.php';

$dbConnection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$selectCommand = "SELECT * FROM schedule";

$results = mysqli_query($dbConnection, $selectCommand);
?>
<style>
@import url(https://fonts.googleapis.com/css?family=Roboto:300);
table{
  border:1px solid #DDD;
  padding:50px;
  margin:20px;
  color:black;
  background-color: #333;
}

th,td{
  padding:50px;
  margin:20px;
  color:cyan;
  background-color: black;
}

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
  color: black; 
  border: 2px solid #4CAF50;
}

.mycss:hover {
  background-color: #4CAF50;
  color: white;
}

.mycss2 {
  background-color: white; 
  color: black; 
  border: 2px solid #f44336;
}

.mycss2:hover {
  background-color: #f44336;
  color: white;
}

form{
    position: relative;
    margin:5% auto 0;
    width: 90%;
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

</style>
<ul> 
  <li class="<?php echo $class == 'reg' ? 'active' : '' ?>">
   <a href="insert-schedule.php">Add New Schedule&#127918;</a>
  </li>
  <li>
  <a href="home.php">Go Back</a>
  </li>
</ul>
<div class="content">
 <p class="alert alert-info">
            <marquee behavior="" scrollamount="2" direction="">All Events Schedules!!!
            </marquee>
        </p>
<form method="POST" action="">
<table border="1">
    <thead>
    <tr>
                                        <th>Schedule ID</th>
                                        <th>Event ID</th>
                                        <th>Date</th>
                                        <th>Time</th>
<!--                                        <th>Gold Ticket Price </th>
                                        <th>Sliver Ticket Price</th>
                                        <th>Bronze Ticket Price</th>-->
                                        <th>Action</th>
    </tr>
    </thead>
    <tbody>
<?php 
    
    while ($row = mysqli_fetch_array($results)) {
        echo "<tr>";
                                   echo "<td>" . $row['id'] . "</td>";
                                   echo "<td>" . $row['EventID'] . "</td>";
                                   echo "<td>" . $row['date'] . "</td>";
                                   echo "<td>" . $row['time'] . "</td>";
//                                   echo "<td>" . $row['goldprice'] .  "</td>";
//                                   echo "<td>" . $row['silverprice'] .  "</td>";
//                                   echo "<td>" . $row['bronzeprice'] .  "</td>";
                                   echo "<td>"
                                   ."<button class='mycss'>"."<a href='edit-schedule.php?id=".$row['id']."'>Edit</a>"."</button>"
                                   ."<button class='mycss2'>"."<a href='delete-schedule.php?id=".$row['EventID']."'>Delete</a>"."</button>"
                                   . "</td>";
                                   echo "</tr>";
    }
    
    echo "<tr>";
    echo "</tr>";
    ?>
    </tbody>
</table>
  <br>
</form>