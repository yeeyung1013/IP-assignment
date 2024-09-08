<?php

class Schedule {
    private $scheduleId;
    private $eventID;
    private $date;
    private $time;
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function setSchedule($scheduleId, $eventID, $date, $time) {
        $this->scheduleId = $scheduleId;
        $this->eventID = $eventID;
        $this->date = $date;
        $this->time = $time;
    }

    public function saveSchedule() {
        $insertCommand = "INSERT INTO schedule (schedule_id, EventID, date, time) VALUES "
                       . "('$this->scheduleId', '$this->eventID', '$this->date', '$this->time')";

        $result = mysqli_query($this->conn, $insertCommand);

        if ($result) {
            return true;
        } else {
            return ["Error: " . mysqli_error($this->conn)];
        }
    }
    public function updateSchedule() {
        $updateCommand = "UPDATE schedule SET EventID='$this->eventID', date='$this->date', time='$this->time' WHERE schedule_id = '$this->scheduleId'";
        $result = mysqli_query($this->conn, $updateCommand);

        if ($result) {
            return true;
        } else {
            return ["Error: " . mysqli_error($this->conn)];
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
            $stmt->close(); 
            return true;
        } else {
            return ["Error executing statement: " . $stmt->error];
        }
    }
}
?>