<?php

require_once "model/dbConnector.php";

function addCategoryDB($formData) {
    $name = $formData['formAddCategoryName'];

    $query = "INSERT INTO `categories` (name) VALUES ('$name');";
    executeQueryIUD($query);
}

function getAllCategories() {
    $query = "SELECT * FROM `categories` ORDER BY `id` ASC;";
    return executeQuerySelect($query);
}

function categoryValueExists($formValue) {
    $query = "SELECT `id` FROM `categories` WHERE `id` = '$formValue';";
    return executeQuerySelect($query);
}