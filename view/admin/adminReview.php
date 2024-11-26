<?php
/*<!--SIASHUNFU-->*/
require 'ReviewModel.php';
//adminReview.php
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
    die('Something went wrong. Please try again later.');
}

// Handle AJAX requests
if (isset($_POST["action"])) {
    $action = $_POST["action"];

    
    error_log("Received action: " . $action);

    switch ($action) {
        case 'mark_as_unread':
            $review_id = isset($_POST["review_id"]) ? intval($_POST["review_id"]) : 0;
            try {
                $reviewModel->updateReviewStatus($review_id, 'not read');
                echo 'Review marked as unread successfully';
            } catch (Exception $e) {
                error_log('Error updating status: ' . $e->getMessage());
                echo 'Something went wrong. Please try again later.';
            }
            exit;

        case 'update_status':
            $review_id = isset($_POST["review_id"]) ? intval($_POST["review_id"]) : 0;
            $status = isset($_POST["status"]) ? $_POST["status"] : 'read';
            try {
                $reviewModel->updateReviewStatus($review_id, $status);
                echo 'Review status updated successfully';
            } catch (Exception $e) {
                error_log('Error updating status: ' . $e->getMessage());
                echo 'Something went wrong. Please try again later.';
            }
            exit;

        case 'archive_review':
            $review_id = isset($_POST["review_id"]) ? intval($_POST["review_id"]) : 0;
            try {
                $reviewModel->archiveReview($review_id);
                echo 'Review archived successfully';
            } catch (Exception $e) {
                error_log('Error archiving review: ' . $e->getMessage());
                echo 'Something went wrong. Please try again later.';
            }
            exit;

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

        case 'load_more':
            $offset = isset($_POST["offset"]) ? intval($_POST["offset"]) : 0;
            $reviews = $reviewModel->getReviewsWithLimit($offset, 5); 
            echo json_encode($reviews);
            exit;
            
              case 'submit_reply':
            $review_id = isset($_POST["review_id"]) ? intval($_POST["review_id"]) : 0;
            $admin_reply = isset($_POST["admin_reply"]) ? trim($_POST["admin_reply"]) : '';
            
            if (!empty($admin_reply) && $review_id > 0) {
                try {
                    
                    $reviewModel->addAdminReply($review_id, $admin_reply);
                    echo 'Reply submitted successfully';
                } catch (Exception $e) {
                    error_log('Error submitting reply: ' . $e->getMessage());
                    echo 'Something went wrong. Please try again later.';
                }
            } else {
                echo 'Invalid input. Please ensure all fields are filled out.';
            }
            exit;

        default:
            echo 'Invalid action';
            exit;
    }
}

