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
            break;
        case 'commentPost';
            commentPost($_POST, $_GET['id']);
            break;
        case 'commentComment';
            commentComment($_POST, $_GET['id']);
            break;
        case 'reportTempo':
            reportTempo($_GET);
            break;
        case 'showReports':
            showReportedPostAndComments();
            break;
        case 'banPost':
            banReportedPost($_GET['id']);
            break;
        case 'banComment':
            banReportedComment($_GET['id']);
            break;
        case 'allowPost':
            allowReportedPost($_GET['id']);
            break;
        case 'allowComment':
            allowReportedComment($_GET['id']);
            break;
        case 'addCategory':
            addCategory($_POST);
            break;
        case 'archivePost':
            archivePost($_GET['id']);
            break;
        case 'blockPost':
            blockPost($_GET['id']);
            break;
        case 'blockComment':
            blockComment($_GET['id']);
            break;
        case 'blockUser':
            blockUser($_GET['id']);
            break;
        default:
            home($_GET['page']);
            break;
    }
} else {
    home($_GET['page']);
}

