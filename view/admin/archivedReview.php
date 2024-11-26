
<?php
require 'ReviewModel.php';

// archivedReview.php<!--SIASHUNFU-->

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
    $reviewModel = new ReviewModel($pdo); // Initialize ReviewModel here
} catch (PDOException $e) {
    error_log('Database connection failed: ' . $e->getMessage());
    die('Something went wrong. Please try again later.');
}

// Handle AJAX requests
if (isset($_POST["action"])) {
    switch ($_POST["action"]) {
        case 'delete_review':
            $review_id = isset($_POST["review_id"]) ? intval($_POST["review_id"]) : 0;
            try {
                $reviewModel->deleteReview($review_id);
                echo 'Review deleted successfully';
            } catch (Exception $e) {
                error_log('Error deleting review: ' . $e->getMessage());
                echo 'Something went wrong. Please try again later.';
            }
            exit;

        default:
            echo 'Invalid action';
            exit;
    }
}

// Fetch archived reviews from the database
$reviews = $reviewModel->getArchivedReviews();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Archived Reviews</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container mt-5">
            <h2>Archived Reviews</h2>
            <a href="adminReview.php" class="btn btn-secondary mb-3">Back to Reviews</a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Review ID</th>
                        <th>User Name</th>
                        <th>Review</th>
                        <th>Rating</th>
                        <th>Image Name</th>
                        <th>Archived At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="review_table_body">
                    <?php foreach ($reviews as $review): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($review['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($review['user_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($review['user_review'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($review['user_rating'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($review['user_image'] ? $review['user_image'] : 'No Image', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($review['archived_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                               <button class="btn btn-secondary btn-sm restore-review" data-id="<?php echo htmlspecialchars($review['id'], ENT_QUOTES, 'UTF-8'); ?>">Restore</button>

                                <button class="btn btn-danger btn-sm delete-review" data-id="<?php echo htmlspecialchars($review['id'], ENT_QUOTES, 'UTF-8'); ?>">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <script>
  $(document).ready(function () {
    // Restore review
  $(document).on('click', '.restore-review', function () {
    var reviewId = $(this).data('id');
    console.log("Restoring review with ID: " + reviewId); 
    if (confirm('Are you sure you want to restore this review?')) {
        $.post('adminActions.php', {action: 'restore_review', review_id: reviewId}, function (response) {
            alert(response);
            location.reload(); 
        }).fail(function () {
            alert('Something went wrong. Please try again later.');
        });
    }
});




    // Delete review
    $(document).on('click', '.delete-review', function () {
        var reviewId = $(this).data('id');
        if (confirm('Are you sure you want to permanently delete this review?')) {
            $.post('adminActions.php', {action: 'delete_review', review_id: reviewId}, function (response) {
                alert(response);
                location.reload(); 
            }).fail(function () {
                alert('Something went wrong. Please try again later.');
            });
        }
    });
});

        </script>
    </body>
</html>
