<?php
include "db.php";
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION["user_id"];
$result = $conn->query("SELECT * FROM posts WHERE user_id=$user_id ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dashboard</title>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <nav class="bg-black text-white shadow-md p-4 flex justify-between">
        <h1 class="text-2xl font-bold">👤 User Dashboard</h1>
        <div>
            <a href="index.php" class="text-blue-300 mr-4">🏠 Back to Home</a>
            <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded">Logout</a>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md mt-6 flex-1">
        <h2 class="text-3xl font-bold text-center mb-4">Your Posts</h2>
        
        <a href="new_post.php" class="block bg-green-500 text-white text-center py-2 rounded mb-6">➕ Add New Post</a>

        <?php while ($post = $result->fetch_assoc()): ?>
            <div class="bg-gray-50 p-4 rounded-lg shadow-md mb-4">
                <h4 class="text-xl font-bold"><?php echo htmlspecialchars($post["title"]); ?></h4>
                <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($post["content"])); ?></p>

                <?php if (!empty($post["image"])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($post['image']); ?>" class="w-full mt-2 rounded-lg">
                <?php endif; ?>

                <?php if (!empty($post["video"])): ?>
                    <video class="w-full mt-2 rounded-lg" controls>
                        <source src="uploads/<?php echo htmlspecialchars($post['video']); ?>" type="video/mp4">
                    </video>
                <?php endif; ?>

                <div class="mt-4 flex space-x-2">
                    <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="bg-blue-500 text-white px-4 py-2 rounded">✏️ Edit</a>
                    <a href="delete_post.php?id=<?php echo $post['id']; ?>" class="bg-red-500 text-white px-4 py-2 rounded" onclick="return confirm('Are you sure you want to delete this post?');">🗑️ Delete</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <footer class="bg-black text-white text-center p-4 mt-auto">
        <p>Created by : Jaya Haris, Niyal Ahmed, Sanjay, Sabari, Nithish Kumar, and Maria Rosario Antony</p>
    </footer>
</body>
</html>
