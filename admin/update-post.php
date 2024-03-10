<?php include "header.php"; 

include "config.php";

if ($_SESSION['role'] == 0) {
    $post_id = $_GET['id'];

    $auth_sql = "SELECT author FROM post WHERE post_id={$post_id}";
    $data = mysqli_query($conn, $auth_sql) or die("Query failed.");
    $row3 = mysqli_fetch_assoc($data);

    if ($row3['author']!= $_SESSION['user_id']) {
        header("Location: {$hostname}/admin/post.php");
    }
}
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Update Post</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <?php
                # get the id
                $post_id = $_GET['id'];

                $sql1 = "SELECT * FROM post WHERE post_id = {$post_id}";
                $data = mysqli_query($conn, $sql1) or die("Query Failed.");

                if (mysqli_num_rows($data) > 0) {

                    while ($post = mysqli_fetch_assoc($data)) {
                        # set the old category value to transfer
                        $_SESSION['old_cat_id'] = $post['category'];
                ?>
                        <!-- Form for show edit-->
                        <form action="save-update-post.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                            <div class="form-group">
                                <input type="hidden" name="post_id" class="form-control" value="<?php echo $post['post_id'] ?>" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputTile">Title</label>
                                <input type="text" name="post_title" class="form-control" id="exampleInputUsername" value="<?php echo $post['title'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Description</label>
                                <textarea name="postdesc" class="form-control" required rows="5"><?php echo $post['description'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <?php
                                //show category data
                                include "config.php";

                                $sql = "SELECT * FROM category";

                                $result = mysqli_query($conn, $sql) or die("Query failed.");

                                ?>
                                <label for="exampleInputPassword1">Category</label>
                                <select name="category" class="form-control">
                                    <option value="" selected> Select Category</option>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        # show selected data
                                        if ($post['category'] == $row['category_id']) {
                                            $select = "selected";
                                        } else {
                                            $select = " ";
                                        }
                                        echo "<option value='{$row['category_id']}' {$select}> {$row['category_name']}</option>";
                                    }

                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Post image</label>
                                <input type="file" name="new-image">
                                <img src="upload/<?php echo $post['post_img'] ?>" height="150px" alt="No image found">
                                <input type="hidden" name="old-image" value="<?php echo $post['post_img'] ?>">
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
                        </form>
                <?php }
                } else {
                    echo "<h2>No data found.</h2>";
                }
                ?>
                <!-- Form End -->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>