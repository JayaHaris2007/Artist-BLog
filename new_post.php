<?php
include "db.php";
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $title = $_POST["title"];
    $content = $_POST["content"];
    $image = "";
    $video = "";

    if (!empty($_FILES["image"]["name"])) {
        $image = time() . "_" . $_FILES["image"]["name"];
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $image);
    }
    if (!empty($_FILES["video"]["name"])) {
        $video = time() . "_" . $_FILES["video"]["name"];
        move_uploaded_file($_FILES["video"]["tmp_name"], "uploads/" . $video);
    }

    $conn->query("INSERT INTO posts (user_id, title, content, image, video) VALUES ($user_id, '$title', '$content', '$image', '$video')");
    header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold text-center">Create Post</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Title" required class="w-full p-2 border rounded mb-3"><br>
            <textarea name="content" placeholder="Write your post..." required class="w-full p-2 border rounded mb-3"></textarea><br>
            <input type="file" name="image" accept="image/*" class="mb-2"><br>
            <input type="file" name="video" accept="video/*" class="mb-2"><br>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Post</button>
        </form>
    </div>
</body>
</html>
