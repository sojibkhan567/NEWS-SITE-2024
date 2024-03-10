<?php include "header.php"; ?>
<?php 
//diplay page with role 
include "config.php";
if($_SESSION['role']==0){
    header("Location: {$hostname}/admin/post.php");
}
?>
<?php

include "config.php";

$id = $_GET['id'];

//get data using user id
$sql = "SELECT * FROM category WHERE category_id={$id}";
$result = mysqli_query($conn, $sql) or die("Query failed.");

?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="adin-heading"> Update Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                <?php 
                if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_assoc($result) 
                
                ?>
                  <form action="category-update.php" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="category_id"  class="form-control" value="<?php echo $row['category_id'] ?>" placeholder="">
                      </div>
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="category_name" class="form-control" value="<?php echo $row['category_name'] ?>"  placeholder="" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update"/>
                  </form>
                  <?php  } else {
                    echo "<p>No data found.</p>";
                  } ?>
                </div>
              </div>
            </div>
          </div>
<?php include "footer.php"; ?>
