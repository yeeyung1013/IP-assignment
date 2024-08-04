<!-- Actions for Sign in/out and Forgot Password -->
<?php
require_once ('./mysqli_connect.php');

if(isset($_POST["login-btn"])){
    $email = trim($_POST['umail'], " ");
    $pass = trim($_POST['psw'], " ");
    
    // Prepare a select statement
    $q = "SELECT COUNT('email') FROM customer WHERE email = '$email' AND pass = '$pass'";
    $r = mysqli_query ($dbc, $q); // Run the query.
    if(mysqli_fetch_row($r)[0] == 1){
        // Start the session
        session_start();
        $_SESSION["email"] = $email;
        $_SESSION["pass"] = $pass;
        echo "<script>alert('Iogin Success!')</script>";
    }else{
        echo "<script>alert('Invalid email/password!')</script>";
    }
    $_POST = array();// Clear $_POST
    echo "<script>document.location = '".$_SERVER['HTTP_REFERER']."'</script>";
    // Close connection
    mysqli_close($dbc);
}

if(isset($_POST["signup-btn"])){
    $email = trim($_POST['email'], " ");
    $pass = trim($_POST['psw'], " ");
    
    $chkEmailQ = "SELECT COUNT('email') FROM customer WHERE email = '$email'";
    $r = mysqli_query ($dbc, $chkEmailQ);
    echo "<script>alert('$chkEmailQ');</script>";
    if(mysqli_fetch_row($r)[0] == 1){
        echo "<script>alert('Email taken, please login!')</script>";
    }else{
        $q = "INSERT INTO customer (email, pass) VALUES ('$email', '$pass');";
        $r = mysqli_query ($dbc, $q);
        echo "<script>alert('Sign up Success!')</script>";	
    }
    $_POST = array();// Clear $_POST
    echo "<script>document.location = '".$_SERVER['HTTP_REFERER']."'</script>";
    // Close connection
    mysqli_close($dbc);
}

if(isset($_POST['passreset-btn'])){
    $email = trim($_POST['umail'], " ");
    echo "<script>alert('Check your mail for the password reset link!')</script>";
    echo "<script>document.location = '".$_SERVER['HTTP_REFERER']."'</script>";
}
?> 