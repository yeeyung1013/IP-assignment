
<?php
// File paths<!--SIASHUNFU-->
$xmlFilename = '../../assets/report/reviews.xml';
$xslFilename = 'review.xsl';   

$outputFilename = '../../assets/report/reviews.html';  
$redirectUrl = 'http://localhost/villain/assets/report/reviews.html'; 
function ReviewXSLTreport($xmlFilename, $xslFilename, $outputFilename, $redirectUrl) {
    require_once 'conn.php';

    // Load the XML
    $xmlDoc = new DOMDocument();
    if (!$xmlDoc->load($xmlFilename)) {
        die('Error: Unable to load XML file.');
    }

    // Load the XSL
    $xslDoc = new DOMDocument();
    if (!$xslDoc->load($xslFilename)) {
        die('Error: Unable to load XSL file.');
    }

    // Create XSLT Processor
    $xsltProcessor = new XSLTProcessor();
    $xsltProcessor->importStylesheet($xslDoc); 

    // Apply the XSL transformation
    $htmlOutput = $xsltProcessor->transformToXML($xmlDoc);
    if ($htmlOutput === false) {
        die('Error: XSLT Transformation failed.');
    }

    // Save the transformed output to a file
    file_put_contents($outputFilename, $htmlOutput);

  
    header('Location: ' . $redirectUrl);
    exit();
}

 






// Generate the report
ReviewXSLTreport($xmlFilename, $xslFilename, $outputFilename, $redirectUrl);
?>
