<?php

header("Content-Type: text/xml");

$xmlFilePath = '../report/paymentReport.xml';

if (file_exists($xmlFilePath)) {

    readfile($xmlFilePath);
} else {
    header("HTTP/1.0 404 Not Found");
    echo "Error: XML file not found.";
}
