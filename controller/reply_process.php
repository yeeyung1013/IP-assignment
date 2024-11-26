<?php
//SIASHUNFU
include '../view/admin/databaseconnect.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    if (isset($_POST['review_id']) && isset($_POST['reply_text'])) {
        $review_id = filter_var($_POST['review_id'], FILTER_VALIDATE_INT);
        $reply_text = trim($_POST['reply_text']);

        if ($review_id && !empty($reply_text)) {
            // Try inserting the reply into the database
            try {
                $query = "INSERT INTO replies (review_id, reply_text, replied_at) VALUES (:review_id, :reply_text, NOW())";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':review_id', $review_id, PDO::PARAM_INT);
                $stmt->bindParam(':reply_text', $reply_text, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Reply added successfully']);
                } else {
                    // Log failure for debugging
                    error_log("Reply insertion failed: " . json_encode($stmt->errorInfo()));
                    echo json_encode(['success' => false, 'message' => 'Failed to add reply.']);
                }
            } catch (PDOException $e) {
                error_log("Database error: " . $e->getMessage());
                echo json_encode(['success' => false, 'message' => 'Database error.']);
            }
        } else {
            error_log("Invalid reply data: review_id or reply_text missing.");
            echo json_encode(['success' => false, 'message' => 'Invalid reply data.']);
        }
    } else {
        error_log("Required fields missing in the POST request.");
        echo json_encode(['success' => false, 'message' => 'Required fields missing.']);
    }
} else {
    error_log("Invalid request method.");
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
