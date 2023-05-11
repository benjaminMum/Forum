<?php

function home() {
    require_once "view/home.php";
    view_home();
}

#region Users

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
                    $_SESSION['userId'] = getIdOfUser($registerData['formRegisterEmail']);
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
                $_SESSION['admin'] = IsUserAdmin($email);
                $_SESSION['userId'] = getIdOfUser($email);
                header("location:/index.php?action=home");
            } else {
                if($loginData['token'] != null) {
                    if(confirmAccount($email, $loginData['token'])) {
                        $_SESSION['email'] = $email;
                        $_SESSION['admin'] = IsUserAdmin($email);
                        $_SESSION['userId'] = getIdOfUser($email);
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

#endregion


#region Posts

function newPost($formData) {
    require_once "view/newPost.php";
    require_once "model/postManager.php";
    require_once "model/userManager.php";

    $categories = getAllCategories();

    if($formData != null) {

        // data validation
        
        $testsPassed = false;

        if($formData['formNewpostTitle'] == "") {
            $err = "Votre spéficier le titre de votre poste";
        }
        else if(strlen($formData['formNewpostTitle']) > 150) {
            $err = "Votre titre dépasse les 150 charactères";
        } 
        else if(categoryValueExists($formData['formNewpostCategory']) == false) {
            // If the "value" attribute of the category field does not correspond to an id in the "category" table
            $err = "La catégorie séléctionnée n'existe pas";
        } 
        else if(($_FILES['formNewpostFile']['name']==null xor $formData['formNewpostLink']==null) == false) {
            $err = "Veuillez soit séléctionner un fichier soit mettre un lien de vidéo";
        } 
        else {
            $testsPassed = true;
        }
        // end data validation


        if($testsPassed) {
            if(createPost($formData, $_SESSION['userId'], $_FILES['formNewpostFile'])) {
                header("location:/index.php?action=home");
            } else {
                view_newpost("Erreur lors de la création du post", $categories);
            }
        } else {
            view_newpost($err, $categories);
        }
    } else {
        view_newpost(null, $categories);
    }
}

#endregion