<?php

function home($page, $choosenCategory) {
    require_once "view/home.php";
    require_once "model/postManager.php";
    require_once "model/categoryManager.php";

    $posts = GetRecentPosts($page, $choosenCategory);
    $categories = getAllCategories();

    view_home($posts, $categories);
    
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
    else if(strlen($registerData['formRegisterEmail']) > 254) {
        $err = "L'adresse mail dépasse les 254 charactères autorisés";
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
            if(userIsOpen(getUserIDByEmail($email))) {
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
                view_login("Votre compte a été banni par un administrateur");
            }
            //check if account is confirmed
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
    require_once "view/lost.php";
    require_once "model/postManager.php";
    require_once "model/userManager.php";
    require_once "model/categoryManager.php";

    $categories = getAllCategories();
    if($_SESSION != NULL) {
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
            else if($_FILES['formNewpostFile']['name']!=null && $formData['formNewpostLink']!=null ) {
                $err = "Veuillez soit séléctionner un fichier soit mettre un lien de vidéo";
            }
            else if(($formData['formNewpostLink'] != null && str_contains($formData['formNewpostLink'], "youtube.com") == false) && $_FILES['formNewpostFile']['name']==null) {
                $err = "Veuillez utiliser un lien de vidéo youtube";
            } 
            else if (strlen($formData['formNewpostLink']) > 45) {
                $err = "Votre lien de vidéo est trop long (maximum 45 charactères)";
            }
            else {
                $testsPassed = true;
            }
            // end data validation
    
            if($testsPassed) {
                $creationReturn = createPost($formData, $_SESSION['userId'], $_FILES['formNewpostFile']);
                if($creationReturn == true) {
                    header("location:/index.php?action=home");
                } else if($creationReturn == 1) {
                    view_newpost("Le fichier inséré n'est pas une image", $categories);
                } else {
                    view_newpost("Une erreur s'est produite lors de la création du post", $categories);
                }
            } else {
                view_newpost($err, $categories);
            }
        } else {
            view_newpost(null, $categories);
        }
    } else {
        view_lost("Veuillez vous connecter pour pouvoir créer un post", "Erreur");
    }
    
}

// View a post with its comments
function post($postId) {
    require_once "view/post.php";
    require_once "view/lost.php";
    require_once "view/closed.php";
    require_once "model/postManager.php";
    require_once "model/commentManager.php";
    require_once "model/userManager.php";

    if(postExists($postId)) {
        if(postIsOpen($postId)) {
            $post = getPostById($postId);
            $comments = getAllCommentsOfPost($postId);
            view_post($post[0], $comments);
        } else {
            view_closed();
        }
    } else {
        view_lost();
    }
    

}

function commentPost($commentData, $postId) {
    require_once "view/lost.php";
    require_once "view/commentPost.php";
    require_once "model/postManager.php";
    require_once "model/userManager.php";
    require_once "model/commentManager.php";
    
    $postData = getPostById($postId)[0];

    if($_SESSION != NULL) {
        if($postData != null) {
            if($commentData != null) {
                $testsPassed = false;
        
                if(strlen($commentData['formCommentPostComment']) > 2000) {
                    $err = "Votre commentaire dépasse les 2000 charactères";
                } 
                else if($_FILES['formCommentPostFile']['name']!=null && $commentData['formCommentPostLink']!=null) {
                    $err = "Veuillez soit séléctionner un fichier soit mettre un lien de vidéo";
                }
                else if(($commentData['formCommentPostLink'] != NULL && str_contains($commentData['formCommentPostLink'], 'youtube.com') == false) && $_FILES['formCommentPostFile']['name']==null) {
                    $err = "Veuillez utiliser un lien de vidéo youtube";
                } 
                else if (strlen($commentData['formCommentPostLink']) > 45) {
                    $err = "Votre lien de vidéo est trop long (maximum 45 charactères)";
                }
                else {
                    $testsPassed = true;
                }   
    
                if($testsPassed == true) {
                    $creationReturn = addCommentToPost($commentData, $_SESSION['userId'], $postData['id'], $_FILES['formCommentPostFile']);
                    if($creationReturn == true) {
                        header("location:/index.php?action=post&id=" . $postData['id']);
                    } else if($creationReturn == 1) {
                        view_newpost($postData, "Le fichier inséré n'est pas une image");
                    } else {
                        view_newpost($postData, "Une erreur s'est produite lors de la création du commentaire");
                    }
                } else {
                    view_commentPost($postData, $err);
                }
            } else {
                view_commentPost($postData);
            }
        } else {
            view_lost();
        }
    } else {
        view_lost("Veuillez vous connecter pour pouvoir créer un post", "Erreur");
    }

    
}

