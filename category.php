<?php include 'header.php'; ?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <?php 
                    
                    # show category head title
                    $sql1 ="SELECT * FROM category WHERE category_id={$cat_id};";
                    $result1 = mysqli_query($conn, $sql1) or die("Query failed.");

                    $data = mysqli_fetch_assoc($result1);

                    ?>
                    <h2 class="page-heading"><?php echo $data['category_name'] ?></h2>
                    <?php

                    include "admin/config.php";

                    $cat_id = $_GET['cat_id'];

                    # set list of showing post
                    $limit = 4;

                    //set the page number from URL
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                    } else {
                        $page = 1;
                    }

                    $offset = ($page - 1) * $limit;

                    $sql = "SELECT * FROM post LEFT JOIN category ON post.category = category.category_id LEFT JOIN user ON post.author = user.user_id WHERE category={$cat_id} ORDER BY post.post_date DESC LIMIT {$offset},{$limit};";

                    $result = mysqli_query($conn, $sql) or die("query failed");

                    if (mysqli_num_rows($result) > 0) {

                        while ($row = mysqli_fetch_assoc($result)) {

                    ?>
                            <div class="post-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a class="post-img" href="single.php?id=<?php echo $row['post_id'] ?>"><img src="admin/upload/<?php echo $row['post_img'] ?>" alt="" /></a>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="inner-content clearfix">
                                            <h3><a href='single.php?id=<?php echo $row['post_id'] ?>'><?php echo $row['title'] ?></a></h3>
                                            <div class="post-information">
                                                <span>
                                                    <i class="fa fa-tags" aria-hidden="true"></i>
                                                    <a href='category.php?cat_id=<?php echo $row['category_id'] ?>'><?php echo $row['category_name'] ?></a>
                                                </span>
                                                <span>
                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                    <a href='author.php?author_id=<?php echo $row['author'] ?>'><?php echo $row['username'] ?></a>
                                                </span>
                                                <span>
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    <?php echo $row['post_date'] ?>
                                                </span>
                                            </div>
                                            <p class="description"><?php echo substr($row['description'], 0, 170) ?>....</p>
                                            <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id'] ?>'>read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php }
                    } else {
                        echo "<h1>No Record found.</h1>";
                    } ?>

                    <?php

                    # frontend category pagination

                    $sql1 = "SELECT post FROM category WHERE category_id = {$cat_id}";
                    $result = mysqli_query($conn, $sql1) or die("Query failed.");
                    $row = mysqli_fetch_assoc($result);
                    $totalRecords = $row['post'];
                    $totalPages = ceil($totalRecords / $limit);

                    echo "<ul class='pagination admin-pagination'>";
                    //prev btn
                    if ($page > 1) {
                        echo '<li><a href="category.php?cat_id='.$cat_id.'&page=' . ($page - 1) . '">Prev</a></li>';
                    }
                    for ($i = 1; $i <= $totalPages; $i++) {
                        if ($i == $page) {
                            $active = "active";
                        } else {
                            $active = " ";
                        }
                        
                        echo '<li class='.$active.'><a href="category.php?cat_id='.$cat_id.'&page=' . $i . '">'.$i.'</a></li>';
                    }
                    //next btn
                    if ($totalPages > $page) {
                        echo '<li><a href="category.php?cat_id='.$cat_id.'&page=' . ($page + 1) . '">Next</a></li>';
                    }
                    echo "</ul>";
                    ?>

                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>