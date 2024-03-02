<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = "news-site";

// Connection
$conn = mysqli_connect(
    $servername,
    $username,
    $password,
    $db
);

// Check if connection is 
// Successful or not
if (!$conn) {
    die("Connection failed: "
        . mysqli_connect_error());
}
//echo "Connected successfully";


//declare global URL
$hostname = "http://localhost/news-site-2024";
