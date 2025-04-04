<?php
include "db.php";
session_start();

// Check if 'id' is set and is a valid number
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("<h2 class='text-center text-red-500'>Invalid post!</h2>");
}

$post_id = intval($_GET["id"]);

// Fetch the post
$result = $conn->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = $post_id");

if ($result->num_rows == 0) {
    die("<h2 class='text-center text-red-500'>Post not found!</h2>");
}

$post = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title><?php echo htmlspecialchars($post["title"]); ?> - Artist Blog</title>
    <style>
        html, body {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .content {
            flex: 1;
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <nav class="bg-black text-white shadow-md p-4 flex justify-between">
        <h1 class="text-2xl font-bold">🎨 Artist Blog</h1>
        <a href="index.php" class="text-blue-400">Back to Home</a>
    </nav>

    <div class="content max-w-3xl mx-auto mt-6 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-3xl font-bold"><?php echo htmlspecialchars($post["title"]); ?></h2>
        <p class="text-gray-700">By <span class="font-semibold"><?php echo htmlspecialchars($post["username"]); ?></span></p>

        <?php if (!empty($post["image"])): ?>
            <img src="uploads/<?php echo htmlspecialchars($post['image']); ?>" class="w-full mt-2 rounded-lg">
        <?php endif; ?>

        <?php if (!empty($post["video"])): ?>
            <video class="w-full mt-2 rounded-lg" controls>
                <source src="uploads/<?php echo htmlspecialchars($post['video']); ?>" type="video/mp4">
            </video>
        <?php endif; ?>

        <p class="text-gray-800 mt-4"><?php echo nl2br(htmlspecialchars($post["content"])); ?></p>
        <p class="text-sm text-gray-500 mt-2"><?php echo date("F j, Y, g:i a", strtotime($post["created_at"])); ?></p>
    </div>

    <footer class="bg-black text-white text-center p-4 mt-auto">
        <p>Created by : Jaya Haris, Niyal Ahmed, Sanjay, Sabari, Nithish Kumar, and Maria Rosario Antony</p>
    </footer>
</body>
</html>
