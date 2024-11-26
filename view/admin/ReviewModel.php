<?php

require '../../controller/ReviewCaretaker.php';
require '../../controller/ReviewOriginator.php';
require '../../model/review.php';

class ReviewModel {

    private $pdo;
    private $caretaker;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->caretaker = new ReviewCaretaker($pdo); // Initialize caretaker
    }

    // Fetch all reviews without pagination
    public function getAllReviews() {
        $query = "SELECT * FROM review_table WHERE archived_at IS NULL ORDER BY datetime DESC";
        $statement = $this->pdo->prepare($query);

        try {
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database query failed: ' . $e->getMessage());
            throw new Exception('Unable to retrieve reviews. Please try again later.');
        }
    }

    // In ReviewModel.php


    public function getReviewsWithLimit($offset, $limit) {
        // Only fetch reviews that are not archived (archived_at is NULL)
        $sql = "SELECT * FROM review_table WHERE archived_at IS NULL ORDER BY datetime DESC LIMIT :offset, :limit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countTotalReviews() {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total_reviews FROM review_table");
            $stmt->execute();
            $result = $stmt->fetch();
            return $result['total_reviews'];
        } catch (PDOException $e) {
            error_log("Error counting total reviews: " . $e->getMessage());
            return 0; // Default to 0 if there's an error
        }
    }

    // Fetch reviews with pagination
    public function getReviews($current_page = 1, $reviews_per_page = 5) {
        $offset = ($current_page - 1) * $reviews_per_page;
        $query = "SELECT * FROM review_table WHERE archived_at IS NULL ORDER BY datetime DESC LIMIT :limit OFFSET :offset";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':limit', $reviews_per_page, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);

        try {
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database query failed: ' . $e->getMessage());
            throw new Exception('Unable to retrieve reviews. Please try again later.');
        }
    }

    // Add a review
    public function addReview($user_name, $user_review, $user_rating, $user_image) {
        $query = "
        INSERT INTO review_table 
        (user_name, user_review, user_rating, user_image, datetime, status) 
        VALUES (:user_name, :user_review, :user_rating, :user_image, NOW(), 'not read')
        ";
        $statement = $this->pdo->prepare($query);
        $params = array(
            ':user_name' => $user_name,
            ':user_review' => $user_review,
            ':user_rating' => $user_rating,
            ':user_image' => $user_image
        );

        try {
            $statement->execute($params);
        } catch (PDOException $e) {
            error_log('Error adding review: ' . $e->getMessage());
            throw new Exception('Unable to submit your review. Please try again later.');
        }
    }

    // Update review status
    public function updateReviewStatus($review_id, $status) {
        $query = "UPDATE review_table SET status = :status WHERE id = :review_id";
        $statement = $this->pdo->prepare($query);
        $params = array(
            ':status' => $status,
            ':review_id' => $review_id
        );

        try {
            $statement->execute($params);
        } catch (PDOException $e) {
            error_log('Error updating status: ' . $e->getMessage());
            throw new Exception('Unable to update review status. Please try again later.');
        }
    }

    // Archive a review
    public function archiveReview($review_id) {
        // Before archiving, ensure memento is saved
        $stmt = $this->pdo->prepare("SELECT * FROM review_table WHERE id = ?");
        $stmt->execute([$review_id]);
        $review_data = $stmt->fetch();

        try{
        if ($review_data) {
            $review = new Review(
                $review_data['id'],    
                $review_data['user_name'],    
                $review_data['user_review'],   
                $review_data['user_rating'],  
                $review_data['user_image'],    
                $review_data['datetime'],   
                $review_data['status'],      
                $review_data['archived_at'],     
                $review_data['admin_reply'],       
                $review_data['reply_datetime'],    
                $review_data['user_email']        
            );

            $originator = new ReviewOriginator($review->getId(), $review->getStatus());
            $this->caretaker->saveMemento($originator->saveToMemento());

            $stmt = $this->pdo->prepare("UPDATE review_table SET status = 'archived', archived_at = NOW() WHERE id = ?");
            return $stmt->execute([$review->getId()]);
        }
        }catch(Exception $e){
            echo $e;
        }
        return false;
    }

    public function restoreReview($review_id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM review_table WHERE id = ?");
            $stmt->execute([$review_id]);
            $review_data = $stmt->fetch();

            if ($review_data && $review_data['status'] === 'archived') {
                $review = new Review(
                    $review_data['id'],    
                    $review_data['user_name'],    
                    $review_data['user_review'],   
                    $review_data['user_rating'],  
                    $review_data['user_image'],    
                    $review_data['datetime'],   
                    $review_data['status'],      
                    $review_data['archived_at'],     
                    $review_data['admin_reply'],       
                    $review_data['reply_datetime'],    
                    $review_data['user_email']        
                );
                $memento = $this->caretaker->getMemento($review->getId());
                if($memento){ //check NULL
                    $originator = new ReviewOriginator($review->getId(), $review->getStatus());
                    $status = $originator->restoreFromMemento($memento, $this->pdo);

                    return $status;
                }else{
                    echo 'No saved state found for this review.';
                }
            } else {
                error_log('Review not found or not archived.');
            }
        } catch (Exception $e) {
            error_log('Error in restoreReview: ' . $e->getMessage());
        }
        return false;
    }

    public function getCaretaker() {
        return $this->caretaker;
    }

    // Add admin reply to a review
    public function addAdminReply($review_id, $admin_reply) {
        $query = "UPDATE review_table SET admin_reply = :admin_reply WHERE id = :review_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':admin_reply', $admin_reply, PDO::PARAM_STR);
        $stmt->bindParam(':review_id', $review_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Fetch reviews including admin reply
    public function fetchReviewsWithReplies() {
        $sql = "SELECT id, user_name, comment, admin_reply FROM reviews";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    // Get archived reviews
    public function getArchivedReviews() {
        $query = 'SELECT * FROM review_table WHERE archived_at IS NOT NULL ORDER BY archived_at DESC';
        $statement = $this->pdo->prepare($query);

        try {
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database query failed: ' . $e->getMessage());
            throw new Exception('Unable to retrieve archived reviews. Please try again later.');
        }
    }

    // Permanently delete a review
    public function deleteReview($review_id) {
        $query = 'DELETE FROM review_table WHERE id = :review_id';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':review_id', $review_id, PDO::PARAM_INT);

        try {
            $statement->execute();
        } catch (PDOException $e) {
            error_log('Error deleting review: ' . $e->getMessage());
            throw new Exception('Unable to delete review. Please try again later.');
        }
    }

    // Generate comments report
    public function getCommentsReport() {
        $query = "SELECT * FROM review_table";
        $statement = $this->pdo->prepare($query);

        try {
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database query failed: ' . $e->getMessage());
            throw new Exception('Unable to generate comments report. Please try again later.');
        }
    }

}

?>