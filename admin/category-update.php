<?php 
include "config.php";
//update user data
if (isset($_POST['submit'])) {
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);

    $sql1 = "UPDATE category SET category_id={$category_id}, category_name='{$category_name}' WHERE category_id={$category_id}";

    $result = mysqli_query($conn, $sql1) or die("Query failed.");
    //url redirect
    if ($result) {
        header("Location: {$hostname}/admin/category.php");
    }
}