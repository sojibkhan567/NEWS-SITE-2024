<?php include "header.php"; ?>
<?php

include "config.php";

//fetch the data form database
$limit = 5;
//set the page number from URL
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$offset = ($page - 1) * $limit;
//check the user role
if ($_SESSION["role"] == '1') {
    //fetch post table data using left join
    $sql = "SELECT * FROM post LEFT JOIN category ON post.category = category.category_id LEFT JOIN user ON post.author = user.user_id ORDER BY post_id DESC LIMIT {$offset},{$limit}";
} elseif ($_SESSION["role"] == '0') {
    $sql = "SELECT * FROM post LEFT JOIN category ON post.category = category.category_id LEFT JOIN user ON post.author = user.user_id WHERE post.author = {$_SESSION['user_id']} ORDER BY post_id DESC LIMIT {$offset},{$limit}";
}

$result = mysqli_query($conn, $sql) or die("Query failed.");

?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Posts</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-post.php">add post</a>
            </div>
            <div class="col-md-12">
                <?php
                if (mysqli_num_rows($result) > 0) {
                ?>
                    <table class="content-table">
                        <thead>
                            <th>S.No.</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Author</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            <?php

                            $serial_no = $offset + 1;

                            while ($rows = mysqli_fetch_assoc($result)) {

                            ?>
                                <tr>
                                    <td class='id'><?php echo $serial_no ?></td>
                                    <td><?php echo $rows['title'] ?></td>
                                    <td><?php echo $rows['category_name'] ?></td>
                                    <td><?php echo $rows['post_date'] ?></td>
                                    <td><?php echo $rows['username'] ?></td>
                                    <td class='edit'><a href='update-post.php?id=<?php echo $rows['post_id'] ?>'><i class='fa fa-edit'></i></a></td>
                                    <td class='delete'><a href='delete-post.php?id=<?php echo $rows['post_id'] ?>&cat_id=<?php echo $rows['category'] ?>'><i class='fa fa-trash-o'></i></a></td>
                                </tr>
                            <?php

                            $serial_no++;

                            } ?>
                        </tbody>
                    </table>
                <?php } else {
                    echo "<h3>No Data Found.</h3>";
                } ?>
                <?php
                //pagination
                if ($_SESSION["role"] == '1') {
                    $sql1 = "SELECT * FROM post";
                } elseif ($_SESSION["role"] == '0') {
                    $sql1 = "SELECT * FROM post WHERE post.author = {$_SESSION['user_id']}";
                }

                $result = mysqli_query($conn, $sql1) or die("Query failed.");
                $totalRecords = mysqli_num_rows($result);
                $totalPages = ceil($totalRecords / $limit);

                echo "<ul class='pagination admin-pagination'>";
                //prev btn
                if ($page > 1) {
                    echo '<li><a href="post.php?page=' . ($page - 1) . '">Prev</a></li>';
                }
                for ($i = 1; $i <= $totalPages; $i++) {
                    if ($i == $page) {
                        $active = "active";
                    } else {
                        $active = " ";
                    }
                    echo "<li class='$active'><a href='post.php?page=$i'>" . $i . "</a></li>";
                }
                //next btn
                if ($totalPages > $page) {
                    echo '<li><a href="post.php?page=' . ($page + 1) . '">Next</a></li>';
                }
                echo "</ul>";

                ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>