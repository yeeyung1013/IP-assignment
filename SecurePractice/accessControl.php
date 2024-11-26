<?php
/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 * @author Tan Chee Fung
 */

session_start();

function checkAccess() {
    if (!isset($_SESSION['email'])) {
        return false;
    }
    return true;
}

if (isset($_GET['action']) && $_GET['action'] === 'pay') {
    if (!checkAccess()) {
        $message = "You need to sign in first !!<a href='../view/index.php'>Click here</a>";
    } else {
        if (isset($_POST['selected_option'])) {
            $selectedTickets = $_POST['selected_option'];
            $_SESSION['purchase_ticket'] = []; 
            foreach ($selectedTickets as $ticketId => $quantity) {
                if ($quantity > 0) {
                    $_SESSION['purchase_ticket'][] = [
                        'ticket_id' => $ticketId,
                        'quantity' => $quantity
                    ];
                }
            }
            if (!empty($_SESSION['purchase_ticket'])) {
                header('Location: ../controller/paymentController.php');
                exit();
            } else {
                $message = "You don't have select ticket.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Access</title>
</head>
<body>

<?php if (isset($message)): ?>
    <div class="message" style="color: red; font-size: 18px; margin-top: 20px;">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

</body>
</html>
