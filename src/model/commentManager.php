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