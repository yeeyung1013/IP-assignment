
<?php

//adminAaction.php<!--SIASHUNFU-->
require 'ReviewModel.php';

// Database connection settings
$dsn = 'mysql:host=localhost;dbname=villain;charset=utf8';
$username = 'root';
$password = '';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
    $reviewModel = new ReviewModel($pdo); 
} catch (PDOException $e) {
    error_log('Database connection failed: ' . $e->getMessage());
    die(json_encode(['success' => false, 'message' => 'Something went wrong. Please try again later.']));
}

// Handle AJAX requests
if (isset($_POST["action"])) {
    $action = $_POST["action"];

  
    error_log("Received action: " . $action);

    switch ($action) {
        case 'admin_reply':
            $review_id = isset($_POST["review_id"]) ? intval($_POST["review_id"]) : 0;
            $admin_reply = isset($_POST["admin_reply"]) ? trim($_POST["admin_reply"]) : '';

            if ($review_id <= 0) {
                echo json_encode(['success' => false, 'message' => 'Invalid review ID']);
                exit;
            }

            if (empty($admin_reply)) {
                echo json_encode(['success' => false, 'message' => 'Admin reply cannot be empty.']);
                exit;
            }

            try {
                $reviewModel->addAdminReply($review_id, $admin_reply);
                echo json_encode(['success' => true, 'message' => 'Admin reply added successfully']);
            } catch (Exception $e) {
                error_log('Error adding admin reply: ' . $e->getMessage());
                echo json_encode(['success' => false, 'message' => 'Something went wrong. Please try again later.']);
            }
            exit;

        case 'archive_review':
            $review_id = isset($_POST["review_id"]) ? intval($_POST["review_id"]) : 0;

            if ($review_id <= 0) {
                echo json_encode(['success' => false, 'message' => 'Invalid review ID']);
                exit;
            }

            try {
                $reviewModel->archiveReview($review_id); 
                echo json_encode(['success' => true, 'message' => 'Review archived successfully']);
            } catch (Exception $e) {
                error_log('Error archiving review: ' . $e->getMessage());
                echo json_encode(['success' => false, 'message' => 'Something went wrong. Please try again later.']);
            }
            exit;




        case 'delete_review':
            $review_id = isset($_POST["review_id"]) ? intval($_POST["review_id"]) : 0;

            if ($review_id <= 0) {
                echo json_encode(['success' => false, 'message' => 'Invalid review ID']);
                exit;
            }

            try {
                $reviewModel->deleteReview($review_id);
                echo json_encode(['success' => true, 'message' => 'Review deleted permanently']);
            } catch (Exception $e) {
                error_log('Error deleting review permanently: ' . $e->getMessage());
                echo json_encode(['success' => false, 'message' => 'Something went wrong. Please try again later.']);
            }

            exit;


        case 'restore_review':
            $review_id = isset($_POST["review_id"]) ? intval($_POST["review_id"]) : 0;
            try {
               
                    if($reviewModel->restoreReview($review_id)){
                    echo 'Review restored successfully';
                    }else{
                        throw new Exception();
                    }
            } catch (Exception $e) {
                error_log('Error restoring review: ' . $e->getMessage());
                echo 'Something went wrong. Please try again later.';
            }
            exit;


       
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No action specified']);
}
?>
