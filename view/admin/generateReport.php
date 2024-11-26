<?php
function generateStyledPDF($events) {
    $pdf = "%PDF-1.4\n";
    $pdf .= "1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj\n";
    $pdf .= "2 0 obj << /Type /Pages /Kids [3 0 R 6 0 R 9 0 R] /Count 3 >> endobj\n";
    $pdf .= "3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >> endobj\n";
    $pdf .= "5 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj\n";
    $pdf .= "6 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 7 0 R /Resources << /Font << /F1 5 0 R >> >> >> endobj\n";
    $pdf .= "9 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 10 0 R /Resources << /Font << /F1 5 0 R >> >> >> endobj\n";

    $contentPage1 = "";
    $contentPage2 = "";
    $contentPage3 = "";

    $contentPage1 .= "BT /F1 16 Tf 50 750 Td (Villain Event Report) Tj ET\n";
    $contentPage1 .= "BT /F1 12 Tf 50 735 Td (--------------------------------------------------------------------------) Tj ET\n";

    $yPosPage1 = 710;
    $yPosPage2 = 750;
    $yPosPage3 = 750;
    $itemNumber = 1; 

    $eventsPerPage = ceil(count($events) / 3);
    $eventCounter = 0;

    foreach ($events as $event) {
        if ($eventCounter < $eventsPerPage) {
            $contentPage1 .= "BT /F1 12 Tf 50 $yPosPage1 Td ($itemNumber.) Tj ET\n";
            $yPosPage1 -= 20;

            $contentPage1 .= "BT /F1 12 Tf 70 $yPosPage1 Td (Event Name: " . $event['EventName'] . ") Tj ET\n";
            $yPosPage1 -= 15;

            $contentPage1 .= "BT /F1 12 Tf 70 $yPosPage1 Td (Location: " . $event['location'] . ") Tj ET\n";
            $yPosPage1 -= 15;

            $contentPage1 .= "BT /F1 12 Tf 70 $yPosPage1 Td (Start Date: " . date('Y-m-d', strtotime($event['StartDate'])) . ") Tj ET\n";
            $yPosPage1 -= 20; 
        } elseif ($eventCounter < $eventsPerPage * 2) {
            $contentPage2 .= "BT /F1 12 Tf 50 $yPosPage2 Td ($itemNumber.) Tj ET\n";
            $yPosPage2 -= 20;

            $contentPage2 .= "BT /F1 12 Tf 70 $yPosPage2 Td (Event Name: " . $event['EventName'] . ") Tj ET\n";
            $yPosPage2 -= 15;

            $contentPage2 .= "BT /F1 12 Tf 70 $yPosPage2 Td (Location: " . $event['location'] . ") Tj ET\n";
            $yPosPage2 -= 15;

            $contentPage2 .= "BT /F1 12 Tf 70 $yPosPage2 Td (Start Date: " . date('Y-m-d', strtotime($event['StartDate'])) . ") Tj ET\n";
            $yPosPage2 -= 20; 
        } else {
            $contentPage3 .= "BT /F1 12 Tf 50 $yPosPage3 Td ($itemNumber.) Tj ET\n";
            $yPosPage3 -= 20;

            $contentPage3 .= "BT /F1 12 Tf 70 $yPosPage3 Td (Event Name: " . $event['EventName'] . ") Tj ET\n";
            $yPosPage3 -= 15;

            $contentPage3 .= "BT /F1 12 Tf 70 $yPosPage3 Td (Location: " . $event['location'] . ") Tj ET\n";
            $yPosPage3 -= 15;

            $contentPage3 .= "BT /F1 12 Tf 70 $yPosPage3 Td (Start Date: " . date('Y-m-d', strtotime($event['StartDate'])) . ") Tj ET\n";
            $yPosPage3 -= 20; 
        }

        $itemNumber++; 
        $eventCounter++;
    }

    $pdf .= "4 0 obj << /Length " . strlen($contentPage1) . " >> stream\n" . $contentPage1 . "\nendstream endobj\n";
    $pdf .= "7 0 obj << /Length " . strlen($contentPage2) . " >> stream\n" . $contentPage2 . "\nendstream endobj\n";
    $pdf .= "10 0 obj << /Length " . strlen($contentPage3) . " >> stream\n" . $contentPage3 . "\nendstream endobj\n";
    
    $pdf .= "xref\n0 11\n0000000000 65535 f \n0000000010 00000 n \n0000000070 00000 n \n0000000150 00000 n \n0000000250 00000 n \n0000000330 00000 n \n0000000410 00000 n \n0000000490 00000 n \n0000000570 00000 n \n0000000650 00000 n \n0000000730 00000 n\n";
    $pdf .= "trailer << /Size 11 /Root 1 0 R >>\nstartxref\n830\n%%EOF";

    header("Content-Type: application/pdf");
    header("Content-Disposition: attachment; filename=\"event_report.pdf\"");
    echo $pdf;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reportServiceUrl = 'http://localhost:8082/generateReport';
    $ch = curl_init($reportServiceUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        $events = json_decode($response, true);
        generateStyledPDF($events);
    }
    curl_close($ch);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Event Report</title>
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
  width: 300px;
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
    <h1>Generate Event Report</h1>
    <form action="generateReport.php" method="post">
        <button type="submit">Download PDF Report</button>
    </form>
</body>
</html>