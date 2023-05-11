<?php 

function insertImage($image)
{
    // Generate a new name for the image (14 char long)
    $bytes = random_bytes(5);
    $file_name = bin2hex($bytes);

    // Gets the temporary path of the file (where the server stores temporary files)
    $file_tmp = $image['tmp_name'];
    // Gets the extenstion of the image
    $split[] = explode('.', $image['name']); 
    $file_ext = strtolower(end($split[0]));

    $extensions= array("jpeg","jpg","png");
      
    $imgFullname = "./view/content/posts_img/" . $file_name . "." . $file_ext;
    //Validates that the file is .png, .jpg or .jpeg
    if(in_array($file_ext, $extensions) === true){
        move_uploaded_file($file_tmp, $imgFullname);
        return $imgFullname;
    } else {
        return false;
    }
   
}