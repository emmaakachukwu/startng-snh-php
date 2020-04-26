<?php
session_start();
require_once("functions/alert.php");
require_once("functions/redirect.php");
require_once("functions/email.php");
require_once("functions/user.php");
require_once("functions/token.php");

$errorCount = 0;

$email = $_POST['email'] != "" ? $_POST['email'] : $errorCount++;
$password = $_POST['password'] != "" ? $_POST['password'] : $errorCount++;

$_SESSION['email'] = $email;

//validation
if ( $errorCount > 0 ) {
    $session_error = "You have " . $errorCount . " error";
    if ( $errorCount > 1 ) {
        $session_error .= "s";
    }

    $session_error .= " in your form submission";
    set_alert('error', $session_error);
    redirect_to("login.php");
} else {
    $currentUser = find_user($email);

    if ( $currentUser ) {
        $userObject = json_decode(file_get_contents("db/users/".$currentUser));
        $passwordFromDB = $userObject->password;
        if ( password_verify($password, $passwordFromDB) ) {
            //redirect to dashboard
            $logintime = date('d M, Y h:i a');
            $_SESSION['loggedIn'] = $userObject->id;
            $_SESSION['email'] = $userObject->email;
            $_SESSION['fullname'] = $userObject->first_name.' '.$userObject->last_name;
            $_SESSION['role'] = $userObject->designation;
            $_SESSION['logintime'] = $logintime; //record user login time
            $_SESSION['lastlogin'] = $userObject->lastlogin;
            $_SESSION['department'] = $userObject->department;
            $_SESSION['registered_on'] = $userObject->registered_on;

            $userObject->lastlogin = $logintime; //record the current login time as the last login to the DB
            file_put_contents("db/users/".$email.".json", json_encode($userObject));
            // redirect users to different pages based on their Access level
            if ( $userObject->designation == 'Patient' ) {
                redirect_to("patient.php");
            } else {
                redirect_to("medicalteam.php");
            }
            // header("Location: dashboard.php");
            die();
        }
    }

    set_alert('error', "Invalid Email or Password");
    redirect_to("login.php");
}