<?php
include "db.php";
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Check if post ID is valid
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("<h2 class='text-center text-red-500'>Invalid post ID!</h2>");
}

$post_id = intval($_GET["id"]);

// Get post details
$result = $conn->query("SELECT * FROM posts WHERE id=$post_id AND user_id=$user_id");
if ($result->num_rows == 0) {
    die("<h2 class='text-center text-red-500'>Post not found or unauthorized access!</h2>");
}

$post = $result->fetch_assoc();

// Delete associated files (image & video)
if (!empty($post["image"]) && file_exists("uploads/" . $post["image"])) {
    unlink("uploads/" . $post["image"]);
}
if (!empty($post["video"]) && file_exists("uploads/" . $post["video"])) {
    unlink("uploads/" . $post["video"]);
}

// Delete the post from the database
$delete_query = "DELETE FROM posts WHERE id=$post_id AND user_id=$user_id";
if ($conn->query($delete_query)) {
    header("Location: dashboard.php");
    exit();
} else {
    echo "<h2 class='text-red-500 text-center'>Error deleting post.</h2>";
}
?>