function commentComment($commentData, $commentId) {
    require_once "view/lost.php";
    require_once "view/commentComment.php";
    require_once "model/postManager.php";
    require_once "model/userManager.php";
    require_once "model/commentManager.php";
    
    $parentCommentData = getCommentById($commentId)[0];
    $parentPostData = getPostById($parentCommentData['post_id'])[0];

    if($_SESSION != NULL) {
        if($parentPostData != null) {
            if($parentCommentData != null) {
                if(isCommentLevel2($commentId) == false) {
                    if($commentData != null) {
                        $testsPassed = false;
            
                        if(strlen($commentData['formCommentCommentComment']) > 2000) {
                            $err = "Votre commentaire dépasse les 2000 charactères";
                        } 
                        else if($_FILES['formCommentCommentFile']['name']!=null && $commentData['formCommentCommentLink']!=null) {
                            $err = "Veuillez soit séléctionner un fichier soit mettre un lien de vidéo";
                        }
                        else if(($commentData['formCommentCommentLink'] != NULL && str_contains($commentData['formCommentCommentLink'], 'youtube.com') == false) && $_FILES['formCommentCommentFile']['name']==null) {
                            $err = "Veuillez utiliser un lien de vidéo youtube";
                        } 
                        else if (strlen($commentData['formCommentCommentLink']) > 45) {
                            $err = "Votre lien de vidéo est trop long (maximum 45 charactères)";
                        }
                        else {
                            $testsPassed = true;
                        }   
            
                        if($testsPassed == true) {
                            $creationReturn = addCommentToComment($commentData, $_SESSION['userId'], $parentCommentData['id'], $parentCommentData['post_id'], $_FILES['formCommentCommentFile']);
                            if($creationReturn == true) {
                                header("location:/index.php?action=post&id=" . $parentPostData['id']);
                            } else if($creationReturn == 1) {
                                view_commentComment($parentPostData, $parentCommentData, "Le fichier inséré n'est pas une image");
                            } else {
                                view_commentComment($parentPostData, $parentCommentData, "Une erreur s'est produite lors de la création du commentaire");
                            }
                        } else {
                            view_commentComment($parentPostData, $parentCommentData, $err);
                        }
                    } else {
                        view_commentComment($parentPostData, $parentCommentData);
                    }
                } else {
                    view_lost("Ce commentaire a déjà été commenté", "Erreur");
                }
            } else {
                //Comment does not exist
                view_lost("Ce commentaire n'existe pas", "Erreur");
            }
        } else {
            // parent post of comment does not exist
            view_lost("Le post parent de ce commentaire n'existe pas", "Erreur");
        }
    } else {
        view_lost("Veuillez vous connecter pour accéder à cette page", "Erreur");
    }
}

#endregion


#region Report

function reportTempo($id) {
    require_once "model/postManager.php";
    require_once "model/commentManager.php";
    require_once "view/lost.php";

    if($_SESSION != NULL) {
        if($id['postid'] != null) {
            $postid = $id['postid'];
            if(postExists($postid)) {
                if(isPostOpen($postid)) {
                    reportPostTempo($postid);
                    view_lost("Ce post a été signalé, il sera vérifié par un administrateur", "Post signalé");
                } else {
                    view_lost("Ce post a déjà été signalé", "Erreur");
                }
            }else {
                view_lost();
            }
        }
        else if ($id['commentid'] != null) {
            $commentid = $id['commentid'];
            if(commentExists($commentid)) {
                if(isCommentOpen($commentid)) {
                    reportCommentTempo($commentid);
                    view_lost("Ce post a été commentaire, il sera vérifié par un administrateur", "Commentaire signalé");
                } else {
                    view_lost("Ce commentaire a déjà été signalé", "Erreur");
                }
            } else {
                view_lost();
            }
        } 
        else {
            //neither a post or comment
            view_lost();
        } 
    } else {
        view_lost("Veuillez vous connecter pour pouvoir signaler un post", "Erreur");
    }
}

