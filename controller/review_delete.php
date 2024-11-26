<?php
//SIASHUNFU
include '../view/admin/databaseconnect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $reviewId = filter_var($_POST['id'], FILTER_VALIDATE_INT);

    if ($reviewId) {
        try {
            $query = "DELETE FROM review_table WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':id', $reviewId, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo 'Review deleted successfully.';
            } else {
                echo 'No review found with the provided ID.';
            }
        } catch (PDOException $e) {
            echo 'Database error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }
    } else {
        echo 'Invalid review ID.';
    }
} else {
    echo 'Invalid request.';
}
?>
