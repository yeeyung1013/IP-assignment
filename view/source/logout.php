<head>
  <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>  
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<?php
    /* 
     * session_start();
     * Starting a new session before clearing it
     * assures you all $_SESSION vars are cleared 
     * correctly, but it's not strictly necessary.
     */
    session_start();
    session_destroy();
    session_unset();
    echo "<script>$(document).ready(function() {
              swal({
                title: 'Logging out!',
                text: 'You are logging out!',
                icon: 'warning'
                }).then((value) => {
                        document.location = '../index.php';
                });
         });
         </script>";
?>
