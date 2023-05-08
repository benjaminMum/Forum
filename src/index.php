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
            home();
            break;

        default:
            home();
    }
} else {
    home();
}

