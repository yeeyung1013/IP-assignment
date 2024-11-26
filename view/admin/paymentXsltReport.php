<?php

function transformXmlToXslt()
{
    $xml = new DOMDocument();
    $xml->load('../../assets/report/paymentReport.xml');

    $xsl = new DOMDocument();
    $xsl->load('../../assets/report/paymentReport.xsl');

    $xsltProcessor = new XSLTProcessor();

    $xsltProcessor->importStylesheet($xsl);

    $html = $xsltProcessor->transformToXML($xml);

    $outputFilename = '../../assets/report/paymentReport.xslt';

    file_put_contents($outputFilename, $html);

    echo $html;
}

transformXmlToXslt();