function showReportedPostAndComments() {
    require_once "view/reported.php";
    require_once "view/lost.php";
    require_once "model/userManager.php";
    require_once "model/commentManager.php";
    require_once "model/postManager.php";

    if($_SESSION['admin'] == true) { 
        $reportedPosts = getAllReportedPosts();
        $reportedComments = getAllReportedComments();
    
        view_reported($reportedPosts, $reportedComments);
    } else {
        view_lost("Accès administrateur requis", "403");
    }

    
}

function banReportedPost($postid) {
    require_once "model/postManager.php";
    require_once "view/lost.php";

    if($_SESSION['admin'] == true) {
        if(postExists($postid)) {
            if(isPostOpen($postid) == false) {
                banReportedPostDB($postid);
                header("location:/index.php?action=showReports");
            } else {
                view_lost("Ce poste n'as pas été signalé", "Erreur");
            }
        } else {
            view_lost("Ce poste n'existe pas", "Erreur");
        }
    } else {
        view_lost("Accès administrateur requis", "403");
    }
}

function banReportedComment($commentid) {
    require_once "model/commentManager.php";
    require_once "view/lost.php";

    if($_SESSION['admin'] == true) {
        if(commentExists($commentid)) {
            if(isCommentOpen($commentid) == false) {
                banReportedCommentDB($commentid);
                header("location:/index.php?action=showReports");
            } else {
                view_lost("Ce poste n'as pas été signalé", "Erreur");
            }
        } else {
            view_lost("Ce poste n'existe pas", "Erreur");
        }
    } else {
        view_lost("Accès administrateur requis", "403");
    }
}


function allowReportedPost($postid) {
    require_once "model/postManager.php";
    require_once "view/lost.php";

    if($_SESSION['admin'] == true) {
        if(postExists($postid)) {
            if(isPostOpen($postid) == false) {
                allowReportedPostDB($postid);
                header("location:/index.php?action=showReports");
            } else {
                view_lost("Ce poste n'as pas été signalé", "Erreur");
            }
        } else {
            view_lost("Ce poste n'existe pas", "Erreur");
        }
    } else {
        view_lost("Accès administrateur requis", "403");
    }
}

function allowReportedComment($commentid) {
    require_once "model/commentManager.php";
    require_once "view/lost.php";

    if($_SESSION['admin'] == true) {
        if(commentExists($commentid)) {
            if(isCommentOpen($commentid) == false) {
                allowReportedCommentDB($commentid);
                header("location:/index.php?action=showReports");
            } else {
                view_lost("Ce poste n'as pas été signalé", "Erreur");
            }
        } else {
            view_lost("Ce poste n'existe pas", "Erreur");
        }
    } else {
        view_lost("Accès administrateur requis", "403");
    }
}

function report($id) {
    require_once "model/postManager.php";
    require_once "model/commentManager.php";
    require_once "model/userManager.php";

    if($_SESSION['admin'] != false) {
        $reportedPosts = getAllReportedPosts();
        $reoprtedComments = getAllReportedComments();

        if($id['postid'] != null) {
            $postid = $id['postid'];
            if(postExists($postid)) {
                if(isPostOpen($postid)) {
                    reportPostTempo($postid);
                    view_lost("Ce post a été signalé, il sera vérifié par un administrateur", "Post signalé");
                } else {
                    view_lost("Ce post a déjà été signalé", "Erreur");
                }
            }else {
                view_lost();
            }
        }
        else if ($id['commentid'] != null) {
            $commentid = $id['commentid'];
            if(commentExists($commentid)) {
                if(isCommentOpen($commentid)) {
                    reportCommentTempo($commentid);
                    view_lost("Ce post a été commentaire, il sera vérifié par un administrateur", "Commentaire signalé");
                } else {
                    view_lost("Ce commentaire a déjà été signalé", "Erreur");
                }
            } else {
                view_lost();
            }
        } 
        else {
            //neither a post or comment
            view_lost();
        } 
    } else {
        view_lost();
    }

}

