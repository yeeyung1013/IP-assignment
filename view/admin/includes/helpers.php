<?php
function validateId($eventId){
    $errMsgId = array();
    
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    $selectCommand = "SELECT * FROM villain WHERE EventId = '$eventId'";
    
    $result = mysqli_query($conn, $selectCommand);
    
    if($result->num_rows > 0){
        $errMsgId[] = "Event ID " . $eventId . " already exists";
    }
    return $errMsgId;
}

function validateTitle($eventName) {
    $errMsgTile = array();
    
    try {
        if ($eventName == "" || $eventName == null) {
            throw new Exception("Please enter your event name");
        }
        
        if (strlen($eventName) > 40) {
            throw new Exception("Event Name cannot exceed 40 characters");
        }
        
        $pattern = "/^[A-Za-z ]+$/";
        
        if (preg_match($pattern, $eventName) == false) {
            throw new Exception("Invalid event name entered.");
        }
    } catch (Exception $e) {
        $errMsgTile[] = $e->getMessage();
    }
    
    return $errMsgTile;
}

function validateDescription($description){
    $errMsgDescription = array();

    try {
        if ($description == "" || $description == null) {
            throw new Exception("Please enter your description");
        }

        if (strlen($description) > 500) {
            throw new Exception("Description cannot exceed 500 characters");
        }

    } catch (Exception $e) {
        $errMsgDescription[] = $e->getMessage();
    }

    return $errMsgDescription;
}

function validateStartDate($startDate){
    $errMsgStartDate = array();

    try {
        if ($startDate == "" || $startDate == null) {
            throw new Exception("Please select your event start date");
        }

    } catch (Exception $e) {
        $errMsgStartDate[] = $e->getMessage();
    }

    return $errMsgStartDate;
}

function validateSeat($seat){
    $errMsgSeat = array();

    try {
        if ($seat == "" || $seat == null) {
            throw new Exception("Please enter your event total seat number");
        }

        if (!is_numeric($seat) || intval($seat) <= 0) {
            throw new Exception("Please enter a valid positive number for the seat count");
        }

    } catch (Exception $e) {
        $errMsgSeat[] = $e->getMessage();
    }

    return $errMsgSeat;
}
//Schedule part 
function validateScheduleId($schedule_id){
    $errMsgSeheduleId = array();
    
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    $selectCommand = "SELECT * FROM schedule WHERE schedule_id = '$schedule_id'";
    
    $result = mysqli_query($conn, $selectCommand);
    
    if($result->num_rows > 0){
        $errMsgSeheduleId[] = "Schedule ID " . $schedule_id . " already exists";
    }
    return $errMsgSeheduleId;
}

function validateScheduleEventId($eventId){
    $errMsgScheduleEventId = array();
    
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    $selectCommand = "SELECT * FROM schedule WHERE EventId = '$eventId'";
    
    $result = mysqli_query($conn, $selectCommand);
    
    if($result->num_rows > 0){
        $errMsgScheduleEventId[] = "Schedule Event ID " . $eventId . " already exists";
    }
    return $errMsgScheduleEventId;
}

function validateDate($startdate){
    $errMsgDate = array();

    try {
        if ($startdate == "" || $startdate == null) {
            throw new Exception("Please select your event schedule date");
        }

        $d = DateTime::createFromFormat('Y-m-d', $startdate);
        if (!$d || $d->format('Y-m-d') !== $startdate) {
            throw new Exception("Please enter a valid date in the format YYYY-MM-DD");
        }

    } catch (Exception $e) {
        $errMsgDate[] = $e->getMessage();
    }

    return $errMsgDate;
}

function validateTime($time){
    $errMsgTime = array();

    try {
        if ($time == "" || $time == null) {
            throw new Exception("Please select your event schedule time");
        }

        $t = DateTime::createFromFormat('H:i', $time);
        if (!$t || $t->format('H:i') !== $time) {
            throw new Exception("Please enter a valid time in the format HH:MM");
        }

    } catch (Exception $e) {
        $errMsgTime[] = $e->getMessage();
    }

    return $errMsgTime;
}

function uploadFile($file)
{

    $image = genRand() . "." . strtolower(pathinfo(@$_FILES[$file]['name'], PATHINFO_EXTENSION));
    $valid_extension = array("jpg", "png", "jpeg");
    if (($_FILES[$file]['size'] && !in_array(strtolower(pathinfo(@$_FILES[$file]['name'], PATHINFO_EXTENSION)), $valid_extension)) || ($_FILES[$file]['size'] && $_FILES[$file]['error']) > 0) {
        return -1;
    }
    $upload = move_uploaded_file(@$_FILES[$file]['tmp_name'], "upload/" . $image);
    if ($upload) {
        chmod("upload/" . $image, 0777);
        return $image;
    } else {
        return -1;
    }
}

function genRand()
{
    return md5(mt_rand(1, 3456789) . date('dmyhmis'));
}

function getImage($id, $conn)
{
    $row = $conn->query("SELECT image FROM admin WHERE id = '$id'")->fetch_assoc();
    if (strlen($row['image']) < 10) return "images/trainlg.png";
    else return "upload/" . $row['image'];
}

function createEventFolder($eventId, $basePath, $files) {
    $folderPath = $basePath . '/' . $eventId;

    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    $uploadedFiles = [];

    foreach ($files['name'] as $key => $name) {
        $targetFilePath = $folderPath . '/' . basename($name);

        if (move_uploaded_file($files['tmp_name'][$key], $targetFilePath)) {
            $uploadedFiles[] = $targetFilePath;
        } else {
            echo "<p>Error uploading file: $name</p>";
            return false;
        }
    }
    return $uploadedFiles;
}