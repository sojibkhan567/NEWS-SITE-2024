
<?php 

include "config.php";

//destory session
session_start();
session_unset();
session_destroy();

header("Location: {$hostname}/admin/");