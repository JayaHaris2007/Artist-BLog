<?php
$host = "sql102.infinityfree.com";
$user = "if0_38636018"; 
$pass = "MVLk76YXmSWx"; 
$dbname = "if0_38636018_artist_blog";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
