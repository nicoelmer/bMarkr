<?php

/* Change scriptURL too */
$scriptURL = "Change to sth like: https://myweb.com/anything/bmark.php";

/* Database connection start */
$servername = "localhost";
$username = "bmarkr";
$password = "";
$dbname = "bmarkr";
$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

?>
