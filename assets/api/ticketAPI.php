<?php

header('Content-Type: application/json');
$host = 'localhost';
$db = 'villain';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'login':
        login();
        break;
    case 'events':
        displayEvents();
        break;
    case 'sales_report':
        getSalesReport();
        break;
    case 'event_details':
        getEventDetails();
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}

function login() {
    global $pdo;

    $email = $_POST['email'];
    $password = md5($_POST['password']);  

    $stmt = $pdo->prepare('SELECT * FROM admin WHERE email = ? AND password = ? AND position = "Admin"');
    $stmt->execute([$email, $password]);
    $admin = $stmt->fetch();

    if ($admin) {
        echo json_encode(['status' => 'success', 'admin' => $admin]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid credentials or not an Admin']);
    }
}

function displayEvents() {
    global $pdo;

    $stmt = $pdo->query('SELECT * FROM villain');
    $events = $stmt->fetchAll();

    echo json_encode(['status' => 'success', 'events' => $events]);
}

function getSalesReport() {
    global $pdo;

    $event_id = $_POST['event_id'];
    $stmt = $pdo->prepare('SELECT * FROM schedule WHERE EventID = ?');
    $stmt->execute([$event_id]);
    $schedule = $stmt->fetch();

    if ($schedule) {
        $stmt = $pdo->prepare('SELECT * FROM ticket WHERE schedule_id = ?');
        $stmt->execute([$schedule['schedule_id']]);
        $tickets = $stmt->fetchAll();

        if ($tickets) {
            $total_sales = 0;
            $category_sales = [];

            foreach ($tickets as $ticket) {
                $total_sales += $ticket['price'] * $ticket['slot_sold'];
                $category_sales[$ticket['category']] = isset($category_sales[$ticket['category']]) ? $category_sales[$ticket['category']] + $ticket['slot_sold'] : $ticket['slot_sold'];
            }

            echo json_encode([
                'status' => 'success',
                'tickets' => $tickets,
                'total_sales' => $total_sales,
                'category_sales' => $category_sales
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No tickets found for this event']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No schedule found for this event']);
    }
}

function getEventDetails() {
    global $pdo;

    $event_id = $_POST['event_id'];
    $stmt = $pdo->prepare('SELECT EventName, StartDate FROM villain WHERE EventID = ?');
    $stmt->execute([$event_id]);
    $event = $stmt->fetch();

    if ($event) {
        echo json_encode([
            'status' => 'success',
            'event_name' => $event['EventName'],
            'event_date' => $event['StartDate']
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Event not found']);
    }
}
?>