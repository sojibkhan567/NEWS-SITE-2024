<?php include "header.php"; ?>
<?php 
include "config.php";
if($_SESSION['role']==0){
    header("Location: {$hostname}/admin/post.php");
}
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Add New Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                <?php 

                include "config.php";
                // get data from input
                if(isset($_POST['save'])) {
                    $category = mysqli_real_escape_string($conn, $_POST['category']);

                    $sql = "INSERT INTO category(category_name) VALUES('{$category}')";

                    $result = mysqli_query($conn, $sql) or die("query failed.");

                    if ($result) {
                        header("Location: {$hostname}/admin/category.php");
                    } else {
                        echo "<p>Something went wrong.</p>";
                    }
                }

                ?>
                  <!-- Form Start -->
                  <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="category" class="form-control" placeholder="Category Name" required>
                      </div>
                      <input type="submit" name="save" class="btn btn-primary" value="Save" required />
                  </form>
                  <!-- /Form End -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
