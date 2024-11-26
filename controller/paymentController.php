<?php

require_once "StripeGateway.php";
require_once "StripeAdapter.php";
require_once "PaypalGateway.php";
require_once "PaypalAdapter.php";
require_once "../SecurePractice/databaseSecurity.php";
require_once "../SecurePractice/dataProtection.php";
require_once "../model/payment.php";
require_once "../model/payment_ticket.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../view/admin/includes/PHPMailer.php';
require_once '../view/admin/includes/SMTP.php';
require_once '../view/admin/includes/Exception.php';

$controller = filter_input(INPUT_GET, "controller");
$action = filter_input(INPUT_GET, "action");

session_start();


//$_SESSION['purchase_ticket'] = [['ticket_id' => '10001', 'quantity' => 1], ['ticket_id' => '10002', 'quantity' => 2]];
$_SESSION['purchase_ticket_event'] = "2";
$_SESSION['purchase_ticket_event_schedule'] = "8";


$controllerObj = new PaymentController();


if ($controller === 'payment') {

    if ($action === 'details' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $controllerObj->unsetFormSessionVariable();
        $controllerObj->proceedPaymentDetailsPage();
    } elseif ($action === 'summary' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $controllerObj->processPaymentDetails();
    } elseif ($action === 'selectPayment' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $controllerObj->proceedPaymentSelectionPage();
    } elseif ($action === 'process' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $controllerObj->processPayment();
    }
} else {
    $controllerObj->unsetFormSessionVariable();
    $controllerObj->proceedPaymentDetailsPage();
}

class PaymentController
{
    private $db;
    private $dataProtection;
    private $data;

    public function __construct()
    {
        $this->db = new databaseSecurity();
        $this->dataProtection = new dataProtection();
        $this->assignDataToDisplay();
    }

    public function assignDataToDisplay()
    {
        $_SESSION['event_details'] = $this->getDataFromDatabase("villain", "EventID", $_SESSION['purchase_ticket_event']);
        $_SESSION['schedule_details'] = $this->getDataFromDatabase("schedule", "schedule_id", $_SESSION['purchase_ticket_event_schedule']);
        $selected_ticket_to_display = array();

        foreach ($_SESSION['purchase_ticket'] as $ticket) {
            $ticket_data = $this->getDataFromDatabase("ticket", "ticket_id", $ticket['ticket_id']);
            $ticket_data[0]['quantity'] = $ticket['quantity'];
            $selected_ticket_to_display[] = $ticket_data;
        }
        $_SESSION['total_amount'] = $this->calculateTotalAmount($selected_ticket_to_display);
        $_SESSION['selected_ticket_details'] = $selected_ticket_to_display;
        $_SESSION['total_quantity'] = $this->calculateQuantity($selected_ticket_to_display);
    }

    public function proceedPaymentDetailsPage()
    {
        header("Location: ../view/cart.php");
    }

    public function proceedSummaryPage()
    {
        header("Location: ../view/payment_summary.php");
    }

    public function proceedPaymentSelectionPage()
    {
        header("Location: ../view/payment_method.php");
    }

    public function processPaymentDetails()
    {
        $custData['name'] = $_POST['name'];
        $custData['email'] = $_POST['email'];
        $custData['contactNum'] = $_POST['contactNum'];
        $_SESSION['custData'] = $custData;

        $this->validateInput($custData);

        if (!isset($_SESSION['nameError']) && !isset($_SESSION['emailError']) && !isset($_SESSION['contactNumError'])) {
            $this->proceedSummaryPage();
        } else {
            $this->proceedPaymentDetailsPage();
        }
    }

    public function processPayment()
    {
        $cust_email = $_SESSION["email"];
        $payment_method = $_POST['payment_method'];
        $custData = $this->getDataFromDatabase("customer", "email", $cust_email);
        $cust_id = $custData[0]['cust_id'];
        $this->data = new Payment($cust_id, $_SESSION['total_quantity'], $payment_method, $_SESSION['total_amount']);

        $paymentStatus = $this->directPayment($payment_method, $this->data);

        $purchase_ticket = $_SESSION['purchase_ticket'];

        if ($paymentStatus) {

            $this->data->storePaymentToDatabase();
            $inserted_paymentId = $this->data->getPaymentId();

            foreach ($purchase_ticket as $ticket) {
                $ticketIdArray = ['ticket_id' => $ticket['ticket_id']];
                $paymentTicket = new PaymentTicket($inserted_paymentId, $ticket['ticket_id'], $ticket['quantity']);
                $paymentTicket->storePaymentTicketToDatabase();
                $this->updateDataInDatabase("ticket", "slot_sold = slot_sold + " . $ticket['quantity'], "ticket_id = :ticket_id", $ticketIdArray);
            }
            $this->processSendEmail($inserted_paymentId);
            $this->applyDataProtection($this->data);
        }
    }

    public function directPayment(string $payment_method, $data): bool
    {
        if ($payment_method == "Credit Card") {
            return $this->stripePayment($data);
        } elseif ($payment_method == "PayPal") {
            return $this->paypalPayment($data);
        }
        return false;
    }

