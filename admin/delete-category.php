<?php 
//diplay page with role 
include "config.php";
if($_SESSION['role']==0){
    header("Location: {$hostname}/admin/post.php");
}
?>
<?php

include "config.php";

$category_id = $_GET['id'];

$sql = "DELETE FROM category WHERE category_id = {$category_id};";

$result = mysqli_query($conn, $sql) or die("Query failed");

if($result) {
    header("Location: {$hostname}/admin/category.php");
} else {
    echo "<p>Data Can't delete.</p>";
}

mysqli_close($conn);

?>

