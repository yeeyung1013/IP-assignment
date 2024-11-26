<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Date Range</title>
</head>
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
  width: 80px;
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
a {
  text-decoration: none;
  display: inline-block;
  padding: 5px 10px;
}
.previous {
  background-color: #f1f1f1;
  color: black;
}

a:hover {
  color: black;
  text-decoration: none;
}
</style>
<ul>
  <li>
  <a href="Events.php" class="previous">&laquo;</a>
  </li>
</ul>
<body>
    <h2>Select Start and End Date to Filter Events</h2>
    <form method="post" action="">
        <label for="startDate">Start Date (YYYY-MM-DD):</label>
        <input type="date" id="startDate" name="startDate" required>
        <br><br>
        <label for="endDate">End Date (YYYY-MM-DD):</label>
        <input type="date" id="endDate" name="endDate" required>
        <br><br>
        <button class='mycss' style='font-size:15px' type="submit">Submit</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['startDate']) && isset($_POST['endDate'])) {
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];

        generateXPathReport('../../assets/report/villain.xml', $startDate, $endDate);
    }

    function generateXPathReport($xmlFilename, $startDate, $endDate) {
        $xml = new DOMDocument;
        if (!$xml->load($xmlFilename)) {
            die('Failed to load XML file.');
        }

        $xpath = new DOMXPath($xml);

        $startYear = substr($startDate, 0, 4);
        $startMonth = substr($startDate, 5, 2);
        $startDay = substr($startDate, 8, 2);

        $endYear = substr($endDate, 0, 4);
        $endMonth = substr($endDate, 5, 2);
        $endDay = substr($endDate, 8, 2);

        $query = "//Event[
            (number(substring(StartDate, 1, 4)) > $startYear or 
            (number(substring(StartDate, 1, 4)) = $startYear and number(substring(StartDate, 6, 2)) > $startMonth) or 
            (number(substring(StartDate, 1, 4)) = $startYear and number(substring(StartDate, 6, 2)) = $startMonth and number(substring(StartDate, 9, 2)) >= $startDay))
            and
            (number(substring(StartDate, 1, 4)) < $endYear or 
            (number(substring(StartDate, 1, 4)) = $endYear and number(substring(StartDate, 6, 2)) < $endMonth) or 
            (number(substring(StartDate, 1, 4)) = $endYear and number(substring(StartDate, 6, 2)) = $endMonth and number(substring(StartDate, 9, 2)) <= $endDay))
        ]";

        $events = $xpath->query($query);

        echo "<h2>Events Between " . htmlspecialchars($startDate) . " to " . htmlspecialchars($endDate) . "</h2>";
        echo "<table border='1'>
                <tr>
                    <th>EventID</th>
                    <th>EventName</th>
                    <th>Description</th>
                    <th>Location</th>
                    <th>StartDate</th>
                    <th>Seat</th>
                </tr>";

        foreach ($events as $event) {
            echo "<tr>";
            echo "<td>" . $event->getElementsByTagName('EventID')->item(0)->nodeValue . "</td>";
            echo "<td>" . $event->getElementsByTagName('EventName')->item(0)->nodeValue . "</td>";
            echo "<td>" . $event->getElementsByTagName('Description')->item(0)->nodeValue . "</td>";
            echo "<td>" . $event->getElementsByTagName('Location')->item(0)->nodeValue . "</td>";
            echo "<td>" . $event->getElementsByTagName('StartDate')->item(0)->nodeValue . "</td>";
            echo "<td>" . $event->getElementsByTagName('Seat')->item(0)->nodeValue . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    }
    ?>
</body>
</html>
