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
$limit = 4;
//set the page number
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$offset = ($page - 1) * $limit;
$sql = "SELECT * FROM user LIMIT {$offset},{$limit}";
$result = mysqli_query($conn, $sql) or die("Query failed.");

?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Users</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-user.php">add user</a>
              </div>
              <div class="col-md-12">
                <?php 
                if (mysqli_num_rows($result) > 0) { ?>
                    
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Full Name</th>
                          <th>User Name</th>
                          <th>Role</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>

                        <?php 

                        $serial_no = $offset + 1;

                        while ($rows = mysqli_fetch_assoc($result)) { ?>
                          <tr>
                              <td class='id'><?php echo $serial_no ?></td>
                              <td><?php echo $rows['first_name'] ?> <?php echo $rows['last_name'] ?></td>
                              <td><?php echo $rows['username'] ?></td>
                              <td><?php echo ($rows['role']==1) ? "Admin" : "Normal user"; ?></td>
                              <td class='edit'><a href='update-user.php?id=<?php echo $rows['user_id'] ?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-user.php?id=<?php echo $rows['user_id'] ?>'><i class='fa fa-trash-o'></i></a></td>
                           </tr>
                           <?php $serial_no++;} ?>
                      </tbody>
                  </table>
                  <?php } ?>
                
                  <?php 
                  //pagination
                  $sql1 = "SELECT * FROM user";
                  $result = mysqli_query($conn, $sql1) or die("Query failed.");
                  $totalRecords = mysqli_num_rows($result);
                  //$limit = 3;
                  $totalPages = ceil($totalRecords / $limit);
                  
                  echo "<ul class='pagination admin-pagination'>";
                  //prev btn
                  if ($page > 1) {
                    echo '<li><a href="users.php?page='.($page - 1).'">Prev</a></li>';
                  }
                  for ($i=1; $i <= $totalPages ; $i++) { 
                    if ($i == $page) {
                        $active = "active";
                    } else {
                        $active = " ";
                    }
                    echo "<li class='$active'><a href='users.php?page=$i'>".$i."</a></li>";
                  }
                  //next btn
                  if ($totalPages > $page) {
                    echo '<li><a href="users.php?page='.($page + 1).'">Next</a></li>';
                  }
                  echo "</ul>";
                  ?>
              </div>
          </div>
      </div>
  </div>
<?php include "header.php"; ?>
