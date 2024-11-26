
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Date Range for Reviews</title>
</head>
<style>
@import url(https://fonts.googleapis.com/css?family=Roboto:300);
table {
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
    color: black;
    border-bottom: 1px solid #ddd;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
    border: 1px groove #ddd;
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

#myInput:hover {
    color: blue;
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

p {
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
<body>
    <!-- <h2>Select Start and End Date to Filter Reviews</h2>
    <form method="post" action="">
        <label for="startDate">Start Date (YYYY-MM-DD):</label>
        <input type="date" id="startDate" name="startDate" required>
        <br><br>
        <label for="endDate">End Date (YYYY-MM-DD):</label>
        <input type="date" id="endDate" name="endDate" required>
        <br><br>
        <button class='mycss' style='font-size:15px' type="submit">Submit</button>
    </form> -->

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['startDate']) && isset($_POST['endDate'])) {
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];

        // Call the function to generate the XPath report
        generateXPathReport('../../assets/report/reviews.xml', $startDate, $endDate);
    }

function generateXPathReport($xmlFilename, $startDate, $endDate) {
    // Load the XML file
    $xml = new DOMDocument;
    if (!$xml->load($xmlFilename)) {
        die('Failed to load XML file.');
    }

    // Create an XPath object
    $xpath = new DOMXPath($xml);

    // XPath query to filter by date range using DateTime
    $query = "//Review[
        DateTime >= '$startDate 00:00:00' and DateTime <= '$endDate 23:59:59'
    ]";

    // Execute the query
    $reviews = $xpath->query($query);

    // Display results
    echo "<h2>Reviews Between " . htmlspecialchars($startDate) . " and " . htmlspecialchars($endDate) . "</h2>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>UserName</th>
                <th>UserReview</th>
                <th>UserRating</th>
                <th>Date</th>
            </tr>";

    // Loop through the results and display each review
    foreach ($reviews as $review) {
        echo "<tr>";
        echo "<td>" . $review->getElementsByTagName('ID')->item(0)->nodeValue . "</td>";
        echo "<td>" . $review->getElementsByTagName('UserName')->item(0)->nodeValue . "</td>";
        echo "<td>" . $review->getElementsByTagName('UserReview')->item(0)->nodeValue . "</td>";
        echo "<td>" . $review->getElementsByTagName('UserRating')->item(0)->nodeValue . "</td>";
        echo "<td>" . $review->getElementsByTagName('DateTime')->item(0)->nodeValue . "</td>";
        echo "</tr>";
    }

    echo "</table>";
}

    ?>
</body>
</html>
