<head>
  <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>  
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<?php
session_start();

if(isset($_SESSION["email"]) && isset($_SESSION["pass"])){
    if(isset($_POST["items"]) && isset($_POST["prices"])){
        require_once ('mysqli_connect.php');
        
        $count = 0;
        $eventID;
        foreach ($_POST["items"] as $item) {
            $eventName = explode("|", $item)[0];
            $ticketType = explode("|", $item)[1];
            $ticketPrice = $_POST["prices"][$count];
            
            switch ($eventName){
                case "Genshin":
                    $eventID = 1;
                    break;
                case "LOL":
                    $eventID = 2;
                    break;
                case "Amogus":
                    $eventID = 3;
                    break;
                case "Overwatch":
                    $eventID = 4;
                    break;
                default:
                    $eventID = -1;
            }
            
            // Update remaning tickets
            if($ticketType == "bronze"){
                $q = "UPDATE villain SET bronzeSeat = bronzeSeat - 1 WHERE EventID = ".$eventID;
            }else if($ticketType == "silver"){
                $q = "UPDATE villain SET silverSeat = silverSeat - 1 WHERE EventID = ".$eventID;
            }else{
                $q = "UPDATE villain SET goldSeat = goldSeat - 1 WHERE EventID = ".$eventID;
            }
            
            $r = mysqli_query ($dbc, $q);// Run the query.
            
            // Get customer ID
            $q = "SELECT id FROM customer WHERE email = '".$_SESSION["email"]."' AND pass = '".$_SESSION["pass"]."';";
            $r = mysqli_query ($dbc, $q);// Run the query.
            $custID = mysqli_fetch_array($r, MYSQLI_ASSOC)["id"];
            $q = "SELECT * from payment1 WHERE passenger_id = ".$custID." AND schedule_id = ".($eventID+1000)." AND amount = ".$ticketPrice.";";
            $r = mysqli_query ($dbc, $q);
            $result = mysqli_fetch_array($r, MYSQLI_ASSOC);
            if($result == null){
                $q = "INSERT INTO payment1 (passenger_id, schedule_id, amount, quantity, date) VALUES (".$custID.", ".($eventID+1000).", ".$ticketPrice.", 1, '".date("Y-m-d")."')";
            }else{
                $q = "UPDATE payment1 SET quantity = quantity + 1 WHERE passenger_id = ".$custID." AND schedule_id = ".($eventID+1000)." AND amount = ".$ticketPrice.";";
            }
            $r = mysqli_query ($dbc, $q);// Run the query.
            
            $count++;
        }
        
        echo <<< EOT
            <script>
            // Clear cart
            if (localStorage.getItem('shopping-cart')) {
                    localStorage.removeItem('shopping-cart');
            }
            </script>
        EOT;
    }
    echo "<script>$(document).ready(function() {
                  swal({
                    title: 'Payment Success!',
                    text: 'Payment Success, Thank you!',
                    icon: 'success'
                    }).then((value) => {
                            document.location = '".$_SERVER['HTTP_REFERER']."'
                    });
             });
         </script>";
}else{
    echo "<script>$(document).ready(function() {
                  swal({
                    title: 'Payment Failed!',
                    text: 'Please login before checkout!',
                    icon: 'error'
                    }).then((value) => {
                            document.location = '".$_SERVER['HTTP_REFERER']."'
                    });
             });
         </script>";
}
?>