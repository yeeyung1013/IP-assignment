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

function validateTitle($eventName){
    $errMsgTile = array();
    
    if($eventName == "" || $eventName == null){
        $errMsgTile[] = "Please enter your event name";
    }
    
    if(strlen($eventName) > 40){
        $errMsgTile[] = "Event Name cannot exceed 40 characters";
    }
    
    $pattern = "/^[A-Za-z ]+$/";
    
    if(preg_match($pattern, $eventName) == false){
        $errMsgTile[] = "Invalid event name entered.";
    }
    
    return $errMsgTile;
}

function validateDescription($description){
    $errMsgDiscription = array();
    
    if($description == "" || $description == null){
        $errMsgDiscription[] = "Please enter your description";
    }
    
    if(strlen($description) > 500){
        $errMsgDiscription[] = "Description cannot exceed 500 characters";
    }
    
    return $errMsgDiscription;
}
function validateStartDate($startDate){
    $errMsgStartDate = array();
    
    if($startDate == "" || $startDate == null){
        $errMsgStartDate[] = "Please select your event start date";
    }
    
    return $errMsgStartDate;
}
function validateSeat($seat){
    $errMsgSeat = array();
    
    if($seat == "" || $seat == null){
        $errMsgSeat[] = "Please enter your event total seat number";
    }
    
    return $errMsgSeat;
}

//Schedule part 
function validateScheduleId($id){
    $errMsgSeheduleId = array();
    
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    $selectCommand = "SELECT * FROM schedule WHERE id = '$id'";
    
    $result = mysqli_query($conn, $selectCommand);
    
    if($result->num_rows > 0){
        $errMsgSeheduleId[] = "Schedule ID " . $id . " already exists";
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

function validateDate($date){
    $errMsgDate = array();
    
    if($date == "" || $date == null){
        $errMsgDate[] = "Please select your event schedule date";
    }
    
    return $errMsgDate;
}

function validateTime($time){
    $errMsgTime = array();
    
    if($time == "" || $time == null){
        $errMsgTime[] = "Please select your event schedule time";
    }
    
    return $errMsgTime;
}

function validateGPT($goldprice){
    $errMsgGPT = array();
    
    if($goldprice == "" || $goldprice == null){
        $errMsgGPT[] = "Please select your event gold ticket prcice date";
    }
    
    return $errMsgGPT;
}

function validateSPT($silverprice){
    $errMsgSPT = array();
    
    if($silverprice == "" || $silverprice == null){
        $errMsgSPT[] = "Please select your event silver ticket prcice date";
    }
    
    return $errMsgSPT;
}

function validateMPT($bronzeprice){
    $errMsgMPT = array();
    
    if($bronzeprice == "" || $bronzeprice == null){
        $errMsgMPT[] = "Please select your event bronze ticket price date";
    }
    
    return $errMsgMPT;
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
