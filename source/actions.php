<!-- Actions for Sign in/out and Forgot Password -->
<?php
require_once ('./mysqli_connect.php');

if(isset($_POST["login-btn"])){
    $email = trim($_POST['umail'], " ");
    $pass = trim($_POST['psw'], " ");
    
    $q = "SELECT COUNT('email') FROM customer WHERE email = '$email' AND pass = '$pass'";
    $r = mysqli_query ($dbc, $q);
    if(mysqli_fetch_row($r)[0] == 1){
        session_start();
        $_SESSION["email"] = $email;
        $_SESSION["pass"] = $pass;
        echo "<script>alert('Iogin Success!')</script>";
    }else{
        echo "<script>alert('Invalid email/password!')</script>";
    }
    $_POST = array();
    echo "<script>document.location = '".$_SERVER['HTTP_REFERER']."'</script>";
    mysqli_close($dbc);
}

if (isset($_POST["signup-btn"])) {

    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $cpassword = trim($_POST['cpassword'] ?? '');

    if ($password !== $cpassword) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        $stmt = $dbc->prepare("SELECT COUNT(email) FROM customer WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            echo "<script>alert('Email taken, please login!');</script>";
        } else {
            $stmt = $dbc->prepare("INSERT INTO customer (email,phone,pass) VALUES (?,?,?)");
            $stmt->bind_param("sss", $email,$phone,$password);

            if ($stmt->execute()) {
                echo "<script>alert('Sign up Success!');</script>";
            } else {
                echo "<script>alert('Sign up failed. Please try again.');</script>";
            }
            $stmt->close();
        }
    }

    echo "<script>window.location.href = '../';</script>";

    $dbc->close();
}


if(isset($_POST['passreset-btn'])){
    $email = trim($_POST['umail'], " ");
    echo "<script>alert('Check your mail for the password reset link!')</script>";
    echo "<script>document.location = '".$_SERVER['HTTP_REFERER']."'</script>";
}
?> 