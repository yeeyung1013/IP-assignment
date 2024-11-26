<?php
//SIASHUNFU
// review_load.php
include '../view/admin/databaseconnect.php'; // Ensure this path is correct
//include 'ReviewModel.php'; // Ensure this path is correct

session_start(); // Ensure session is started

if (isset($_SESSION['email'])) {
    $user_email = $_SESSION['email'];
} else {
    echo 'Error: User email not set in session.';
    exit;
}


function get_ratings($pdo) {
    $query = "
        SELECT 
            COUNT(*) as total_reviews,
            AVG(user_rating) as average_rating,
            SUM(CASE WHEN user_rating = 5 THEN 1 ELSE 0 END) as five_star_count,
            SUM(CASE WHEN user_rating = 4 THEN 1 ELSE 0 END) as four_star_count,
            SUM(CASE WHEN user_rating = 3 THEN 1 ELSE 0 END) as three_star_count,
            SUM(CASE WHEN user_rating = 2 THEN 1 ELSE 0 END) as two_star_count,
            SUM(CASE WHEN user_rating = 1 THEN 1 ELSE 0 END) as one_star_count
        FROM review_table
        WHERE archived_at IS NULL
    ";

    $stmt = $pdo->query($query);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if request is for admin or customer
    $isAdminRequest = isset($_POST['admin']) && $_POST['admin'] === 'true';

    if ($isAdminRequest) {
        // Admin: Fetch and display all reviews
        try {
            $reviewModel = new ReviewModel($pdo);
            $reviews = $reviewModel->getAllReviews(); 

            foreach ($reviews as $review) {
                $editButton = '<button class="btn btn-warning btn-sm edit_review" data-id="' . htmlspecialchars($review['id'], ENT_QUOTES, 'UTF-8') . '">Edit</button>';
                $deleteButton = '<button class="btn btn-danger btn-sm delete_review" data-id="' . htmlspecialchars($review['id'], ENT_QUOTES, 'UTF-8') . '">Delete</button>';
                $statusBadge = $review['status'] === 'not read' ? 'warning' : 'success';
                $statusText = htmlspecialchars($review['status'], ENT_QUOTES, 'UTF-8');

                echo '<div class="review-item mb-4 p-3 border rounded" data-review-id="' . htmlspecialchars($review['id'], ENT_QUOTES, 'UTF-8') . '">';
                echo '<p>Rating: ' . str_repeat('<i class="fas fa-star text-warning"></i>', (int) $review['user_rating']) . '</p>';
                echo '<p><strong>' . htmlspecialchars($review['user_name'], ENT_QUOTES, 'UTF-8') . '</strong> - <span class="review-date">' . date('F j, Y, g:i a', strtotime($review['datetime'])) . '</span></p>';
                echo '<p>' . htmlspecialchars($review['user_review'], ENT_QUOTES, 'UTF-8') . '</p>';
                echo '<p>Status: <span class="badge badge-' . $statusBadge . '">' . $statusText . '</span></p>';
                if (!empty($review['user_image'])) {
                    $imagePath = '../assets/reviewImage/' . htmlspecialchars($review['user_image'], ENT_QUOTES, 'UTF-8');
                    echo '<img src="' . $imagePath . '" alt="User image" class="img-fluid">';
                }
                echo '<div class="mt-2">' . $editButton . ' ' . $deleteButton . '</div>';
                echo '</div>';
            }
        } catch (PDOException $e) {
            echo 'Database error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }
    } else {
        // Customer's View: Fetch and display their own reviews and others' reviews
        // Get the user's email from session
        $user_email = isset($_SESSION['email']) ? $_SESSION['email'] : null;
        if (!$user_email) {
            echo 'Error: User not logged in.';
            exit;
        }

        // Pagination: Reviews per page
        $page = isset($_POST['page']) ? filter_var($_POST['page'], FILTER_VALIDATE_INT) : 1;
        $reviews_per_page = 5;
        $offset = ($page - 1) * $reviews_per_page;

        try {
            // Get rating statistics
            $ratings = get_ratings($pdo);

            // Display ratings (if needed in UI)
            echo '<div class="ratings mb-4" style="display:none;">';
            echo '<h3>Average Rating: <span id="average_rating">' . number_format($ratings['average_rating'], 1) . '</span> / 5</h3>';
            echo '<p>5 Star Reviews: <span id="total_five_star_review">' . $ratings['five_star_count'] . '</span></p>';
            echo '<p>4 Star Reviews: <span id="total_four_star_review">' . $ratings['four_star_count'] . '</span></p>';
            echo '<p>3 Star Reviews: <span id="total_three_star_review">' . $ratings['three_star_count'] . '</span></p>';
            echo '<p>2 Star Reviews: <span id="total_two_star_review">' . $ratings['two_star_count'] . '</span></p>';
            echo '<p>1 Star Reviews: <span id="total_one_star_review">' . $ratings['one_star_count'] . '</span></p>';
            echo '</div>';

            // Fetch and display all reviews made by the logged-in user (customer)
            $customerReviewsQuery = "SELECT * FROM review_table WHERE user_email = :user_email AND archived_at IS NULL ORDER BY datetime DESC";
            $stmt = $pdo->prepare($customerReviewsQuery);
            $stmt->bindValue(':user_email', $user_email, PDO::PARAM_STR);
            $stmt->execute();
            $customerReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($customerReviews) {
                echo '<h4>Your Reviews</h4>';
                foreach ($customerReviews as $customerReview) {
                    $editButton = '<button class="btn btn-warning btn-sm edit_review" data-id="' . htmlspecialchars($customerReview['id'], ENT_QUOTES, 'UTF-8') . '">Edit</button>';
                    $deleteButton = '<button class="btn btn-danger btn-sm delete_review" data-id="' . htmlspecialchars($customerReview['id'], ENT_QUOTES, 'UTF-8') . '">Delete</button>';
                    $statusBadge = $customerReview['status'] === 'not read' ? 'warning' : 'success';
                    $statusText = htmlspecialchars($customerReview['status'], ENT_QUOTES, 'UTF-8');
                    $adminReply = !empty($customerReview['admin_reply']) ? htmlspecialchars($customerReview['admin_reply'], ENT_QUOTES, 'UTF-8') : 'No reply yet.';

                    echo '<div class="customer-review mb-4 p-3 border rounded" data-review-id="' . htmlspecialchars($customerReview['id'], ENT_QUOTES, 'UTF-8') . '">';
                    echo '<p>Rating: ' . str_repeat('<i class="fas fa-star text-warning"></i>', (int) $customerReview['user_rating']) . '</p>';
                    echo '<p><strong>' . htmlspecialchars($customerReview['user_name'], ENT_QUOTES, 'UTF-8') . '</strong> - <span class="review-date">' . date('F j, Y, g:i a', strtotime($customerReview['datetime'])) . '</span></p>';
                    echo '<p>' . htmlspecialchars($customerReview['user_review'], ENT_QUOTES, 'UTF-8') . '</p>';
                    echo '<p>Status: <span class="badge badge-' . $statusBadge . '">' . $statusText . '</span></p>';
                    echo '<p>Admin Reply: ' . $adminReply . '</p>';

                    if (!empty($customerReview['user_image'])) {
                        $imagePath = '../assets/reviewImage' . htmlspecialchars($customerReview['user_image'], ENT_QUOTES, 'UTF-8');
                        echo '<img src="' . $imagePath . '" alt="User image" class="img-fluid">';
                    }

                    echo '<div class="mt-2">' . $editButton . ' ' . $deleteButton . '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>You have not submitted any reviews yet.</p>';
            }


// Fetch and display other reviews excluding the user's own
            $query = "SELECT * FROM review_table WHERE user_email != :user_email AND archived_at IS NULL ORDER BY datetime DESC LIMIT :limit OFFSET :offset";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':user_email', $user_email, PDO::PARAM_STR);
            $stmt->bindValue(':limit', $reviews_per_page, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display other reviews
            if ($reviews) {
                echo '<h4>Other Reviews</h4>';
                foreach ($reviews as $review) {
                    $statusBadge = $review['status'] === 'not read' ? 'warning' : 'success';
                    $statusText = htmlspecialchars($review['status'], ENT_QUOTES, 'UTF-8');
                    $adminReply = !empty($review['admin_reply']) ? htmlspecialchars($review['admin_reply'], ENT_QUOTES, 'UTF-8') : 'No reply yet.';

                    echo '<div class="review-item mb-4 p-3 border rounded" data-review-id="' . htmlspecialchars($review['id'], ENT_QUOTES, 'UTF-8') . '">';
                    echo '<p>Rating: ' . str_repeat('<i class="fas fa-star text-warning"></i>', (int) $review['user_rating']) . '</p>';
                    echo '<p><strong>' . htmlspecialchars($review['user_name'], ENT_QUOTES, 'UTF-8') . '</strong> - <span class="review-date">' . date('F j, Y, g:i a', strtotime($review['datetime'])) . '</span></p>';
                    echo '<p>' . htmlspecialchars($review['user_review'], ENT_QUOTES, 'UTF-8') . '</p>';
                    echo '<p>Status: <span class="badge badge-' . $statusBadge . '">' . $statusText . '</span></p>';
                    echo '<p>Admin Reply: ' . $adminReply . '</p>';

                    if (!empty($review['user_image'])) {
                        $imagePath = '../assets/reviewImage' . htmlspecialchars($review['user_image'], ENT_QUOTES, 'UTF-8');
                        echo '<img src="' . $imagePath . '" alt="User image" class="img-fluid">';
                    }

                    echo '</div>';
                }
            } else {
                echo '<p>No more reviews available.</p>';
            }
        } catch (PDOException $e) {
            echo 'Database error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }
    }
}
?>
