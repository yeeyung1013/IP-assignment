<?php
function transformXMLReport($xmlFilename, $xsltFilename, $outputFilename, $redirectUrl) {
    require_once 'conn.php';
    $doc = new DOMDocument('1.0', 'UTF-8');
    $doc->formatOutput = true; 
    $root = $doc->createElement('Events');
    $doc->appendChild($root);

    $results = mysqli_query($conn, "SELECT * FROM villain");

    while ($row = mysqli_fetch_array($results)) {
        $event = $doc->createElement('Event');
        $root->appendChild($event);

        $event->appendChild($doc->createElement('EventID', htmlspecialchars($row['EventID'])));
        $event->appendChild($doc->createElement('EventName', htmlspecialchars($row['EventName'])));
        $event->appendChild($doc->createElement('Description', htmlspecialchars($row['Description'])));
        $event->appendChild($doc->createElement('Location', htmlspecialchars($row['location'])));
        $event->appendChild($doc->createElement('StartDate', htmlspecialchars($row['StartDate'])));
        $event->appendChild($doc->createElement('Seat', htmlspecialchars($row['Seat'])));
    }

    $doc->save($xmlFilename);

    $xmlDoc = new DOMDocument();
    $xmlDoc->load($xmlFilename);
    
    $xslDoc = new DOMDocument();
    $xslDoc->load($xsltFilename);

    $xsltProcessor = new XSLTProcessor();
    $xsltProcessor->importStylesheet($xslDoc);

    $result = $xsltProcessor->transformToXml($xmlDoc);

    file_put_contents($outputFilename, $result);

    header('Location: ' . $redirectUrl);
    exit(); 
}

$xmlFilename = '../../assets/report/villain.xml';
$xsltFilename = 'event.xsl'; 
$outputFilename = '../../assets/report/villain.html';
$redirectUrl = '../../assets/report/villain.html';

transformXMLReport($xmlFilename, $xsltFilename, $outputFilename, $redirectUrl);
?>