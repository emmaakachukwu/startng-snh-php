<?php

function send_email($subject="", $message="", $email=""){   
    $headers = "From: no-reply@snh.org" . "\r\n" . "CC: emma@snh.org";

    $try = mail($email, $subject, $message, $headers);
    return $try ? true : false;
}

?>