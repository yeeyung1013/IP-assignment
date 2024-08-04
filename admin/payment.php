<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<?php
$pageTitle = "Schedule List";
include './includes/dbConnector.php';

$dbConnection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$selectCommand = "SELECT * FROM payment";

$results = mysqli_query($dbConnection, $selectCommand);
?>
<style>
@import url(https://fonts.googleapis.com/css?family=Roboto:300);
table, th, td {
  border:1px solid #DDD;
  padding:50px;
  margin:20px;
  color:black;
  background-color: whitesmoke;
}
/*tr:hover {
    background-color: #D6EEEE;
}*/
#myInput {
  background-color: #D6EEEE;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
  text-align: right;
}
#myInput:hover{
color:blue;   
}  
td:hover{
    color: blue;
}
a:hover{
    color:blue;
}

.login-page {
  width: 50%;
  padding: 5% 0 0;
  margin: auto;
}
.signup-page {
  width: 60%;
  padding: 5% 0 0;
  margin: auto;
}
.large-page {
  width: 100%;
  height: 20px;
  padding: 5% 0 0;
  margin: auto;
}
.large-page .form {
  position: relative;
  z-index: 1;
  background: #ffffff;
  max-width: 80%;
  height: 800px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.form {
  position: relative;
  z-index: 1;
  background: #ffffff;
  max-width: 70%;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.logged-user {
  margin-left: 60px;
}
.form input,
select {
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
}
.form button {
  font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  outline: 0;
  /* background: green; */
  background: #45b94a;
  width: 100%;
  border: 0;
  padding: 15px;
  color: #ffffff;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
  cursor: pointer;
}
.form button:hover,
.form button:active,
.form button:focus {
  background: #61ca4c;
}
.form .message {
  margin: 15px 0 0;
  color: #b3b3b3;
  font-size: 12px;
}
.form .message a {
  color: #3faa45;
  text-decoration: none;
}
.form .register-form {
  display: none;
}
.container {
  position: relative;
  z-index: 1;
  max-width: 300px;
  margin: 0 auto;
}
.container:before,
.container:after {
  content: "";
  display: block;
  clear: both;
}
.container .info {
  margin: 50px auto;
  text-align: center;
}
.container .info h1 {
  margin: 0 0 15px;
  padding: 0;
  font-size: 36px;
  font-weight: 300;
  color: #1a1a1a;
}
.container .info span {
  color: #4d4d4d;
  font-size: 12px;
}
.container .info span a {
  color: #000000;
  text-decoration: none;
}
.container .info span .fa {
  color: #ef3b3a;
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
</style>
<ul>
  <li>
  <a href="home.php">Go Back</a>
  </li>
</ul>
 <p class="alert alert-info">
            <marquee behavior="" scrollamount="2" direction="">All Customer Payments List!!!
            </marquee>
        </p>
<form method="POST" action="">
<table border="1">
    <thead>
       <tr>
                                        <th>Payment ID</th>
                                        <th>Customer ID</th>
                                        <th>Customer Name</th>
                                        <th>Schedule ID</th>
                                        <th>Amount(RM)</th>
                                        <th>Quantity</th>
                                        <th>Date</th>
                                    </tr>
    </thead>
    <tbody>
<?php 
    
     while ($row = mysqli_fetch_array($results)) {
                                   echo "<tr>";
                                   echo "<td>" . $row['id'] . "</td>";
                                   echo "<td>" . $row['passenger_id'] . "</td>";
                                   echo "<td>" . $row['cust_name'] . "</td>";
                                   echo "<td>" . $row['schedule_id'] . "</td>";
                                   echo "<td>" . $row['amount'] . "</td>";
                                   echo "<td>" . $row['quantity'] .  "</td>";
                                   echo "<td>" . $row['date'] .  "</td>";
                                   echo "</tr>";
    }
    
    echo "<tr>";
    echo "</tr>";
    ?>
    </tbody>
</table>
  <br>
</form>
