<!DOCTYPE html>
<?php
$pageTitle = "Events List";
include './includes/dbConnector.php';

$page = isset($_GET['page1']) ? (int)$_GET['page1'] : 1;
$num_per_page = 5;
$start_from = ($page - 1) * $num_per_page;

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

$dbConnection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($dbConnection->connect_error) {
    die("Connection failed: " . $dbConnection->connect_error);
}

if (!empty($searchQuery)) {
    $selectCommand = "SELECT * FROM villain WHERE EventName LIKE '%$searchQuery%' LIMIT $start_from, $num_per_page";
    $countCommand = "SELECT COUNT(*) FROM villain WHERE EventName LIKE '%$searchQuery%'";
} else {
    $selectCommand = "SELECT * FROM villain LIMIT $start_from, $num_per_page";
    $countCommand = "SELECT COUNT(*) FROM villain";
}

$results = mysqli_query($dbConnection, $selectCommand);

$totalRecordsResult = mysqli_query($dbConnection, $countCommand);

if ($totalRecordsResult) {
    $total_records = mysqli_fetch_array($totalRecordsResult)[0];
} else {
    die("Error fetching total records: " . mysqli_error($dbConnection));
}

$total_pages = ceil($total_records / $num_per_page);

?>
<style>
@import url(https://fonts.googleapis.com/css?family=Roboto:300);
table{
  margin: 30px auto; 
  border-collapse: separate; 
  border-spacing: 0; 
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); 
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

.search {
  background-color: white; 
  color: black; 
  border: 1px solid #333;
  margin-top:20px;
  width: 100px;
  height: 34px;
}

.search:hover {
  background-color: grey;
  color: white;
}
</style>
<ul>
  <li>
  <a href="home.php" class="previous">&laquo;</a>
  </li>
  <li class="<?php echo $class == 'reg' ? 'active' : '' ?>">
  <a href="insert-events.php" class="previous"><i class='fa'>&#xf067;</i> Events</a>
  <a href="generateReport.php" class="previous"><i class='fa'>&#xf067;</i> Report</a>
  <a href="generateXmlReport.php" class="previous"><i class='fa'>&#xf067;</i> XML Report</a>
  <a href="generateXsltReport.php" class="previous"><i class='fa'>&#xf067;</i> XSLT Report</a>
  <a href="generateXpathReport.php" class="previous"><i class='fa'>&#xf067;</i> XPath Report</a>
  </li>
</ul> 
<body>       
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<form method="GET" action="Events.php">
    <input type="text" placeholder="Search event..." name="search" id="search" size="70" style="padding: 5px 10px; margin-top: 10px; font-size: 18px" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" onkeyup="performSearch()">
</form>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Date</th>
                <th>Seat</th>
                <th>Action</th>
                <th>Schedule</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (mysqli_num_rows($results) > 0) {
            while ($row = mysqli_fetch_array($results)) {
                echo "<tr>";
                echo "<td>" . $row['EventID'] . "</td>";
                echo "<td>" . $row['EventName'] . "</td>";
                echo "<td>" . $row['Description'] . "</td>";
                echo "<td>" . $row['StartDate'] . "</td>";
                echo "<td>" . $row['Seat'] . "</td>";
                echo "<td>"
                    . "<button class='mycss' style='font-size:20px'><a href='edit-events.php?id=" . $row['EventID'] . "'><i class='fa fa-edit'></i></a></button>"
                    . "<button class='mycss2' style='font-size:20px'><a href='delete-events.php?id=" . $row['EventID'] . "'><i class='fa fa-trash-o'></i></a></button>"
                    . "</td>";
                echo "<td>"
                    . "<button class='mycss' style='font-size:20px'><a href='insert-schedule.php?id=" . $row['EventID'] . "'><i class='fa'>&#xf067;</i></a></button>"
                    . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No events found</td></tr>";
        }
        ?>
        </tbody>
    </table>
    <div>
        <?php
        if ($page > 1) {
            echo "<a href='Events.php?page1=" . ($page - 1) . "&search=" . urlencode($searchQuery) . "' class='mycss2'>Previous</a>";
        }

        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<a href='Events.php?page1=" . $i . "&search=" . urlencode($searchQuery) . "' class='mycss3'>" . $i . "</a> ";
        }

        if ($page < $total_pages) {
            echo "<a href='Events.php?page1=" . ($page + 1) . "&search=" . urlencode($searchQuery) . "' class='mycss'>Next</a>";
        }
        ?>
    </div>
</body>
</html>

<script>
function performSearch(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
    }

    let searchQuery = document.getElementById('search').value;

    if (searchQuery.length > 0) {
        window.location.href = 'Events.php?search=' + encodeURIComponent(searchQuery);
    } else {
        window.location.href = 'Events.php';
    }
}
</script>
