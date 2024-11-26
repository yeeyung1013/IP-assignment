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
        $insertCommand = "INSERT INTO schedule (schedule_id, EventID, startdate, enddate, time)VALUES "
                       . "('$this->scheduleId', '$this->eventID', '$this->startdate', '$this->enddate','$this->time')";

        $result = mysqli_query($this->conn, $insertCommand);

        if ($result) {
            return true;
        } else {
            return ["Error: " . mysqli_error($this->conn)];
        }
    }
    public function updateSchedule() {
        $updateCommand = "UPDATE schedule SET EventID='$this->eventID', startdate='$this->startdate',enddate='$this->enddate', time='$this->time' WHERE schedule_id = '$this->scheduleId'";
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