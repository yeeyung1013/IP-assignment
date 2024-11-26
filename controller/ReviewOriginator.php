 
<?php
//SIASHUNFU
require 'ReviewMemento.php';

class ReviewOriginator {

    private $id;
    private $status;

    public function __construct($id, $status) {
        $this->id = $id;
        $this->status = $status;
    }

    // Create a new Memento to store the current state
    public function saveToMemento() {
        $data = [
            'id' => $this->id,
            'status' => $this->status
        ];

        $state = json_encode($data);
        return new ReviewMemento($state);
    }

   
    public function restoreFromMemento(ReviewMemento $memento, $pdo) {
        $state = json_decode($memento->getState());
        $this->status = $state->status; //archive -> unread
        
        $stmt = $pdo->prepare("UPDATE review_table SET status = ?, archived_at = NULL WHERE id = ?");
        return $stmt->execute([$this->status, $this->id]);
    }

    // Change the status of the review
    public function setStatus($status) {
        $this->status = $status;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getId() {
        return $this->id;
    }

}
