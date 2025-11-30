<?php
session_start();
include "config.php";
if (!isset($_SESSION['user_id']) || $_SESSION['role']!=='admin') header("Location: login.php");

$error = "";
$id = $_GET['id'] ?? 0;
$res = mysqli_query($conn, "SELECT * FROM users WHERE user_id=".$id);
$user = mysqli_fetch_assoc($res);

if (!$user) { header("Location: users.php"); exit(); }

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $password = $_POST['password'] ?? '';

    if ($password) $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = $password ? 
        "UPDATE users SET name=?, email=?, role=?, password=? WHERE user_id=?" : 
        "UPDATE users SET name=?, email=?, role=? WHERE user_id=?";

    $stmt = mysqli_prepare($conn,$sql);

    if ($password) mysqli_stmt_bind_param($stmt,"ssssi",$name,$email,$role,$hash,$id);
    else mysqli_stmt_bind_param($stmt,"sssi",$name,$email,$role,$id);

    if (mysqli_stmt_execute($stmt)) { header("Location: users.php"); exit(); }
    else $error = "Error updating user.";
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Edit User</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center px-4">

<div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">

    <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">Edit User</h1>

    <?php if($error): ?>
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm text-center">
        <?php echo $error; ?>
    </div>
    <?php endif; ?>

    <form method="POST" class="space-y-5">

        <input type="text" name="name" placeholder="Name" value="<?php echo htmlspecialchars($user['name']); ?>" required
            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"/>

        <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($user['email']); ?>" required
            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"/>

        <input type="password" name="password" placeholder="Password (leave blank to keep)" 
            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"/>

        <select name="role" required
            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <option value="admin" <?php if($user['role']==='admin') echo 'selected'; ?>>Admin</option>
            <option value="tutor" <?php if($user['role']==='tutor') echo 'selected'; ?>>Tutor</option>
            <option value="student" <?php if($user['role']==='student') echo 'selected'; ?>>Student</option>
        </select>

        <button class="w-full bg-blue-600 text-white font-medium py-3 rounded-lg hover:bg-blue-700 transition">Update User</button>

        <a href="users.php" class="block text-center mt-3 text-gray-600 hover:underline">Back</a>
    </form>
</div>

</body>
</html>
