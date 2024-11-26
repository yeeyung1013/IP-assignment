<?php

class Event {
    private $eventID;
    private $eventName;
    private $description;
    private $startDate;
    private $seat;
    private $conn;
    private $strategy;

    public function __construct($dbConnection, NotificationStrategy $strategy = null) {
        $this->conn = $dbConnection;
        $this->strategy = $strategy;
    }

    public function triggerEvent($customerId, $message) {
        $this->strategy->sendNotification($customerId, $message);
    }

    public function setEvent($eventID, $eventName, $description, $startDate, $seat) {
        $this->eventID = $eventID;
        $this->eventName = $eventName;
        $this->description = $description;
        $this->startDate = $startDate;
        $this->seat = $seat;
    }

    // public function createEvent() {
    //     if ($this->eventAlreadyCreated()) {
    //         return false; 
    //     }
    
    //     $query = "INSERT INTO villain (EventID, EventName, Description, StartDate, Seat) VALUES (?, ?, ?, ?, ?)";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bind_param('isssi', $this->eventID, $this->eventName, $this->description, $this->startDate, $this->seat);
    
    //     if ($stmt->execute()) {
    //         $this->eventId = $this->conn->insert_id;
    
    //         if ($this->strategy) {
    //             $message = "A new event has been created: " . $this->eventName;
    //             $this->strategy->sendNotification($message);  
    //         }
            
    //         return true;
    //     } else {
    //         error_log("Failed to execute query: " . $stmt->error);
    //         return false;
    //     }
    // }
    public function createEvent() {
        $query = "INSERT INTO villain (EventID, EventName, Description, StartDate, Seat) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('isssi', $this->eventID, $this->eventName, $this->description, $this->startDate, $this->seat);
    
        if ($stmt->execute()) {
            $this->eventId = $this->conn->insert_id;

            if ($this->strategy && !$this->eventAlreadyCreated()) { 
                $message = "A new event has been created: " . $this->eventName;
                $this->strategy->sendNotification($message);
            }
            return true;
        } else {
            error_log("Failed to execute query: " . $stmt->error);
            return false;
        }
    }
    
    private function eventAlreadyCreated() {
        $query = "SELECT COUNT(*) as count FROM villain WHERE EventName = ? AND StartDate = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ss', $this->eventName, $this->startDate);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
    
        return $result['count'] > 0;
    }
    public function getLastInsertId() {
        return $this->eventId;  
    }

    public function getEventById($eventID) {
        $query = "SELECT * FROM villain WHERE EventID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $eventID);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_object();
    }

    public function updateEvent() {
        $query = "UPDATE villain SET EventName=?, Description=?, StartDate=?, Seat=? WHERE EventID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssssi', $this->eventName, $this->description, $this->startDate, $this->seat, $this->eventID);

        return $stmt->execute();
    }

    public function deleteEvent($eventID) {
        $query = "DELETE FROM villain WHERE EventID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $eventID);

        return $stmt->execute();
    }

    public function executeStrategy() {
        $this->strategy->execute($this);
    }

    public function getEventName() {
        return $this->eventName;
    }
}

?>