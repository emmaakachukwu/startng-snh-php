<?php
session_start();
require_once("functions/alert.php");
require_once("functions/redirect.php");
require_once("functions/email.php");
require_once("functions/user.php");
require_once("functions/token.php");

$errorCount = 0;

if ( !is_user_loggedIn() ) {
    $token = $_POST['token'] != "" ? $_POST['token'] : $errorCount++;
    $_SESSION['token'] = $token;
}

$email = $_POST['email'] != "" ? $_POST['email'] : $errorCount++;
$password = $_POST['password'] != "" ? $_POST['password'] : $errorCount++;

$_SESSION['email'] = $email;

if ( $errorCount > 0 ) {
    set_alert('error', "You have " . $errorCount . " errors  in your form submission");
    redirect_to("reset.php");
} else {
    $checkToken = is_user_loggedIn() ? true : find_token($email);
    if ( $checkToken ) {
        $userObject = find_user($email);
        if ( $userObject ) {
            $userObject->password = password_hash($password, PASSWORD_DEFAULT);
            
            unlink("db/users/".$email.".json");

            save_user($userObject);

            set_alert('message', "Password Reset Successful, you can now login");

            $subject = "Password reset link";
            $message = "Your account has been updated. If you did not initiate a password reset, visit snh.org";
            
            // send_email($subject, $message, $email);

            redirect_to("logout.php");
            return;
        }    
    }

    set_alert('error', "Password Reset Failed, token/email invalid or expired");
    redirect_to("login.php");
}