<?php
class Event {
    private $eventID;
    private $eventName;
    private $description;
    private $startDate;
    private $seat;
    private $location;
    private $conn;
    private $eventId;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function setEvent($eventID, $eventName, $location, $description, $startDate, $seat) {
        $this->eventID = $eventID;
        $this->eventName = $eventName;
        $this->description = $description;
        $this->startDate = $startDate;
        $this->seat = $seat;
        $this->location = $location;
    }

    public function createEvent() {
        $query = "INSERT INTO villain (EventID, EventName,location, Description, StartDate, Seat) VALUES (?, ?, ?,?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('issssi', $this->eventID, $this->eventName, $this->location, $this->description, $this->startDate, $this->seat);
    
        if ($stmt->execute()) {
            $this->eventId = $this->conn->insert_id; 
            return true;
        } else {
            return false;
        }
    }

    public function getLastInsertId() {
        return $this->eventId;  
    }

    public function updateEvent() {
        $query = "UPDATE villain SET EventName=?, location=? ,Description=?, StartDate=?, Seat=? WHERE EventID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('sssssi', $this->eventName,$this->location, $this->description, $this->startDate, $this->seat, $this->eventID);

        return $stmt->execute();
    }

    public function deleteEvent($eventID) {
        $query = "DELETE FROM villain WHERE EventID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $eventID);

        return $stmt->execute();
    }

    public function getEventById($eventID) {
        $query = "SELECT * FROM villain WHERE EventID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $eventID);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_object();
    }

    public function eventAlreadyCreated() {
        $query = "SELECT COUNT(*) as count FROM villain WHERE EventName = ? AND StartDate = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ss', $this->eventName, $this->startDate);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
    
        return $result['count'] > 0;
    }
}
?>