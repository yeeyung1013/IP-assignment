

<?php
//SIASHUNFU
header("Access-Control-Allow-Origin: *"); // Allow all origins. For production, specify the origin.
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow these methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow these headers

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Handle preflight request
    http_response_code(200);
    exit;
}


session_start(); 

if (!isset($_SESSION["email"])) {
    echo "alert('You must be logged in to submit a review.');";
 
    exit;
}



include '../view/admin/databaseconnect.php'; // Ensure this path is correct


function filterBadWords($text) {
    $apiUrl = 'http://localhost:8081/api/submit-comment'; 
    $data = json_encode(['comment' => $text]);

   
    error_log('Data Sent to Go API: ' . $data);

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    
    // Execute request and capture the response
    $response = curl_exec($ch);

    // Check for errors during the request
    if ($response === false) {
        error_log('Curl error: ' . curl_error($ch)); 
        return $text; 
    }

    // Log the response from the Go API
    error_log('Go API Response: ' . $response);

    // Close curl
    curl_close($ch);

    // Parse the JSON response
    $responseData = json_decode($response, true);

    // Check if 'comment' exists in the response and return it, otherwise return original text
    return $responseData['comment'] ?? $text;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    
    // Check if required fields are set
    if (isset($_POST['user_name'], $_POST['user_review'], $_POST['rating_data'], $_POST['captcha_response'])) {
        // Get the logged-in user's email from the session
        $user_email = $_SESSION["email"] ?? ''; // Default to empty string if not set

        $user_name = htmlspecialchars($_POST['user_name'], ENT_QUOTES, 'UTF-8');
        $user_review = htmlspecialchars($_POST['user_review'], ENT_QUOTES, 'UTF-8');
        $rating_data = (int)$_POST['rating_data'];
        $captcha_response = $_POST['captcha_response'];

        // Validate CAPTCHA response using cURL
        $secret_key = '6LfwdEQqAAAAANESBssdJWT_nCMs3L5SqoTg5Bht'; 
        $captcha_verify_url = 'https://www.google.com/recaptcha/api/siteverify';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $captcha_verify_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'secret' => $secret_key,
            'response' => $captcha_response
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $responseKeys = json_decode($response, true);

        // Debugging: Log CAPTCHA response and verification result
        error_log('CAPTCHA Response: ' . $captcha_response);
        error_log('CAPTCHA Verification Response: ' . json_encode($responseKeys));

        if ($responseKeys['success']) {
            // Filter the review text for bad words
            $user_review = filterBadWords($user_review);

            // Handle file upload if present
            $user_image = null;
            if (isset($_FILES['user_image']) && $_FILES['user_image']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['user_image']['tmp_name'];
                $fileName = $_FILES['user_image']['name'];
                $fileSize = $_FILES['user_image']['size'];
                $fileType = $_FILES['user_image']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));

                $allowedExtensions = ['jpg', 'jpeg', 'png'];
                if (in_array($fileExtension, $allowedExtensions) && $fileSize <= 2 * 1024 * 1024) { // 2MB limit
                    $uploadFileDir = '../assets/reviewImage';
                    if (!is_dir($uploadFileDir)) {
                        mkdir($uploadFileDir, 0777, true);
                    }
                    $newFileName = uniqid() . '.' . $fileExtension; 
                    $dest_path = $uploadFileDir . $newFileName;

                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $user_image = $newFileName; 
                    } else {
                        echo 'Error uploading the file. Please try again.';
                        exit;
                    }
                } else {
                    echo 'Only JPG, JPEG, and PNG files up to 2MB are allowed.';
                    exit;
                }
            }

            try {
                // Prepare and execute the SQL statement to insert the review
                $stmt = $pdo->prepare("INSERT INTO review_table (user_name, user_review, user_rating, user_image, datetime, status, user_email) VALUES (:user_name, :user_review, :user_rating, :user_image, NOW(), 'not read', :user_email)");
                $stmt->bindParam(':user_name', $user_name);
                $stmt->bindParam(':user_review', $user_review);
                $stmt->bindParam(':user_rating', $rating_data, PDO::PARAM_INT);
                $stmt->bindParam(':user_image', $user_image);
                $stmt->bindParam(':user_email', $user_email);
                if ($stmt->execute()) {
                    echo 'Your review and rating have been successfully submitted.';
                } else {
                    echo 'Error saving review: ' . implode(', ', $stmt->errorInfo());
                }
            } catch (PDOException $e) {
                echo 'Database error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
            }
        } else {
            echo 'CAPTCHA validation failed. Please try again.';
        }
    } else {
        echo 'Required fields are missing.';
    }
} else {
    echo 'Invalid request method.';
}
?>
