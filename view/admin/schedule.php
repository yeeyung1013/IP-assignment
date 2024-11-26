<!DOCTYPE html>

<?php
$pageTitle = "Schedule List";
include './includes/dbConnector.php';

if(isset($_GET['page1']))
{
    $page=$_GET['page1'];
}
 else {   
$page=1;
 }
 
 $num_per_page=05;
 $start_from=($page-1)*05;

$dbConnection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$selectCommand = "SELECT * FROM schedule limit $start_from,$num_per_page";

$results = mysqli_query($dbConnection, $selectCommand);
?>
<style>
@import url(https://fonts.googleapis.com/css?family=Roboto:300);
table{
  margin: 30px auto; 
  border-collapse: separate; 
  border-spacing: 0; 
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); 
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  width: 90%;
}

    th {
        background-color: #333;
        color: #fff;
        padding: 12px 15px;
        text-align: left;
        border-bottom: 2px solid #555;
        font-weight: normal;
    }
    td {
        padding: 30px 15px;
        margin:30px;
        color:black;
        border-bottom: 1px solid #ddd;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
        border:1 px groove #ddd;
    }

    tr:hover {
        background-color: #e9f5f2;
    }

    tr:last-child td {
        border-bottom: none;
    }
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

.dropdown-menu > li > a:hover,
.dropdown-menu > li > a:focus {
  color: #262626;
  text-decoration: none;
  background-color: #66ccff; 
}
.help-block {
  color: red;
  font-size: 12px;
  margin: 0;
  padding: 0;
}

body {
  font-family: "Roboto", sans-serif;
  background-color: #F0F0F0;
  line-height: 1.9;
  color: #8c8c8c;
  position: relative; 
}

p{
    color: white;
}

button {
  background-color: #4CAF50; 
  color: white;
  padding: 5px 10px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  margin: 3px 2px;
  transition-duration: 0.4s;
  width: 60px;
}

ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #F0F0F0;
}

li {
  float: left;
}

li a {
  color: white;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  padding: 5px 10px;
}

li a:hover {
  background-color: #ddd;
}
.help-block {
  color: red;
  font-size: 12px;
  margin: 0;
  padding: 0;
}

a {
  text-decoration: none;
  display: inline-block;
  padding: 5px 10px;
}

a:hover {
  color: black;
  text-decoration: none;
}

.previous {
  background-color: #f1f1f1;
  color: black;
}

.mycss {
  background-color: white; 
  color: black; 
  border: 1px solid #4CAF50;
}

.mycss:hover {
  background-color: #4CAF50;
  color: white;
}
.mycss2 {
  background-color: white; 
  color: black; 
  border: 1px solid #f44336;
}

.mycss2:hover {
  background-color: #f44336;
  color: white;
}

.mycss3 {
  background-color: white; 
  color: black; 
  border: 1px solid #333;
  margin: 10px;
}

.mycss3:hover {
  background-color: #0056b3;
  color: white;
}

</style>    
<ul>
  <li>
  <a href="home.php" class="previous">&laquo;</a>
  </li>
</ul>
<body>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<table>
    <thead>
    <tr>
                    <th>Schedule ID</th>
                    <th>Event ID</th>
                    <th>Time</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Action</th>
                    <th>Ticket Management</th>
    </tr>
    </thead>
    <tbody>
<?php 
    
    while ($row = mysqli_fetch_array($results)) {
        echo "<tr>";
                                   echo "<td>" . $row['schedule_id'] . "</td>";
                                   echo "<td>" . $row['EventID'] . "</td>";
                                   echo "<td>" . $row['time'] . "</td>";
                                   echo "<td>" . $row['startdate'] . "</td>";
                                   echo "<td>" . $row['enddate'] . "</td>";
                                   echo "<td>"
                                   ."<button class='mycss' style='font-size:20px'>" 
                               . "<a href='edit-schedule.php?id=" . $row['schedule_id'] . "'><i class='fa fa-edit'></i></a>" 
                               . "</button>"
                               ."<button class='mycss2' style='font-size:20px'>" 
                               . "<a href='delete-schedule.php?id=" . $row['EventID'] . "'><i class='fa fa-trash-o'></i></a>" 
                               . "</button>". "</td>";
                                  echo "<td><a href=\"ticket.php?schedule_id=" . $row['schedule_id'] . "\">View Tickets</a></td>";
                                   echo "</tr>";
    }
    
    echo "<tr>";
    echo "</tr>";
    ?>
    </tbody>
</table>
  <br>
</body>
<?php 
    
    
    $sql="select * from schedule";
    $rs_result=mysqli_query($dbConnection,$selectCommand);
    $total_records=mysqli_num_rows($rs_result);
    $total_pages=ceil($total_records/$num_per_page);
    
    if($page>1)
             {
                  echo "<a href='schedule.php?page1=".($page-1)."' class='mycss2'>Previous</a>";
              }
    
    for($i=1;$i<=$total_pages;$i++)
    {
        echo "<a href='schedule.php?page=".$i."' class='mycss3'>".$i++."</a>" ;
    }

              
     if($i>$page)
              {
                 echo "<a href='schedule.php?page1=".($page+1)."' class='mycss'>Next</a>";              
                 
              }
    
    
    ?>