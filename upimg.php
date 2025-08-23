<?php
ini_set("max_execution_time", -1);
require_once('wp-load.php');
global $wpdb;  


$servername = "localhost";
$username = "pfcd_49b2";
$password = "giIi^h&^5!%%3XYH";
$dbname = "pfcd_49b4";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



$res2= set_post_thumbnail( 247946, 933 );



echo 'DONE';