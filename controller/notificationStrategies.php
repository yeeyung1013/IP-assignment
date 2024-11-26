<?php

interface NotificationStrategy {

    public function sendNotification($message);
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './includes/PHPMailer.php';
require './includes/SMTP.php';
require './includes/Exception.php';

class EmailNotification implements NotificationStrategy {

    private $mailer;
    private $dbConnection;

    public function __construct($dbConnection) {
        $this->dbConnection = $dbConnection;
        $this->mailer = new PHPMailer(true);
        try {
            $this->mailer->isSMTP();
            $this->mailer->Host = 'smtp.gmail.com';
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = 'ongyy-wm21@student.tarc.edu.my';
            $this->mailer->Password = 'aezm ffwz jqzc pbap';
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port = 587;

            $this->mailer->setFrom('your-email@gmail.com', 'Mailer');
        } catch (Exception $e) {
            echo "Mailer Error: " . $this->mailer->ErrorInfo;
        }
    }

    public function sendNotification($message) {
        $query = "SELECT DISTINCT email FROM customer";
        $result = $this->dbConnection->query($query);

        if ($result) {
            echo "Number of unique emails: " . $result->num_rows . "<br>";
            while ($row = $result->fetch_assoc()) {
                $this->sendEmail($row['email'], $message);
            }
        } else {
            echo "No customers found to send notifications.";
        }
    }

    private function sendEmail($email, $message) {
        try {
            $this->mailer->addAddress($email);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'New Event Notification';

            $link = '<a href="http://localhost/villain/view/events.php">To View More Event Details</a>';
            $this->mailer->Body = $message . '<br><br>' . $link;

            $this->mailer->send();
            echo "Email sent to: $email with message: $message<br>";
        } catch (Exception $e) {
            echo "Failed to send email to: $email. Error: {$this->mailer->ErrorInfo}<br>";
        }
    }

}

use Twilio\Rest\Client;

require_once './includes/src/Twilio/autoload.php';

class SMSNotification implements NotificationStrategy {

    private $twilio;

    public function __construct($dbConnection) {
        $this->dbConnection = $dbConnection;
        $this->twilio = new Client('AC33b1cb3019b9aa118e6ae03353127a92', '03b140c1ae5320115c17a05651ba79dd');
    }

    public function sendNotification($message) {
        $query = "SELECT DISTINCT phone FROM customer";
        $result = $this->dbConnection->query($query);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->sendSMS($row['phone'], $message);
            }
        } else {
            echo "No customers found to send SMS.";
        }
    }

    private function sendSMS($phoneNumber, $message) {
        try {
            $formattedPhoneNumber = '+60' . ltrim($phoneNumber, '0');

            $this->twilio->messages->create(
                    $formattedPhoneNumber,
                    [
                        'from' => '+1 252 316 6552',
                        'body' => $message
                    ]
            );
            echo "SMS sent to: $formattedPhoneNumber with message: $message<br>";
        } catch (Exception $e) {
            echo "Failed to send SMS to: $formattedPhoneNumber. Error: {$e->getMessage()}<br>";
        }
    }

}

?>