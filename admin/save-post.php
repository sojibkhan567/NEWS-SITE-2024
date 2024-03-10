<?php

include "config.php";

//image file upload
if (isset($_FILES['image'])) {
    $errors = array();

    //print_r($_FILES['image']);
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $tmp = explode('.', $file_name);
    $file_ext = end($tmp);

    $upfile_ext = strtoupper($file_ext);

    //die();

    $extensions = ["jpeg", "jpg", "png", "JPEG", "JPG", 'PNG'];

    if (in_array($file_ext, $extensions)  === false) {
        $errors[] = "The extension file not allowed, please upload png and jpg.";
    }

    if ($file_size > 2097152) {
        $errors[] = "File size must be 2 MB or lower.";
    }

    $new_file_name = rand() . "-" . basename($file_name);
    //die();
    $target = "upload/" . $new_file_name;

    if (empty($errors) == true) {
        move_uploaded_file($file_tmp, $target);
    } else {
        print_r($errors);
        die();
    }
}

session_start();
$title = mysqli_real_escape_string($conn, $_POST['post_title']);
$description = mysqli_real_escape_string($conn, $_POST['postdesc']);
$category = mysqli_real_escape_string($conn, $_POST['category']);
$date = date("d M, Y");
$author = $_SESSION['user_id'];
//insert post data
$sql = "INSERT INTO post(title, description, category, post_date, author, post_img) VALUES('{$title}','{$description}','{$category}','{$date}','{$author}','{$new_file_name}');";
//update category
$sql .= "UPDATE category SET post = post + 1 WHERE category_id={$category};";

if (mysqli_multi_query($conn, $sql)) {
    header("Location: {$hostname}/admin/post.php");
}
