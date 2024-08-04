<?php 
$pageTitle = "Admin List";
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

$selectCommand = "SELECT * FROM admin limit $start_from,$num_per_page";

$results = mysqli_query($dbConnection, $selectCommand);   

$source = 'admin1';
$me = "?page=$source";
if (isset($_GET['status'], $_GET['id'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];
    if ($status == 0) {
        $status = 0;
    } else {
        $status = 1;
    }
    $dbConnection = $dbConnection->query("UPDATE admin SET status = '$status' WHERE id = '$id'");
    echo "<script>alert('Action completed!');window.location='home.php$me';</script>";
}
?>

<!DOCTYP html>
<html>
    <head>
        <title>Villain Admin Page</title>
    </head>
<style>
@import url(https://fonts.googleapis.com/css?family=Roboto:300);
table{
  border:1px solid #DDD;
  color:black;
  background-color: #333;
  position: relative;
  margin:5% auto 0;
  width: 95%;
  height: 400px auto;
  background: linear-gradient(0deg, black, rgb(44,43,43));
  padding: 50px 40px;
  display: flex;
  flex-direction: column;
}

th,td{
  padding:50px;
  margin:20px;
  color:cyan;
  background-color: black;
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
}

.mycss {
  background-color: white; 
  color: black; 
  border: 1px solid #333;
  padding: 10px;
  margin: 10px;
}

.mycss:hover {
  background-color: #4CAF50;
  color: white;
}

.mycss2 {
  background-color: white; 
  color: black; 
  border: 1px solid #333;
  padding: 10px;
  margin: 10px;
}

.mycss2:hover {
  background-color: #f44336;
  color: white;
}

.mycss3 {
  background-color: white; 
  color: black; 
  border: 1px solid #333;
  padding: 10px;
  margin: 10px;
}

.mycss3:hover {
  background-color: #0056b3;
  color: white;
}


table::before, table::after
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
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<ul>
  <li>
  <a href="home.php">Go Back</a>
  </li>
</ul>
<div class="content">
    <!-- Main content -->
 <p class="alert alert-info">
            <marquee behavior="" scrollamount="2" direction="">Registered Admin List，All Admin Personal Information Will Be Stored Here!!!
            </marquee>
        </p>
        
    
    <table border="1">
         <tr>
                             <th>#</th>
                             <th>Full Name</th>
                             <th>Email</th>
                             <th>Contact</th>
                             <th>Address</th>
                             <th>Image</th>
                             <th>Action</th>
              </tr>
        
        <?php 

                                        while ($row = mysqli_fetch_array($results)) {
                                            $id = $row['id']; ?><tr>
                                            <td><?php echo ($row['id']); ?></td>    
                                            <td><?php echo ($row['name']); ?></td>
                                            <td><?php echo ($row['email']); ?></td>
                                            <td><?php echo ($row['phone']); ?></td>
                                            <td><?php echo ($row['address']); ?></td>
                                            <td><img src="<?php echo "upload/" . ($row['image']); ?>"
                                                    class="img img-rounded" width="100" height="100" /></td>
                                             <td>
                                                <?php
                                                    if ($row['status'] == 0) {
                                                    ?>
                                                <a href="home.php?page=users&status=1&id=<?php echo $id; ?>">
                                                    <button style="background-color:green"
                                                        onclick="return confirm('You are about allowing this user be able to login his/her account.')"
                                                        type="submit" class="btn btn-success">
                                                        Enable Account
                                                    </button></a>
                                                <?php } else { ?>
                                                <a href="home.php?page=users&status=0&id=<?php echo $id; ?>">
                                                    <button style="background-color:red"
                                                        onclick="return confirm('You are about denying this user access to  his/her account.')"
                                                        type="submit" class="btn btn-danger">
                                                        Disable Account
                                                    </button></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>     
    </table>
    <br/>
    <br/>
    <?php 
    
    
    $sql="select * from admin";
    $rs_result=mysqli_query($dbConnection,$selectCommand);
    $total_records=mysqli_num_rows($rs_result);
    $total_pages=ceil($total_records/$num_per_page);
    
    if($page>1)
             {
                  echo "<a href='admin1.php?page1=".($page-1)."' class='mycss2'>Previous</a>";
              }
    
    for($i=1;$i<=$total_pages;$i++)
    {
        echo "<a href='admin1.php?page=".$i."' class='mycss3'>".$i++."</a>" ;
    }

              
     if($i>$page)
              {
                 echo "<a href='admin1.php?page1=".($page+1)."' class='mycss'>Next</a>";              
                 
              }
    
    
    ?>
    

    
</html>