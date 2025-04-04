<?php
include "db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION["user_id"] = $user["id"];
        header("Location: dashboard.php");
    } else {
        echo "<p class='text-red-500 text-center'>Invalid login!</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold mb-4 text-center">Login</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required class="w-full p-2 border rounded mb-3"><br>
            <input type="password" name="password" placeholder="Password" required class="w-full p-2 border rounded mb-3"><br>
            <button type="submit" class="w-full bg-green-500 text-white py-2 rounded hover:bg-green-600">Login</button>
        </form>
        <p class="text-center mt-3">Don't have an account? <a href="register.php" class="text-blue-500">Register</a></p>
    </div>
</body>
</html>
