<?php
require_once '../loginObserver/loginSystem.php';
require_once '../loginObserver/MFAObserver.php';
require_once '../loginObserver/pswHashObserver.php';
require_once '../loginObserver/pswVerifyObserver.php';
require_once './source/database.php';
?>

<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../assets/css/login.css"><link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="main">
            <div class="container a-container" id="a-container">
                <form class="form" id="a-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <h2 class="form_title title">Create Account</h2>
                    <div class="form__icons">
                        <a href="../view/source/google_oauth.php" style="border:none; background:none;">
                            <img class="form__icon" src="../assets/images/google-icon.png">
                        </a>
                    </div>
                    <span class="form__span">or use email for registration</span>
                    <input class="form__input" type="text" name="email" placeholder="Email" required>
                    <input class="form__input" type="password" name="password" placeholder="Password" required>
                    <input type="hidden" name="action" value="register">
                    <button class="form__button button submit" type="submit">SIGN UP</button>
                </form>
            </div>
            <div class="container b-container" id="b-container">
                <form class="form" id="b-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <h2 class="form_title title">Sign in to Website</h2>
                    <div class="form__icons">
                        <a href="../view/source/google_oauth.php" style="border:none; background:none;">
                            <img class="form__icon" src="../assets/images/google-icon.png">
                        </a>

                    </div>
                    <span class="form__span">or use your email account</span>
                    <input class="form__input" type="text" name="email" placeholder="Email" required>
                    <input class="form__input" type="password" name="password" placeholder="Password" required>
                    <a class="form__link" href="../view/source/send_otp.php">Forgot your password?</a>
                    <input type="hidden" name="action" value="login">
                    <button class="form__button button submit " type="submit">SIGN IN</button>
                </form>
            </div>
            <div class="switch" id="switch-cnt">
                <div class="switch__circle"></div>
                <div class="switch__circle switch__circle--t"></div>
                <div class="switch__container" id="switch-c1">
                    <h2 class="switch__title title">Welcome Back !</h2>
                    <p class="switch__description description">To keep connected with us please login with your personal info</p>
                    <button class="switch__button button switch-btn">SIGN IN</button>
                </div>
                <div class="switch__container is-hidden" id="switch-c2">
                    <h2 class="switch__title title">Hello Friend !</h2>
                    <p class="switch__description description">Enter your personal details and start journey with us</p>
                    <button class="switch__button button switch-btn">SIGN UP</button>
                </div>
            </div>
        </div>

    
        <?php
// Initialize database connection
        $db = new database();
        $pdo = $db->getConnection(); // PDO instance
// Initialize SecureLoginSystem with observers
        $loginSystem = new loginSystem($pdo);

// Add observers
        $mfaObserver = new MFAObserver($pdo);
        $pswHashObserver = new pswHashObserver($pdo);
        $pswVerifyObserver = new pswVerifyObserver($pswHashObserver, $pdo);

        $loginSystem->attach($mfaObserver);
        $loginSystem->attach($pswHashObserver);
        $loginSystem->attach($pswVerifyObserver);

        session_start(); // Ensure you start the session at the beginning of the script

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $action = $_POST['action'] ?? '';

            if ($action == 'register') {
                $email = $_POST['email'];
                $password = $_POST['password'];

                try {
                    $_SESSION['email'] = $email;
                    $loginSystem->register($email, $password);

                  

         
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage() . "<br>";
                }
            } elseif ($action == 'login') {
                $email = $_POST['email'];
                $password = $_POST['password'];

                try {
                    $loginSystem->login($email, $password);
                    
                    $_SESSION['email'] = $email;
                    header('Location: ./index.php');
                    exit;    
                
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage() . "<br>";
                }
            }
        }
        ?>

        <script src="../assets/js/login.js"></script>
    </body>
</html>