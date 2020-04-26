<?php
session_start();
require_once("functions/alert.php");
require_once("functions/redirect.php");
require_once("functions/user.php");

$errorCount = 0;
foreach($_POST as $key => $value){
    if ( empty($value) ) {
        $errorCount++;
    } else {
        $_SESSION[$key] = $value;
    }
}

if ( $errorCount > 0 ) {
    $session_error = "You have " . $errorCount . " error";
    if ( $errorCount > 1 ) {
        $session_error .= "s";
    }

    $session_error .= " in your form submission";
    set_alert('error', $session_error);
    redirect_to("book_appointment.php");
} else {
    $_POST['id'] = count(scandir("db/appointments/")) - 1;
    $_POST['fullname'] = $_SESSION['fullname'];

    file_put_contents("db/appointments/".$_POST['id'].".json", json_encode($_POST));
    set_alert('message', 'Appointment has been booked');
    redirect_to("patient.php");
}