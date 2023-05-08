<?php

require_once "model/dbConnector.php";

#region Register

function EmailAlreadyExists($email) {
    $query = "SELECT * FROM `users` WHERE `email` = '$email';";
    
    if(empty(executeQuerySelect($query))) {
        return false;
    } else {
        return true;
    }
}

function UsernameAlreadyExists($username) {
    $query = "SELECT * FROM `users` WHERE `username` = '$username';";
    
    if(empty(executeQuerySelect($query))) {
        return false;
    } else {
        return true;
    }
}

function addUserInDB($registerData) {
    $email = $registerData['formRegisterEmail'];
    $username = $registerData['formRegisterUsername'];
    $password = $registerData['formRegisterPassword'];
    
    //hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    //generate a 20 character long token for account confirmation
    $bytes = random_bytes(20);
    $token = bin2hex($bytes);

    
    $query = "INSERT INTO `users` (email, username, password, register_token, admin, banned, confirmed) " . 
             "VALUES ('$email', '$username','$hashedPassword', $token, 0, 0, 0);";

    $confirm = executeQueryIUD($query);

    return $confirm;
}

function sendConfirmationMail($email) {
    $query = "SELECT ``register_token` FROM `users` WHERE `email` = '$email';";
    $token = executeQuerySelect($query);

    $subject = "Confirmation d'inscription";
    $message = "Veuillez suivre ce lien afin de confirmer votre inscription : [url]/index.php?action=login&token=$token";

    return mail($email, $subject, $message);
}

#endregion

#region Login

function loginIsCorrect($loginData) {
    $email = $loginData['formLoginEmail'];
    $password = $loginData['formLoginPassword'];

    $query = "SELECT `password` FROM `users` WHERE `email` = '$email';";

    $hashedPassword = executeQuerySelect($query);
    
    if($hashedPassword != null) {
        return password_verify($password, $hashedPassword);
    } else {
        return false;
    }
}

function confirmAccount($email, $token) {

    $token_query = "SELECT `register_token` FROM `users` WHERE `email` = '$email';";
    $dbtoken = executeQuerySelect($token_query);

    if($dbtoken == $token) {

    }
    
}

function accountIsConfirmed($email) {
    $query = "SELECT `confirmed` FROM `users` WHERE `email` = '$email';";
    $result = executeQuerySelect($query);

    if($result != null) {
        if($result == 0) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

function getUserRights($email) {
    $query = "SELECT `admin` FROM `users` WHERE `email` = '$email';";
    $result = executeQuerySelect($query);

    if($result != null) {
        if($result == 0) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

#endregion

