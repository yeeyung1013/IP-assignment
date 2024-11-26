<?php

include_once "../../SecurePractice/databaseSecurity.php";

class PaymentXmlReport {
function generateXmlFile($payment, $totalPayment, $totalAmount)
{
    $redirectUrl = "adminPayment.php";
    $filename = '../../assets/report/paymentReport.xml';
    
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

    $doc->save($filename);

    echo "XML report created successfully!";

    header('Location: ' . $redirectUrl);
}

function getDataFromDatabase($table, $attribute, $id)
{
    $db = new databaseSecurity();
    try {
        $results = $db->query("SELECT * FROM $table WHERE $attribute = :$attribute", ["$attribute" => $id]);
        if ($results) {
            return $results;
        }
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}

function getAllDataFromDatabase($table)
{
    $db = new databaseSecurity();
    try {
        $results = $db->query("SELECT * FROM $table", []);
        if ($results) {
            return $results;
        }
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}

function calculateTotalAmount($payments)
{
    $total = 0;
    foreach ($payments as $payment) {
        $total += $payment['amount'];
    }
    return $total;
}

}

$paymentReport = new PaymentXmlReport();

$payment = $paymentReport->getAllDataFromDatabase("payment");
$payment_ticket = [];
$cust_details;
foreach ($payment as $index => $payments) {
    $payment_ticket[] = $paymentReport->getDataFromDatabase("payment_ticket", "payment_id", $payments['payment_id']);
    $cust_details = $paymentReport->getDataFromDatabase("customer", "cust_id", $payments['cust_id']);
    $payment[$index]['email'] = $cust_details[0]['email'];
}

$paymentReport->generateXmlFile($payment, count($payment), $paymentReport->calculateTotalAmount($payment));