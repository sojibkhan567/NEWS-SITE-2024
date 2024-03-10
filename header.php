<?php

include "admin/config.php";
# show dynamic page title
$page = basename($_SERVER['PHP_SELF']);

switch ($page) {
    case 'single.php':
        # get post title
        if (isset($_GET['id'])) {
            $sql_title = "SELECT * FROM post WHERE post_id={$_GET['id']}";
            $result_title = mysqli_query($conn, $sql_title) or die("Query failed.");
            $row_title = mysqli_fetch_assoc($result_title);
            $page_title = $row_title['title'];
        } else {
            $page_title = "No Post Found";
        }
        break;
    case 'category.php':
        # get category name
        if (isset($_GET['cat_id'])) {
            $sql_title = "SELECT * FROM category WHERE category_id={$_GET['cat_id']}";
            $result_title = mysqli_query($conn, $sql_title) or die("Query failed.");
            $row_title = mysqli_fetch_assoc($result_title);
            $page_title = $row_title['category_name'];
        } else {
            $page_title = "No Post Found";
        }
        break;
    case 'author.php':
        # get author name
        if (isset($_GET['author_id'])) {
            $sql_title = "SELECT * FROM user WHERE user_id={$_GET['author_id']}";
            $result_title = mysqli_query($conn, $sql_title) or die("Query failed.");
            $row_title = mysqli_fetch_assoc($result_title);
            $page_title = "News By ".$row_title['first_name']." ".$row_title['last_name'];
        } else {
            $page_title = "No Post Found";
        }
        break;
    case 'search.php':
        # get search value
        if (isset($_GET['search'])) {
           $page_title = $_GET['search'];
        } else {
            $page_title = "No Post Found";
        }
        break;

    default:
        $page_title = "Home";
        break;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>NEWS SITE | <?php echo $page_title ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class=" col-md-offset-4 col-md-4">
                    <a href="index.php" id="logo"><img src="images/news.jpg"></a>
                </div>
                <!-- /LOGO -->
            </div>
        </div>
    </div>
    <!-- /HEADER -->
    <!-- Menu Bar -->
    <div id="menu-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    include "admin/config.php";

                    # get category id from url
                    if (isset($_GET['cat_id'])) {
                        $cat_id = $_GET['cat_id'];
                    }

                    # show category as menu 
                    $sql = "SELECT * FROM category WHERE post > 0;";
                    $result = mysqli_query($conn, $sql) or die("Query failed.");
                    if (mysqli_num_rows($result) > 0) {
                        $active = "";
                    ?>
                        <ul class='menu'>
                            <li><a href="<?php echo $hostname ?>">Home</a></li>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                # show active menu
                                if (isset($_GET['cat_id'])) {
                                    if ($row['category_id'] == $cat_id) {
                                        $active = "active";
                                    } else {
                                        $active = "";
                                    }
                                }
                                echo "<li><a class='{$active}' href='category.php?cat_id={$row['category_id']}'>{$row['category_name']}</a></li>";
                            } ?>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /Menu Bar -->