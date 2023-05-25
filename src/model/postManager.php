<?php 

require_once "model/dbConnector.php";
require_once "model/fileManager.php";

function getMaxPageNumber($page) {
    // Gets the number of posts
    $numberOfRows = executeQuerySelect("SELECT COUNT(`id`) FROM `posts`;");
    // Calulates the maximum number of pages needed to display all the posts
    return ceil($numberOfRows[0][0] / 10);
}

function GetRecentPosts($page) {
    // Verifies if the page given in GET is in the range
    $pagesRange = range(1, getMaxPageNumber($page));
    if (in_array($page, $pagesRange) == false) {
        $page = 1;
    }

    // Calculates the offset to know wich posts to display per page
    // Ex : if $page=1 -> offset = 0 (will display posts 1-10 in the order of the most recent)
    //      if $page=2 -> offset = 10 (will display posts 11-20 in the order of the most recent)
    $offset = (int)$page * 10 - 10;

    $query = "SELECT * FROM `posts` ORDER BY `date` DESC LIMIT 10 OFFSET $offset;";
    return executeQuerySelect($query);
}

function createPost($formData, $userId, $file=null) {
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

function postIsOpen($postId) {
    $query = "SELECT `closed` FROM `posts` WHERE `id` = '$postId';";
    $result = executeQuerySelect($query);

    if($result[0]['closed'] == 1) {
        return false;
    } else {
        return true;
    }
} 

function postExists($postId) {
    $query = "SELECT `title` FROM `posts` WHERE `id` = '$postId';";
    $result = executeQuerySelect($query);

    if($result == null) {
        return false;
    } else {
        return true;
    }
}

function getPostById($postId) {
    $query = "SELECT * FROM `posts` WHERE `id` = '$postId';";
    $result = executeQuerySelect($query);
    return $result;
}

function isPost() {
    
}

function reportPost($postID) {
    $query = "UPDATE `users` SET `closed` = 1;";
    executeQueryIUD($query);
}

function isPostOpen($postId) {
    $query = "SELECT `closed` FROM `posts` WHERE `id` = '$postId';";
    $result = executeQuerySelect($query);

    if($result[0]['closed'] == 0) {
        return true;
    } else {
        return false;
    }
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