<?php

function home() {
    require_once "view/home.php";
    view_home();
}

function register($registerData) {
    require_once "view/register.php";
    require_once "model/userManager.php";

    $testsPassed = false;

    //regex to verify if the email is correctly formated
    $exp = "/^\S+@\S+\.\S+$/i";

    //form data verification
    if(in_array("", $registerData)) {
        $err = "Un ou plusieurs champs sont vides";
    } else if(preg_match($exp, $registerData['formRegisterEmail']) == false) {
        $err = "L'adresse mail n'est pas conforme";
    }
    else if(strlen($registerData['formRegisterEmail']) > 45) {
        $err = "L'adresse mail dépasse les 45 charactères autorisés";
    } 
    else if(strlen($registerData['formRegisterUsername']) > 20) {
        $err = "Le nom d'utilisateur dépasse les 20 charactères";
    }
    else if(EmailAlreadyExists($registerData['formRegisterEmail'])) {
        $err = "Cette adresse mail est déjà utilisée par un autre compte";
    }
    else if(UsernameAlreadyExists($registerData['formRegisterUsername'])) {
        $err = "Ce nom d'utilisateur est déjà utilisé par un autre compte";
    }
    else if($registerData['formRegisterPassword'] != $registerData['formRegisterConfirmPassword']) {
        $err = "Les deux mots de passe ne correspondent pas";
    } else {
        $testsPassed = true;
    }

    if($registerData != NULL) {
        if($testsPassed) {
            if(addUserInDB($registerData)) {
                //if(sendConfirmationMail($registerData['formRegisterEmail'])) {
                    $_SESSION['email'] = $registerData['formRegisterEmail'];
                    $_SESSION['admin'] = false;
                    $_SESSION['newAccount'] = true;
                    // Refreshes the page to display the "Check your mailbox" message
                    // The page will not display the form because the $_SESSION['newAccount'] is set
                    header("location:/index.php?action=register");
                //}
            }
        } else {
            view_register($err);
        }
    } else {
        view_register();
    }
}

function login($loginData) {
    require_once "view/login.php";
    require_once "model/userManager.php";

    if($loginData != null) {
        if(loginIsCorrect($loginData)) {
            $email = $loginData['formLoginEmail'];
            //check if account is confirmed
            if(accountIsConfirmed($email)) {
                $_SESSION['email'] = $email;
                $_SESSION['admin'] = getUserRights($email);
                header("location:/index.php?action=home");
            } else {
                if($loginData['token'] != null) {
                    if(confirmAccount($email, $loginData['token'])) {
                        $_SESSION['email'] = $email;
                        $_SESSION['admin'] = getUserRights($email);
                        header("location:/index.php?action=home");
                    } else {
                        view_login("Votre jeton d'identification est incorrect.");
                    }
                } 
                else {
                    // todo : rewrite the message
                    view_login("Votre compte n'a pas été confirmé");
                }
            }
        } else {
            view_login("Données incorrectes");
        }
    } else {
        view_login();
    }
}

function disconnect() {
    session_destroy();
    header("location:/home");
}

