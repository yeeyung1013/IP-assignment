<?php
require_once "../SecurePractice/databaseSecurity.php";

class generate_xml
{
    private $db;

    public function __construct()
    {
        $this->db = new databaseSecurity();
    }

    public function generateXmlFile($payment, $totalPayment, $totalAmount)
    {
        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->formatOutput = true;

        $paymentReport = $doc->createElement('paymentReport');
        $doc->appendChild($paymentReport);

        $reportDate = $doc->createElement('reportDate', date('Y-m-d'));
        $paymentReport->appendChild($reportDate);

        $totalTransactions = $doc->createElement('totalTransactions', $totalPayment);
        $paymentReport->appendChild($totalTransactions);
        $totalAmount = $doc->createElement('totalAmount', $totalAmount);
        $totalAmount->setAttribute('currency', 'MYR');
        $paymentReport->appendChild($totalAmount);

        foreach ($payment as $txn) {
            $payment = $doc->createElement('payment');

            $paymentID = $doc->createElement('paymentID', $txn['payment_id']);
            $payment->appendChild($paymentID);

            $paymentDate = $doc->createElement('paymentDate', $txn['date']);
            $payment->appendChild($paymentDate);

            $customerDetails = $doc->createElement('custDetails');
            $custID = $doc->createElement('custID', $txn['cust_id']);
            $customerDetails->appendChild($custID);
            $email = $doc->createElement('email', $txn['email']);
            $customerDetails->appendChild($email);
            $payment->appendChild($customerDetails);

            $paymentDetails = $doc->createElement('paymentDetails');
            $paymentMethod = $doc->createElement('paymentMethod', $txn['method']);
            $paymentDetails->appendChild($paymentMethod);
            $paymentAmount = $doc->createElement('amount', $txn['amount']);
            $paymentDetails->appendChild($paymentAmount);
            $ticketQuantity = $doc->createElement('quantity', $txn['quantity']);
            $paymentDetails->appendChild($ticketQuantity);
            $payment->appendChild($paymentDetails);

            $paymentReport->appendChild($payment);
        }

        $doc->save('paymentReport.xml');

        echo "XML report created successfully!";
    }

    public function printXml()
    {
        $xmlDoc = new DOMDocument();
        $xmlDoc->load("paymentReport.xml");

        print $xmlDoc->saveXML();
    }

    public function printXPath()
    {
        $xmlFilePath = 'paymentReport.xml';

        $dom = new DOMDocument;
        $dom->load($xmlFilePath);

        $xpath = new DOMXPath($dom);

        // XPath query
        $query = '//payment/paymentDetails/amount';

        $entries = $xpath->query($query);

        // Print the results
        foreach ($entries as $entry) {
            echo $entry->nodeValue . PHP_EOL;
        }
    }

    public function transformXmlToXslt()
    {
        $xml = new DOMDocument();
        $xml->load('paymentReport.xml');

        $xsl = new DOMDocument();
        $xsl->load('paymentReport.xsl');

        $xsltProcessor = new XSLTProcessor();

        $xsltProcessor->importStylesheet($xsl);

        $html = $xsltProcessor->transformToXML($xml);

        $outputFilename = '../xml/paymentReport.xslt';

        file_put_contents($outputFilename, $html);

        echo $html;
    }
    

    public function getDataFromDatabase($table, $attribute, $id)
    {
        try {
            $results = $this->db->query("SELECT * FROM $table WHERE $attribute = :$attribute", ["$attribute" => $id]);
            if ($results) {
                return $results;
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function getAllDataFromDatabase($table)
    {
        try {
            $results = $this->db->query("SELECT * FROM $table", []);
            if ($results) {
                return $results;
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function calculateTotalAmount($payments) {
        $total = 0;
            foreach ($payments as $payment) {
                $total += $payment['amount'];
            }
        return $total;
    }

}

/*
// Testing Code
$createXML = new generate_xml();

$createXML->printXml();
echo "<br><br>";
$createXML->printXPath();
echo "<br><br>";
$createXML->transformXmlToXslt();

// Generate XML File
$payment = $createXML->getAllDataFromDatabase("payment");
$payment_ticket = [];
$cust_details;
foreach ($payment as $index => $payments) {
    $payment_ticket[] = $createXML->getDataFromDatabase("payment_ticket", "payment_id", $payments['payment_id']);
    $cust_details = $createXML->getDataFromDatabase("customer", "cust_id", $payments['cust_id']);
    $payment[$index]['email'] = $cust_details[0]['email'];
}

$createXML->generateXmlFile($payment, count($payment), $createXML->calculateTotalAmount($payment));
*/