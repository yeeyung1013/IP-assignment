<?php
// fetch_review.php

include 'databaseconnect.php'; // Ensure this path is correct

session_start(); // Ensure the session is started to use session variables

// Check if request is POST and ID is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $reviewId = filter_var($_POST['id'], FILTER_VALIDATE_INT);

    if ($reviewId) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM review_table WHERE id = :id");
            $stmt->bindValue(':id', $reviewId, PDO::PARAM_INT);
            $stmt->execute();
            $review = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($review) {
                echo json_encode($review);
            } else {
                echo json_encode(['error' => 'Review not found.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Database error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8')]);
        }
    } else {
        echo json_encode(['error' => 'Invalid ID provided.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request.']);
}
?>
