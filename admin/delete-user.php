<?php

include "config.php";

echo $user_id = $_GET['id'];

$sql = "DELETE FROM user WHERE user_id = {$user_id}";

$result = mysqli_query($conn, $sql) or die("Query failed");

if($result) {
    header("Location: {$hostname}/admin/users.php");
} else {
    echo "<p>Data Can't delete.</p>";
}

mysqli_close($conn);

?>