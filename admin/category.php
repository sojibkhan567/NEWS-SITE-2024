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

//fetch the data form database
$limit = 5;
//set the page number
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM category ORDER BY category_id DESC LIMIT {$offset},{$limit}";
$result = mysqli_query($conn, $sql) or die("Query failed.");

?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">
                <?php 
                if (mysqli_num_rows($result) > 0) {
        
                ?>
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Category Name</th>
                        <th>No. of Posts</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        <?php 
                        //show the data
                        $serial_no = $offset + 1;

                        while ($rows = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td class='id'><?php echo $serial_no ?></td>
                            <td><?php echo $rows['category_name'] ?></td>
                            <td><?php echo $rows['post'] ?></td>
                            <td class='edit'><a href='update-category.php?id=<?php echo $rows['category_id'] ?>'><i class='fa fa-edit'></i></a></td>
                            <td class='delete'><a href='delete-category.php?id=<?php echo $rows['category_id'] ?>'><i class='fa fa-trash-o'></i></a></td>
                        </tr>
                        <?php $serial_no++; } ?>
                    </tbody>
                </table>
                <?php } else {
                    echo "<p>No data found.</p>";
                } ?>
                <?php 
                  //pagination
                  $sql1 = "SELECT * FROM category";
                  $result = mysqli_query($conn, $sql1) or die("Query failed.");
                  $totalRecords = mysqli_num_rows($result);
                  //$limit = 3;
                  $totalPages = ceil($totalRecords / $limit);
                  
                  echo "<ul class='pagination admin-pagination'>";
                  //prev btn
                  if ($page > 1) {
                    echo '<li><a href="category.php?page='.($page - 1).'">Prev</a></li>';
                  }
                  for ($i=1; $i <= $totalPages ; $i++) { 
                    if ($i == $page) {
                        $active = "active";
                    } else {
                        $active = " ";
                    }
                    echo "<li class='$active'><a href='category.php?page=$i'>".$i."</a></li>";
                  }
                  //next btn
                  if ($totalPages > $page) {
                    echo '<li><a href="category.php?page='.($page + 1).'">Next</a></li>';
                  }
                  echo "</ul>";
                  ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
