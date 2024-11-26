<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "villain";

$conn = new mysqli($servername, $username, $password, $dbname);

$method = $_SERVER['REQUEST_METHOD'];
$endpoint = $_GET['endpoint'] ?? '';

switch ($method) {
    case 'GET':
        if (preg_match('/^payment\/(\d+)$/', $endpoint, $matches)) {
            $cust_id = $matches[1];
            
            $sql = "SELECT * FROM payment WHERE cust_id = " . $conn->real_escape_string($cust_id);
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                $payments = [];
                
                while ($payment = $result->fetch_assoc()) {
                    $payment_id = $payment['payment_id'];
                    
                    $sqlTickets = "SELECT pt.quantity, t.ticket_id, price
                                   FROM payment_ticket pt
                                   JOIN ticket t ON pt.ticket_id = t.ticket_id
                                   WHERE pt.payment_id = " . $conn->real_escape_string($payment_id);
                    $ticketResult = $conn->query($sqlTickets);
                    
                    $tickets = [];
                    if ($ticketResult->num_rows > 0) {
                        while ($ticket = $ticketResult->fetch_assoc()) {
                            $tickets[] = $ticket;
                        }
                    }
                    
                    $payment['tickets'] = $tickets;
                    
                    $payments[] = $payment;
                }
                
                echo json_encode($payments);
            } else {
                echo json_encode(['error' => 'No payments found for the given customer ID']);
            }
        } else {
            echo json_encode(['error' => 'Invalid endpoint']);
        }
        break;
    default:
        echo json_encode(['error' => 'Method not allowed']);
        break;
}

$conn->close();
