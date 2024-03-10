<?php 

include 'config.php';

# get the post and category id
$post_id = $_GET['id'];
$category_id = $_GET['cat_id'];

# remove file from the folder
$sql1 = "SELECT post_img FROM post WHERE post_id={$post_id};";
$result = mysqli_query($conn, $sql1) or die("Query failed.");
$row = mysqli_fetch_assoc($result);

unlink("upload/".$row['post_img']);

# delete data from database
$sql = "DELETE FROM post WHERE post_id={$post_id};";
$sql .= "UPDATE category SET post = post - 1 WHERE category_id={$category_id};";

$result = mysqli_multi_query($conn, $sql) or die("query failed.");

if($result) {
    header("Location: {$hostname}/admin/post.php");
} else {
    echo "<p>Data Can't delete.</p>";
}

