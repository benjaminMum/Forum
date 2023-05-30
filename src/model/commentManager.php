<?php

function addCommentToPost($formData, $userID, $postID, $file=null) {
    $comment = $formData['formCommentPostComment'];
    // Adds 2 hours to get to utc+2
    $date = gmdate('Y-m-d H:i:s', strtotime('+2 hours'));

    if($file['name'] != null) {
        $file_link = insertImage($file);
        if($file_link != false) {
            $query = "INSERT INTO `comments` (user_id, post_id, comment_id, text, date, image_link, banned) " . 
             "VALUES ('$userID', '$postID', null, '$comment', '$date', '$file_link', 0);";
        } else {

        }
    } else {
        //if there is no file then it is a video link
        $video_link = $formData['formCommentPostLink'];
        $query = "INSERT INTO `comments` (user_id, post_id, comment_id, text, date, image_link, banned) " . 
             "VALUES ('$userID', '$postID', null, '$comment', '$date', '$video_link', 0);";
    }

    return executeQueryIUD($query);
}

function addCommentToComment($formData, $userID, $parentCommentID, $parentPostID, $file=null) {
    $comment = $formData['formCommentCommentComment'];
    // Adds 2 hours to get to utc+2
    $date = gmdate('Y-m-d H:i:s', strtotime('+2 hours'));

    if($file['name'] != null) {
        $file_link = insertImage($file);
        if($file_link != false) {
            $query = "INSERT INTO `comments` (user_id, post_id, comment_id, text, date, image_link, banned) " . 
             "VALUES ('$userID', '$parentPostID', '$parentCommentID', '$comment', '$date', '$file_link', 0);";
        } else {

        }
    } else {
        //if there is no file then it is a video link
        $video_link = $formData['formCommentCommentLink'];
        $query = "INSERT INTO `comments` (user_id, post_id, comment_id, text, date, image_link, banned) " . 
             "VALUES ('$userID', '$parentPostID', '$parentCommentID', '$comment', '$date', '$video_link', 0);";
    }

    return executeQueryIUD($query);
}

function getAllCommentsOfPost($postID) {
    $query = "SELECT * FROM comments WHERE post_id = '$postID' OR comment_id IN ( SELECT id FROM comments WHERE post_id = '$postID');";
    return executeQuerySelect($query);
}

function getCommentById($commentId) {
    $query = "SELECT * FROM `comments` WHERE `id` = '$commentId';";
    $result = executeQuerySelect($query);
    return $result;
}

function getAllReportedComments() {
    $query = "SELECT * FROM `comments` WHERE `banned` = 1;";
    return executeQuerySelect($query);
}

function isCommentOpen($commentId) {
    $query = "SELECT `banned` FROM `comments` WHERE `id` = '$commentId';";
    $result = executeQuerySelect($query);

    if($result[0]['banned'] != 0) {
        return false;
    } else {
        return true;
    }
}

function banReportedCommentDB($commentid) {
    $query = "UPDATE `comments` SET `banned` = 2 WHERE `id` = '$commentid';";
    executeQueryIUD($query);
}

function allowReportedCommentDB($commentid) {
    $query = "UPDATE `comments` SET `banned` = 0 WHERE `id` = '$commentid';";
    executeQueryIUD($query);
}

function blockCommentDB($id) {
    $query = "UPDATE `comments` SET `banned` = 2 WHERE `id` = '$id';";
    executeQueryIUD($query);
}

function commentExists($commentId) {
    $query = "SELECT `banned` FROM `comments` WHERE `id` = '$commentId';";
    $result = executeQuerySelect($query);

    if($result == null) {
        return false;
    } else {
        return true;
    }
}

function reportCommentTempo($commentId) {
    $query = "UPDATE `comments` SET `banned` = 1 WHERE `id` = '$commentId';";
    executeQueryIUD($query);
}

function isCommentLevel2($commentId) {
    $query = "SELECT `comment_id` FROM `comments` WHERE `id` = '$commentId';";
    $result = executeQuerySelect($query);

    if($result[0]['comment_id'] == null) {
        return false;
    } else {
        return true;
    }
}