<?php
require_once 'generateXMLReport.php';
require_once 'transformXMLReport.php';

$xmlFilename = '../../assets/report/villain.xml';
$xsltFilename = '../../assets/report/transform.xsl';
$transformedFilename = '../../assets/report/villain_transformed.xml';
$redirectUrl = 'Events.php';

generateXMLReport($xmlFilename);

transformXMLReport($xmlFilename, $xsltFilename, $transformedFilename);

header('Location: ' . $redirectUrl);
exit();
?>