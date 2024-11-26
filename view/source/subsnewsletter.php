<head>
  <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>  
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<?php
    if(isset($_POST["subscribe"])){
        echo "<script>
                 $(document).ready(function() {
                      swal({
                        title: 'Subscribe successfully!',
                        text: 'Subscribe to newsletter successfully ! Please check your email !',
                        icon: 'success'
                        }).then((value) => {
                                document.location = '".$_SERVER['HTTP_REFERER']."'
                        });
                 });
              </script>";
    }
?>