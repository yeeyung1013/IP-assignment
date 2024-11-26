<?php

//SIASHUNFU
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization"); 

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
 
    http_response_code(200);
    exit;
}


require_once '../view/admin/databaseconnect.php';

function filterBadWords($text) {
    $apiUrl = 'http://localhost:8081/api/submit-comment'; 
    $data = json_encode(['comment' => $text]); 


    error_log('Data Sent to Go API: ' . $data);

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    
 
    $response = curl_exec($ch);

  
    if ($response === false) {
        error_log('Curl error: ' . curl_error($ch)); 
        return $text; 
    }

   
    error_log('Go API Response: ' . $response);

 
    curl_close($ch);


    $responseData = json_decode($response, true);

   
    return $responseData['comment'] ?? $text; // Change 'review' to 'comment'
}


// Retrieve POST data
$review_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$review_text = isset($_POST['review']) ? trim($_POST['review']) : '';
$rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
$user_image = isset($_FILES['user_image']) ? $_FILES['user_image'] : null;

// Filter the review text for bad words before validation
$review_text = filterBadWords($review_text);

// Validate input data after filtering
if ($review_id <= 0 || empty($review_text) || $rating < 1 || $rating > 5) {
    echo json_encode(['success' => false, 'error' => 'Invalid input data.']);
    exit;
}

try {

    $stmt = $pdo->prepare("UPDATE review_table SET user_review = :review_text, user_rating = :user_rating WHERE id = :id");
    $stmt->bindParam(':review_text', $review_text);
    $stmt->bindParam(':user_rating', $rating, PDO::PARAM_INT);
    $stmt->bindParam(':id', $review_id, PDO::PARAM_INT);

 if ($stmt->execute()) {
   
    if (isset($_FILES['user_image']) && $_FILES['user_image']['error'] === UPLOAD_ERR_OK) {
        // Extract file details
        $fileTmpPath = $_FILES['user_image']['tmp_name'];
        $fileName = $_FILES['user_image']['name'];
        $fileSize = $_FILES['user_image']['size'];
        $fileType = $_FILES['user_image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

  
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

        if (!in_array($fileExtension, $allowedExtensions) || !in_array($fileType, $allowedTypes)) {
            echo json_encode(['success' => false, 'error' => 'Invalid image type.']);
            exit;
        }
        if ($fileSize > 2 * 1024 * 1024) { // 2MB limit
            echo json_encode(['success' => false, 'error' => 'Image size exceeds 2MB.']);
            exit;
        }

      
        $uploadFileDir = '../assets/reviewImage';
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true); 
        }

        $newFileName = uniqid() . '.' . $fileExtension; 
        $dest_path = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
      
            $stmt = $pdo->prepare("UPDATE review_table SET user_image = :user_image WHERE id = :id");
            $stmt->bindParam(':user_image', $newFileName);
            $stmt->bindParam(':id', $review_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Review and image uploaded successfully.']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Error saving image path to the database.']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to upload image.']);
        }
    }



        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error executing update statement: ' . implode(', ', $stmt->errorInfo())]);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Database error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8')]);
}
?>