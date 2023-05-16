<?php
// Creates/Resumes a sessions
session_start();

// Dependencies
require "controller/controller.php";

$action = $_GET['action'];

if(isset($action)) {
    // Routing
    switch ($action) {
        case 'home':
            home($_GET['page']);
            break;
        case 'register':
            register($_POST);
            break;
        case 'login':
            login($_POST);
            break;
        case 'disconnect':
            disconnect();
            break;
        case 'newpost':
            newPost($_POST);
            break;
        case 'post':
            post($_GET['id']);
        case 'comment';
            commentPost($_POST, $_GET['id']);
            break;
        default:
            home($_GET['page']);
    }
} else {
    home($_GET['page']);
}

