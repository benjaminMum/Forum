<?php 

require_once "model/dbConnector.php";
require_once "model/fileManager.php";

function createPost($formData, $userId, $file=null) {

    $passed = false;

    $category = $formData['formNewpostCategory'];
    $title = $formData['formNewpostTitle'];
    // Adds 2 hours to get to utc+2
    $date = gmdate('Y-m-d H:i:s', strtotime('+2 hours'));

    if($file['name'] != null) {
        $file_link = insertImage($file);
        if($file_link != false) {
            $query = "INSERT INTO `posts` (user_id, category_id, title, date, image_link, closed) " . 
             "VALUES ('$userId', '$category','$title', '$date', '$file_link', 0);";
        } else {

        }
    } else {
        //if there is no file then it is a video link
        $video_link = $formData['formNewpostLink'];
        $query = "INSERT INTO `posts` (user_id, category_id, title, date, image_link, closed) " . 
             "VALUES ('$userId', '$category','$title', '$date', '$video_link', 0);";
    }

    return executeQueryIUD($query);
}

#region Categories



function getAllCategories() {
    $query = "SELECT * FROM `categories`;";
    return executeQuerySelect($query);
}

function categoryValueExists($formValue) {
    $query = "SELECT `id` FROM `categories` WHERE `id` = '$formValue';";
    return executeQuerySelect($query);
}

#endregion