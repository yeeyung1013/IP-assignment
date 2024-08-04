<?php


function validateEventName($eventName){
    $errMsgEventName = array();
    
    if($eventName == "" || $eventName == null){
        $errMsgEventName[] = "Please enter your event name";
    }
    
    if(strlen($eventName) > 40){
        $errMsgEventName[] = "Event Name cannot exceed 40 characters";
    }
    
    $pattern = "/^[A-Za-z ]+$/";
    
    if(preg_match($pattern, $eventName) == false){
        $errMsgEventName[] = "Invalid event name entered.";
    }
    
    return $errMsgEventName;
}

function validateTicketDate($ticketDate){
    $errMsgTicketDate = array();
    
    if($ticketDate == "" || $ticketDate == null){
        $errMsgTicketDate[] = "Please select your event start date";
    }
    
    return $errMsgTicketDate;
}

function validateTicketTime($ticketTime){
    $errMsgTicketTime = array();
    
    if($ticketTime == "" || $ticketTime == null){
        $errMsgTicketTime[] = "Please select your event start date";
    }
    
    return $errMsgTicketTime;
}
function validateTotalSeat($totalSeat){
    $errMsgTotalSeat = array();
    
    if($totalSeat == "" || $totalSeat == null){
        $errMsgTotalSeat[] = "Please enter your event total seat number";
    }
    
    return $errMsgTotalSeat;
}

function validateGPT($goldPrice){
    $errMsgGPT = array();
    
    if($goldPrice == "" || $goldPrice == null){
        $errMsgGPT[] ="Please insert your gold ticket Price";
    }
    
    $pattern = "/^[0-9]{2}$/";
    
    if(preg_match($pattern, $goldPrice) == false){
        $errMsgGPT[] = "Invalid gold ticket Price entered.";
    }
    return $errMsgGPT;
}

function validateSPT($silverPrice){
    $errMsgSPT = array();
    
    if($silverPrice == "" || $silverPrice == null){
        $errMsgSPT[] = "Please insert your silver ticket Price";
    }
    
    $pattern = "/^[0-9]{2}$/";
    
    if(preg_match($pattern, $silverPrice) == false){
        $errMsgSPT[] = "Invalid silver ticket Price entered.";
    }
    return $errMsgSPT;
}

function validateBPT($bronzePrice){
    $errMsgBPT = array();
    
    if($bronzePrice == "" || $bronzePrice == null){
        $errMsgBPT[] = "Please insert your bronze ticket Price";
    }
    
    $pattern = "/^[0-9]{2}$/";
    
    if(preg_match($pattern, $bronzePrice) == false){
        $errMsgBPT[] = "Invalid bronze ticket Price entered.";
    }
    return $errMsgBPT;
}