// Fetch initial batch of 5 reviews
$reviews = $reviewModel->getReviewsWithLimit(0, 5);
$totalReviews = $reviewModel->countTotalReviews();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin - Review Management</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container mt-5">
            <h2>Manage Reviews</h2>
            <div class="mb-4">
                <a href="home.php" class="btn btn-outline-primary">Back To Home</a>
                <a href="reviewXMLreport.php" class="btn btn-outline-primary">XML Report</a>
                <a href="reviewXSLTReport.php" class="btn btn-outline-secondary">XSLT Report</a>
                <!-- <a href="reviewXPathReport.php" class="btn btn-outline-success">XPath Report</a> -->
            </div>
            <a href="archivedReview.php" class="btn btn-secondary mb-3">Manage Archived Reviews</a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Review ID</th>
                        <th>User Name</th>
                        <th>Review</th>
                        <th>Rating</th>
                        <th>Image Name</th>
                        <th>Status</th>
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
                            <td>
                                <span class="badge badge-<?php echo $review['status'] === 'not read' ? 'warning' : 'success'; ?>">
                                    <?php echo htmlspecialchars($review['status'], ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm update-status" data-id="<?php echo htmlspecialchars($review['id'], ENT_QUOTES, 'UTF-8'); ?>" data-status="read">Mark as Read</button>
                                <button class="btn btn-warning btn-sm mark-unread" data-id="<?php echo htmlspecialchars($review['id'], ENT_QUOTES, 'UTF-8'); ?>">Mark as Unread</button>
                                <button class="btn btn-danger btn-sm archive-review" data-id="<?php echo htmlspecialchars($review['id'], ENT_QUOTES, 'UTF-8'); ?>">Archive</button>
                                <button class="btn btn-danger btn-sm delete-review" data-id="<?php echo htmlspecialchars($review['id'], ENT_QUOTES, 'UTF-8'); ?>">Delete</button>

                                <!-- Admin reply form -->
                                <form class="admin-reply-form" data-id="<?php echo htmlspecialchars($review['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <textarea name="admin_reply" placeholder="Write your reply here..." required></textarea>
                                    <button type="submit">Submit Reply</button>
                                </form>

                                <?php if (!empty($review['admin_reply'])): ?>
                                    <div class="admin-reply mt-3">
                                        <strong>Admin replied on <?php echo htmlspecialchars($review['reply_datetime'], ENT_QUOTES, 'UTF-8'); ?>:</strong>
                                        <p><?php echo htmlspecialchars($review['admin_reply'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Load More button -->
            <?php if ($totalReviews > 5): ?>
                <div class="text-center">
                    <button id="load_more" class="btn btn-info">Load More</button>
                </div>
            <?php endif; ?>
        </div>

        <script>
            $(document).ready(function () {
                var offset = 5; 
                var totalReviews = <?php echo $totalReviews; ?>;

                // Load more reviews
                $('#load_more').on('click', function () {
                    $.post('adminReview.php', {action: 'load_more', offset: offset}, function (response) {
                        var reviews = JSON.parse(response);
                        reviews.forEach(function (review) {
                            $('#review_table_body').append(`
                                <tr>
                                    <td>${review.id}</td>
                                    <td>${review.user_name}</td>
                                    <td>${review.user_review}</td>
                                    <td>${review.user_rating}</td>
                                    <td>${review.user_image ? review.user_image : 'No Image'}</td>
                                    <td><span class="badge badge-${review.status === 'not read' ? 'warning' : 'success'}">${review.status}</span></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm update-status" data-id="${review.id}" data-status="read">Mark as Read</button>
                                        <button class="btn btn-warning btn-sm mark-unread" data-id="${review.id}">Mark as Unread</button>
                                        <button class="btn btn-danger btn-sm archive-review" data-id="${review.id}">Archive</button>
                                        <button class="btn btn-danger btn-sm delete-review" data-id="${review.id}">Delete</button>

                                        <form class="admin-reply-form" data-id="${review.id}">
                                            <textarea name="admin_reply" placeholder="Write your reply here..." required></textarea>
                                            <button type="submit">Submit Reply</button>
                                        </form>

                                        ${review.admin_reply ? `<div class="admin-reply mt-3">
                                            <strong>Admin replied on ${review.reply_datetime}:</strong>
                                            <p>${review.admin_reply}</p>
                                        </div>` : ''}
                                    </td>
                                </tr>
                            `);
                        });

                        offset += 5;

                        if (offset >= totalReviews) {
                            $('#load_more').hide(); 
                        }
                    });
                });

                // Mark as unread
                $(document).on('click', '.mark-unread', function () {
                    var review_id = $(this).data('id');
                    $.post('adminReview.php', {action: 'mark_as_unread', review_id: review_id}, function (response) {
                        alert(response);
                        location.reload(); 
                    });
                });

                // Update status
                $(document).on('click', '.update-status', function () {
                    var review_id = $(this).data('id');
                    var status = $(this).data('status');
                    $.post('adminReview.php', {action: 'update_status', review_id: review_id, status: status}, function (response) {
                        alert(response);
                        location.reload();
                    });
                });

                // Archive review
                $(document).on('click', '.archive-review', function () {
                    var review_id = $(this).data('id');
                    $.post('adminReview.php', {action: 'archive_review', review_id: review_id}, function (response) {
                        alert(response);
                        location.reload();
                    });
                });

                // Delete review
                $(document).on('click', '.delete-review', function () {
                    var review_id = $(this).data('id');
                    $.post('adminReview.php', {action: 'delete_review', review_id: review_id}, function (response) {
                        alert(response);
                        location.reload();
                    });
                });

                // Handle admin reply form submission
                $(document).on('submit', '.admin-reply-form', function (event) {
                    event.preventDefault(); // Prevent the default form submission behavior
                    var review_id = $(this).data('id');
                    var admin_reply = $(this).find('textarea[name="admin_reply"]').val();

                    $.post('adminReview.php', {action: 'submit_reply', review_id: review_id, admin_reply: admin_reply}, function (response) {
                        alert(response);
                        location.reload();
                    });
                });
            });
        </script>
    </body>
</html>
