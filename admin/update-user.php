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
$sql = "SELECT * FROM user WHERE user_id={$id}";
$result = mysqli_query($conn, $sql) or die("Query failed.");

//update user data
if (isset($_POST['submit'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $first_name = mysqli_real_escape_string($conn, $_POST['fname']);
    $last_name = mysqli_real_escape_string($conn, $_POST['lname']);
    $user_name = mysqli_real_escape_string($conn, $_POST['username']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $sql1 = "UPDATE user SET user_id={$user_id}, first_name='{$first_name}', last_name='{$last_name}', username='{$user_name}', role='{$role}' WHERE user_id={$user_id}";

    $result = mysqli_query($conn, $sql1) or die("Query failed.");
    //url redirect
    if ($result) {
        header("Location: {$hostname}/admin/users.php");
    }
}

?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Modify User Details</h1>
            </div>
            <div class="col-md-offset-4 col-md-4">

                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($rows = mysqli_fetch_assoc($result)) {
                ?>
                        <!-- Form Start -->
                        <form action="" method="POST">
                            <div class="form-group">
                                <input type="hidden" name="user_id" class="form-control" value="<?php echo $rows['user_id'] ?>" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="fname" class="form-control" value="<?php echo $rows['first_name'] ?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="lname" class="form-control" value="<?php echo $rows['last_name'] ?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>User Name</label>
                                <input type="text" name="username" class="form-control" value="<?php echo $rows['username'] ?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>User Role</label>
                                <select class="form-control" name="role" value="<?php echo $rows['role']; ?>">
                                    <?php
                                    if ($rows['role'] == 1) {
                                        echo '<option value="0">normal User</option>
                                      <option value="1" selected>Admin</option>';
                                    } else {
                                        echo '<option value="0" selected>normal User</option>
                                <option value="1">Admin</option>';
                                    }

                                    ?>
                                </select>
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                        </form>
                        <!-- /Form -->
                <?php }
                } ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>