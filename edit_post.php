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

// Fetch post details
$result = $conn->query("SELECT * FROM posts WHERE id=$post_id AND user_id=$user_id");
if ($result->num_rows == 0) {
    die("<h2 class='text-center text-red-500'>Post not found!</h2>");
}

$post = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST["title"]);
    $content = $conn->real_escape_string($_POST["content"]);

    $update_query = "UPDATE posts SET title='$title', content='$content' WHERE id=$post_id AND user_id=$user_id";

    // Handle image upload
    if (!empty($_FILES["image"]["name"])) {
        $image_name = time() . "_" . $_FILES["image"]["name"];
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $image_name);
        $update_query = "UPDATE posts SET title='$title', content='$content', image='$image_name' WHERE id=$post_id AND user_id=$user_id";
    }

    // Handle video upload
    if (!empty($_FILES["video"]["name"])) {
        $video_name = time() . "_" . $_FILES["video"]["name"];
        move_uploaded_file($_FILES["video"]["tmp_name"], "uploads/" . $video_name);
        $update_query = "UPDATE posts SET title='$title', content='$content', video='$video_name' WHERE id=$post_id AND user_id=$user_id";
    }

    if ($conn->query($update_query)) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<h2 class='text-red-500 text-center'>Error updating post.</h2>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Post</title>
</head>
<body class="bg-gray-100">
    <div class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-3xl font-bold text-center mb-4">Edit Post</h2>
        
        <form action="" method="POST" enctype="multipart/form-data">
            <label class="block text-gray-700">Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" class="w-full p-2 border rounded mb-4" required>

            <label class="block text-gray-700">Content:</label>
            <textarea name="content" class="w-full p-2 border rounded mb-4" required><?php echo htmlspecialchars($post['content']); ?></textarea>

            <label class="block text-gray-700">Image:</label>
            <?php if (!empty($post["image"])): ?>
                <img src="uploads/<?php echo htmlspecialchars($post['image']); ?>" class="w-full rounded-lg mb-2">
            <?php endif; ?>
            <input type="file" name="image" class="w-full p-2 border rounded mb-4">

            <label class="block text-gray-700">Video:</label>
            <?php if (!empty($post["video"])): ?>
                <video class="w-full rounded-lg mb-2" controls>
                    <source src="uploads/<?php echo htmlspecialchars($post['video']); ?>" type="video/mp4">
                </video>
            <?php endif; ?>
            <input type="file" name="video" class="w-full p-2 border rounded mb-4">

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded w-full">Update Post</button>
        </form>

        <a href="dashboard.php" class="block text-center text-gray-500 mt-4">← Back to Dashboard</a>
    </div>
</body>
</html>
