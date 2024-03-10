<?php

include "config.php";

if (empty($_FILES['new-image']['name'])) {
    $file_name = $_POST['old-image'];
} else {
    # image file upload

    $errors = array();

    # old image data
    $old_file_name = $_POST['old-image'];

    //print_r($_FILES['new-image']);
    $file_name = $_FILES['new-image']['name'];
    $file_size = $_FILES['new-image']['size'];
    $file_tmp = $_FILES['new-image']['tmp_name'];
    $file_type = $_FILES['new-image']['type'];
    $tmp = explode('.', $file_name);
    $file_ext = end($tmp);

    $upfile_ext = strtoupper($file_ext);
    //make extension array
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
        # ulink & upload file
        unlink("upload/" . $old_file_name);
        move_uploaded_file($file_tmp, $target);
    } else {
        print_r($errors);
        die();
    }
}

# get input field data
$post_id = mysqli_real_escape_string($conn, $_POST['post_id']);
$title = mysqli_real_escape_string($conn, $_POST['post_title']);
$description = mysqli_real_escape_string($conn, $_POST['postdesc']);
$category = mysqli_real_escape_string($conn, $_POST['category']);
$date = date("d M, Y");

# get old category id using session
session_start();
$old_cat_id = $_SESSION['old_cat_id'];

//update post data
$sql = "UPDATE post SET title='{$title}', description='{$description}', category={$category}, post_date='{$date}', post_img='{$new_file_name}' WHERE post_id = {$post_id};";

if ($old_cat_id != $category) {
    $sql .= "UPDATE category SET post=post-1 WHERE category_id={$old_cat_id};";
    $sql .= "UPDATE category SET post=post+1 WHERE category_id={$category};";
} elseif ($old_cat_id == $category) {
    $sql .= "UPDATE category SET post=post+0 WHERE category_id={$category};";
}

if (mysqli_multi_query($conn, $sql)) {
    header("Location: {$hostname}/admin/post.php");
}

mysqli_close($conn);
