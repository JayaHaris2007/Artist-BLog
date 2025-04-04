<?php
include "db.php";
session_start();
$posts = $conn->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Artist Blog</title>
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
<body class="bg-gray-100">
    <nav class="bg-black text-white shadow-md p-4 flex justify-between">
        <h1 class="text-2xl font-bold">🎨 Artist Blog</h1>
        <div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php" class="text-green-400 mr-4">Dashboard</a>
                <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded">Logout</a>
            <?php else: ?>
                <a href="login.php" class="text-blue-400 mr-4">Login</a>
                <a href="register.php" class="bg-blue-500 text-white px-4 py-2 rounded">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="content max-w-6xl mx-auto mt-6">
        <h2 class="text-3xl font-bold text-center mb-4">Explore Artworks & Blogs</h2>

        <!-- Horizontal Scrollable Container -->
        <div class="flex space-x-6 overflow-x-auto p-4">
            <?php while ($post = $posts->fetch_assoc()): ?>
                <a href="post.php?id=<?php echo $post['id']; ?>" class="block bg-white p-6 rounded-lg shadow-md w-80 flex-shrink-0 hover:shadow-lg transition">
                    <h3 class="text-xl font-bold"><?php echo $post["title"]; ?></h3>
                    <p class="text-gray-700">By <span class="font-semibold"><?php echo $post["username"]; ?></span></p>
                    
                    <?php if ($post["image"]): ?>
                        <img src="uploads/<?php echo $post['image']; ?>" class="w-full mt-2 rounded-lg">
                    <?php endif; ?>

                    <?php if ($post["video"]): ?>
                        <video class="w-full mt-2 rounded-lg" controls>
                            <source src="uploads/<?php echo $post['video']; ?>" type="video/mp4">
                        </video>
                    <?php endif; ?>

                    <p class="text-sm text-gray-500 mt-2"><?php echo date("F j, Y, g:i a", strtotime($post["created_at"])); ?></p>
                </a>
            <?php endwhile; ?>
        </div>
    </div>

    <footer class="bg-black text-white text-center p-4 mt-auto">
        <p>Created by : Jaya Haris, Niyal Ahmed, Sanjay, Sabari, Nithish Kumar, and Maria Rosario Antony</p>
    </footer>
</body>
</html>
