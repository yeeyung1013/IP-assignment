<?php
class Schedule {
    private $scheduleId;
    private $eventID;
    private $startdate;
    private $enddate;
    private $time;
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function setSchedule($scheduleId, $eventID, $startdate, $enddate, $time) {
        $this->scheduleId = $scheduleId;
        $this->eventID = $eventID;
        $this->startdate = $startdate;
        $this->enddate = $enddate;
        $this->time = $time;
    }

    public function saveSchedule() {
        $insertCommand = "INSERT INTO schedule (schedule_id, EventID, startdate, enddate, time) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($insertCommand);
        $stmt->bind_param('iisss', $this->scheduleId, $this->eventID, $this->startdate, $this->enddate, $this->time);

        if ($stmt->execute()) {
            return true;
        } else {
            return ["Error: " . $stmt->error];
        }
    }

    public function updateSchedule() {
        $updateCommand = "UPDATE schedule SET EventID = ?, startdate = ?, enddate = ?, time = ? WHERE schedule_id = ?";
        $stmt = $this->conn->prepare($updateCommand);
        $stmt->bind_param('isssi', $this->eventID, $this->startdate, $this->enddate, $this->time, $this->scheduleId);

        if ($stmt->execute()) {
            return true;
        } else {
            return ["Error: " . $stmt->error];
        }
    }

    public function deleteSchedule($eventID) {
        $query = "DELETE FROM schedule WHERE EventID = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            return ["Error preparing statement: " . $this->conn->error];
        }

        $stmt->bind_param('i', $eventID);

        if ($stmt->execute()) {
            return true;
        } else {
            return ["Error executing statement: " . $stmt->error];
        }
    }
}
?>