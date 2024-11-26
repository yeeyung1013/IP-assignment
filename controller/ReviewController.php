<?php
//SIASHUNFU
require 'ReviewModel.php'; 


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
} catch (PDOException $e) {
    error_log('Database connection failed: ' . $e->getMessage());
    die('Something went wrong. Please try again later.');
}

$reviewModel = new ReviewModel($pdo);

if (isset($_POST["action"])) {
    if ($_POST["action"] == 'load_data') {
        $current_page = isset($_POST["page"]) ? intval($_POST["page"]) : 1;
        $reviews = $reviewModel->getReviews($current_page);

        $average_rating = 0;
        $total_review = 0;
        $five_star_review = 0;
        $four_star_review = 0;
        $three_star_review = 0;
        $two_star_review = 0;
        $one_star_review = 0;
        $total_user_rating = 0;
        $review_content = [];

        foreach ($reviews as $row) {
            $review_content[] = [
                'user_name'    => htmlspecialchars($row["user_name"], ENT_QUOTES, 'UTF-8'),
                'user_image'   => $row["user_image"] ? 'images/' . htmlspecialchars($row["user_image"], ENT_QUOTES, 'UTF-8') : 'images/default_image.png',
                'user_review'  => htmlspecialchars($row["user_review"], ENT_QUOTES, 'UTF-8'),
                'rating'       => htmlspecialchars($row["user_rating"], ENT_QUOTES, 'UTF-8'),
                'datetime'     => date('l jS, F Y h:i:s A', strtotime($row["datetime"])),
                'status'       => htmlspecialchars($row["status"], ENT_QUOTES, 'UTF-8')
            ];

            switch ($row["user_rating"]) {
                case 5: $five_star_review++; break;
                case 4: $four_star_review++; break;
                case 3: $three_star_review++; break;
                case 2: $two_star_review++; break;
                case 1: $one_star_review++; break;
            }

            $total_review++;
            $total_user_rating += $row["user_rating"];
        }

        if ($total_review > 0) {
            $average_rating = $total_user_rating / $total_review;
        }

        $output = [
            'average_rating'   => number_format($average_rating, 1),
            'total_review'     => $total_review,
            'five_star_review' => $five_star_review,
            'four_star_review' => $four_star_review,
            'three_star_review'=> $three_star_review,
            'two_star_review'  => $two_star_review,
            'one_star_review'  => $one_star_review,
            'reviews'          => $review_content
        ];

        echo json_encode($output);
    } elseif (isset($_POST["user_name"])) {
        $user_name = htmlspecialchars($_POST["user_name"], ENT_QUOTES, 'UTF-8');
        $user_review = htmlspecialchars($_POST["user_review"], ENT_QUOTES, 'UTF-8');
        $user_rating = isset($_POST["rating_data"]) ? intval($_POST["rating_data"]) : 0; 
        $user_image = null;

        try {
            if (!empty($_FILES["user_image"]["name"])) {
                $user_image = handleFileUpload($_FILES["user_image"]);
            }
            
            $captcha_response = isset($_POST['captcha_response']) ? $_POST['captcha_response'] : '';
            $captcha_result = verifyCaptcha($captcha_response);

            if (!$captcha_result || !$captcha_result->success) {
                throw new Exception('CAPTCHA validation failed');
            }

            $reviewModel->addReview($user_name, $user_review, $user_rating, $user_image);
            echo 'Your Review & Rating Successfully Submitted';
        } catch (Exception $e) {
            error_log('Error: ' . $e->getMessage());
            echo 'Something went wrong. Please try again later.';
        }
    } elseif (isset($_POST["update_status"])) {
        $review_id = isset($_POST["review_id"]) ? intval($_POST["review_id"]) : 0;
        $status = htmlspecialchars($_POST["status"], ENT_QUOTES, 'UTF-8');
        try {
            $reviewModel->updateReviewStatus($review_id, $status);
            echo 'Review status updated successfully';
        } catch (Exception $e) {
            error_log('Error updating status: ' . $e->getMessage());
            echo 'Something went wrong. Please try again later.';
        }
    } elseif ($_POST["action"] == 'generate_report') {
        try {
            $comments = $reviewModel->getCommentsReport();
            $xml = new SimpleXMLElement('<comments/>');

            foreach ($comments as $comment) {
                $comment_node = $xml->addChild('comment');
                $comment_node->addChild('user_name', htmlspecialchars($comment['user_name'], ENT_QUOTES, 'UTF-8'));
                $comment_node->addChild('user_review', htmlspecialchars($comment['user_review'], ENT_QUOTES, 'UTF-8'));
                $comment_node->addChild('user_rating', htmlspecialchars($comment['user_rating'], ENT_QUOTES, 'UTF-8'));
                $comment_node->addChild('datetime', htmlspecialchars($comment['datetime'], ENT_QUOTES, 'UTF-8'));
                $comment_node->addChild('status', htmlspecialchars($comment['status'], ENT_QUOTES, 'UTF-8'));
            }

            header('Content-Type: application/xml');
            echo $xml->asXML();
        } catch (Exception $e) {
            error_log('Error generating report: ' . $e->getMessage());
            echo 'Something went wrong. Please try again later.';
        }
    }
}

function verifyCaptcha($captcha_response) {
    $captcha_secret = '6LfwdEQqAAAAANESBssdJWT_nCMs3L5SqoTg5Bht'; // Replace with your secret key
    $captcha_verify_url = "https://www.google.com/recaptcha/api/siteverify";
    $captcha_data = [
        'secret'   => $captcha_secret,
        'response' => $captcha_response
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $captcha_verify_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($captcha_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $captcha_verify = curl_exec($ch);
    curl_close($ch);

    return json_decode($captcha_verify);
}

function handleFileUpload($file) {
    $file_name = $file["name"];
    $file_temp = $file["tmp_name"];
    $file_size = $file["size"];
    $file_type = mime_content_type($file_temp);
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $valid_extensions = ["jpg", "jpeg", "png"];

    if (in_array($file_extension, $valid_extensions) && ($file_type == "image/jpeg" || $file_type == "image/png")) {
        if ($file_size <= 2097152) { // 2MB size check
            $new_image_name = time() . '.' . $file_extension;
            $upload_path = 'images/' . $new_image_name;
            if (!is_dir('images')) {
                mkdir('images', 0777, true); 
            }
            if (move_uploaded_file($file_temp, $upload_path)) {
                return $new_image_name;
            } else {
                throw new Exception('Failed to upload image');
            }
        } else {
            throw new Exception('Image size should be less than 2MB');
        }
    } else {
        throw new Exception('Invalid image format. Only JPG, JPEG, and PNG are allowed');
    }
}

?>
