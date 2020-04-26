<?php
session_start();
require_once("functions/user.php");

$errorCount = 0;

$first_name = $_POST['first_name'] != "" ? $_POST['first_name'] : $errorCount++;
$last_name = $_POST['last_name'] != "" ? $_POST['last_name'] : $errorCount++;
$email = $_POST['email'] != "" ? $_POST['email'] : $errorCount++;
$password = $_POST['password'] != "" ? $_POST['password'] : $errorCount++;
$gender = $_POST['gender'] != "" ? $_POST['gender'] : $errorCount++;
$designation = $_POST['designation'] != "" ? $_POST['designation'] : $errorCount++;
$department = $_POST['department'] != "" ? $_POST['department'] : $errorCount++;

$_SESSION['first_name'] = $first_name;
$_SESSION['last_name'] = $last_name;
$_SESSION['email'] = $email;
$_SESSION['gender'] = $gender;
$_SESSION['designation'] = $designfation;
$_SESSION['department'] = $department;

//validation
if ( $errorCount > 0 ) {
    $_SESSION['error'] = "You have " . $errorCount . " errors  in your form submission";
    header("Location: register.php");
} else {
    // Validating for names having numbers
    if ( !ctype_alpha($first_name) || !ctype_alpha($last_name) ) {
        $_SESSION['error'] = "Names should not have numbers";
    } else if ( strlen($first_name) < 2 || strlen($last_name) < 2 ) { //names should not be less than two
        $_SESSION['error'] = "Names must have at least two characters";
    } else if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) { //check for valid email
        $_SESSION['error'] = "Enter a valid email address";
    } else if ( strlen($email) < 5 ) { //check if email is less than 5
        $_SESSION['error'] = "Email must have at least five characters";
    } else {
        $userObject = [
            'id' => $newUserId,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'gender' => $gender,
            'designation' => $designation,
            'department' => $department,
            'registered_on' => date('d M, Y h:i a')
        ];    

        $userExists = find_user($email);
        if ( $userExists ) {
            set_alert('error', "Registration failed, user already exists");
            redirect_to("register.php");
            die();
        }
    
        save_user($userObject);
        
        set_alert('message', "Registration Successful, you can now login ".$first_name);
        redirect_to("login.php");
        die();
    }
    header("Location: register.php");
    
}