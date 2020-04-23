<?php
include("alert.php");

function is_user_loggedIn(){
    if ( $_SESSION['loggedIn'] && !empty($_SESSION['loggedIn']) ) {
        return true;
    } else {
        return false;
    }
}

function is_token_set(){
    return is_token_set_in_get() || is_token_set_in_session();
}

function is_token_set_in_session(){
    return isset($_SESSION['token']);
}

function is_token_set_in_get(){
    return isset($_GET['token']);
}

function find_user($email = ""){
    if ( $email ) {
        $allUsers = scandir("db/users/");
        $countAllUsers = count($allUsers);

        for ( $counter = 0; $counter < count($allUsers); $counter++ ) {
            $currentUser = $allUsers[$counter];
    
            if ( $currentUser == $email . ".json" ) {
                $userObject = json_decode(file_get_contents("db/users/".$currentUser));
                
                return $userObject;
            }
        }
        return false;
    } else {
        set_alert('error', 'User email is not set');
        die();
    }
    
}

function save_user($userObject){
    file_put_contents("db/users/".$userObject['email'].".json", json_encode($userObject));
}