#endregion


#region Categories

function addCategory($formData) {
    require_once "view/addCategory.php";
    require_once "view/lost.php";
    require_once "model/categoryManager.php";

    $allCategories = getAllCategories();

    if($_SESSION['admin'] == true) {
        if($formData != NULL) {
            // Data validation
            $dataIsValid = false;
    
            if(strlen($formData['formAddCategoryName']) > 45) {
                $err = "Le nom de la catégorie est trop long";
            } if(cateogryExists($formData['formAddCategoryName'])) {
                $err = "Cette catégorie existe déjà";
            } else {
                $dataIsValid = true;
            }
    
            if($dataIsValid) {
                addCategoryDB($formData);
                header("location:/index.php?action=addCategory");
            } else {
                view_addCategory($allCategories, $err);
            }
        } else {
            view_addCategory($allCategories, null);
        }
    } else {
        view_lost("Accès non autorisé", "403");
    }
}

#endregion

#region Archive

function archivePost($id) {
    require_once "view/lost.php";
    require_once "model/postManager.php";
    
    if($_SESSION['admin'] == true) {
        if(postExists($id)) {
            if(postIsOpen($id)) {
                archivePostDB($id) ;
                view_lost("Ce poste a été archivé, il ne sera plus visible pour les utilisateurs", "Post archivé");
            } else {
                view_lost("Ce poste est déjà fermé", "Erreur");
            }
        } else {
            view_lost("Ce poste n'existe pas", "Erreur");
        }
    } else {
        view_lost("Accès interdit", "403");
    }
}



#endregion

#region Block

function showAllUser() {
    require_once "view/users.php";
    require_once "view/lost.php";
    require_once "model/userManager.php";

    if($_SESSION['admin'] == true) { 
        $users = getAllUsers();
        view_users($users);
    } else {
        view_lost();
    }
}

function blockUser($id) {
    require_once "view/lost.php";
    require_once "model/postManager.php";
    
    if($_SESSION['admin'] == true) {
        if((userExists($id))) {
            if(userIsOpen($id)) {
                blockUserDB($id);
                header("location:/index.php?action=showUsers");
            } else {
                view_lost("Cet utilisateur est déjà fermé", "Erreur");
            }
        } else {
            view_lost("Ce poste n'existe pas", "Erreur");
        }
    } else {
        view_lost("Accès interdit", "403");
    }
}

function blockPost($id) {
    require_once "view/lost.php";
    require_once "model/postManager.php";
    
    if($_SESSION['admin'] == true) {
        if(postExists($id)) {
            if(postIsOpen($id)) {
                blockPostDB($id) ;
                view_lost("Ce poste a été bloqué, il ne sera plus visible pour les utilisateurs", "Post bloqué");
            } else {
                view_lost("Ce poste est déjà fermé", "Erreur");
            }
        } else {
            view_lost("Ce poste n'existe pas", "Erreur");
        }
    } else {
        view_lost("Accès interdit", "403");
    }
}

function blockComment($id) {
    require_once "view/lost.php";
    require_once "model/commentManager.php";
    
    if($_SESSION['admin'] == true) {
        if(commentExists($id)) {
            if(isCommentOpen($id)) {
                blockCommentDB($id);
                view_lost("Ce commentaire a été bloqué, il ne sera plus visible pour les utilisateurs", "Commentaire bloqué");
            } else {
                view_lost("Ce commentaire est déjà fermé", "Erreur");
            }
        } else {
            view_lost("Ce commentaire n'existe pas", "Erreur");
        }
    } else {
        view_lost("Accès interdit", "403");
    }
}
#endregion
