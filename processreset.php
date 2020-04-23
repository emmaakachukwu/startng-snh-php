<?php
session_start();

$errorCount = 0;

if ( !$_SESSION['loggedIn'] ) {
    $token = $_POST['last_name'] != "" ? $_POST['token'] : $errorCount++;
    $_SESSION['token'] = $token;
}

$email = $_POST['email'] != "" ? $_POST['email'] : $errorCount++;
$password = $_POST['password'] != "" ? $_POST['password'] : $errorCount++;

$_SESSION['email'] = $email;

if ( $errorCount > 0 ) {
    $_SESSION['error'] = "You have " . $errorCount . " errors  in your form submission";
    header("Location: reset.php");
} else {
    $allUserTokens = scandir("db/tokens/");
    $countAllUserTokens = count($allUserTokens);

    for ( $counter = 0; $counter < $countAllUserTokens; $counter++ ) {
        $currentTokenFile = $allUserTokens[$counter];

        if ( $currentTokenFile == $email . ".json" ) {
            $tokenObject = json_decode(file_get_contents("db/users/".$currentTokenFile));
            $tokenFromDB = $tokenObject->token;

            if ( $_SESSION['loggedIn'] ) {
                $checkToken = true;
            } else {
                $checkToken = $tokenFromDB == $token;
            }

            if ( $checkToken ) {
                $allUsers = scandir("db/users/");
                for ( $i = 0; $i < count($allUsers); $i++ ) {
                    $currentUser = $allUsers[$i];
            
                    if ( $currentUser == $email . ".json" ) {
                        $userObject = json_decode(file_get_contents("db/users/".$currentUser));
                        $userObject->password = password_hash($password, PASSWORD_DEFAULT);
                        
                        unlink("db/users/".$currentUser);

                        file_put_contents("db/users/".$email.".json", json_encode($userObject));

                        $_SESSION['message'] = "Password R eset Successful, you can now login";
                        $subject = "Password reset link";
                        $message = "Your account has been updated. If you did not initiate a password reset, visit snh.org";
                        $headers = "From: no-reply@snh.org" . "\r\n" . "CC: emma@snh.org";

                        $try = mail($email, $subject, $message, $headers);
                        if ( $try ) {
                            $_SESSION['message'] = "Password reset has been sent to your email: " . $email;
                            header("Location: login.php");
                        } else 
                        header("Location: login.php");
                        die();
                    }
                }
            }
            
        }
    }

    $_SESSION['error'] = "Password Reset Failed, token/email invalid or expired";
    header("Location: login.php");
}