    public function endSession()
    {
        session_unset();
        session_destroy();
    }

    public function applyDataProtection($data)
    {
        $this->dataProtection->purgeTemporaryData($data);
        $this->dataProtection->disableClientSideCaching();
        $this->unsetSessionvariable();
    }

    public function stripePayment($data): bool
    {
        $stripeGateway = new StripeGateway();
        $stripeAdapter = new StripeAdapter($stripeGateway);
        return $stripeAdapter->processPayment($data);
    }

    public function paypalPayment($data): bool
    {
        $paypalGateway = new paypalGateway();
        $paypalAdapter = new paypalAdapter($paypalGateway);
        return $paypalAdapter->processPayment($data);
    }

    public function getDataFromDatabase(string $table, string $attribute, string $id)
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

    public function getAllDataFromDatabase(string $table)
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

    public function updateDataInDatabase($table, $ClauseStr, $whereClause, $id)
    {
        try {
            $results = $this->db->update($table, $ClauseStr, $whereClause, $id);
            if ($results) {
                return $results;
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function calculateTotalAmount($tickets)
    {
        $total = 0;
        foreach ($tickets as $ticket) {
            $ticket = $ticket[0];
            $total += $ticket['price'] * $ticket['quantity'];
        }
        return $total;
    }

    public function calculateQuantity($tickets)
    {
        $total = 0;
        foreach ($tickets as $ticket) {
            $ticket = $ticket[0];
            $total += $ticket['quantity'];
        }
        return $total;
    }

    public function unsetSessionvariable()
    {
        unset($_SESSION['purchase_ticket']);
        unset($_SESSION['event_details']);
        unset($_SESSION['total_amount']);
        unset($_SESSION['selected_ticket_details']);
        unset($_SESSION['schedule_details']);
        unset($_SESSION['total_quantity']);
        unset($_SESSION['purchase_ticket_event']);
        unset($_SESSION['purchase_ticket_event_schedule']);
        unset($_SESSION['nameError']);
        unset($_SESSION['emailError']);
        unset($_SESSION['contactNumError']);
        unset($_SESSION['custData']);
    }

    public function unsetFormSessionVariable()
    {
        unset($_SESSION['nameError']);
        unset($_SESSION['emailError']);
        unset($_SESSION['contactNumError']);
    }

    public function processSendEmail($paymentId)
    {
        $custData = $_SESSION['custData'];
        $custName = $custData['name'];
        $custEmail = $custData['email'];
        $custContactNum = $custData['contactNum'];

        $mailer = new PHPMailer(true);
        try {
            $mailer->isSMTP();
            $mailer->Host = 'smtp.gmail.com';
            $mailer->SMTPAuth = true;
            $mailer->Username = 'lohjw-wm21@student.tarc.edu.my';
            $mailer->Password = 'sxjv myvf qodm uwkp';
            $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mailer->Port = 587;

            $email = "lohjw-wm21@student.tarc.edu.my";
            $messageHeader = "<title>Payment Successfull !</title>
                        <h1>Your Payment ID is $paymentId</h1>
                        <p>Thank you for your purchasing Mr/Ms: $custName !</p>
                        <p>Phone Number: $custContactNum</p>
                        <br><br>
                        <p>Please show this email to the counter before entry.</p>
                        ";

            $ticketDetails = $this->getDataFromDatabase("payment_ticket", "payment_id", $paymentId);
            $messageBody = "<table>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Quantity</th>
                        </tr>";

            foreach ($ticketDetails as $ticket) {
                $ticketData = $this->getDataFromDatabase("ticket", "ticket_id", $ticket['ticket_id']);
                $ticketId = $ticket['ticket_id'];
                $quantity = $ticket['quantity'];

                $messageBody .= "<tr>
                            <td>$ticketId</td>
                            <td>$quantity</td>
                        </tr>";
            }
            
            $mailer->addAddress($email);
            $mailer->isHTML(true);
            $mailer->Subject = "Payment Confirmation - Receipent : $custName";

            $link = '<a href="http://localhost/villain/view/events.php">To View More Event Details</a>';
            $mailer->Body = $messageHeader . '<br><br>' . $messageBody . '<br><br>' . $link;
            $mailer->setFrom('lohjw-wm21@student.tarc.edu.my', 'Villain Esports');

            $mailer->send();
        } catch (Exception $ex) {
            echo "Mailer Error: " . $mailer->ErrorInfo;
            echo $ex;
        }
    }

    public function validateInput($data)
    {
        if (!preg_match("/^[a-zA-Z-' ]*$/", $data['name'])) {
            $_SESSION['nameError'] = "Only letters and spaces are allowed in the name.";
        } else {
            unset($_SESSION['nameError']);
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['emailError'] = "Invalid email format.";
        } else {
            unset($_SESSION['emailError']);
        }

        if (!preg_match("/^\d{10}$/", $data['contactNum'])) {
            $_SESSION['contactNumError'] = "Contact number must be exactly 10 digits.";
        } else {
            unset($_SESSION['contactNumError']);
        }
    }
}