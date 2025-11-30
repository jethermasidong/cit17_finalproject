<?php
session_start();
include "config.php";
if(!isset($_SESSION['user_id']) || $_SESSION['role']!=='admin') header("Location: login.php");

$error="";
$success="";

if($_SERVER['REQUEST_METHOD']==='POST'){
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    $stmt = mysqli_prepare($conn,"SELECT password FROM users WHERE user_id=?");
    mysqli_stmt_bind_param($stmt,"i",$_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$hash);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if(!password_verify($current,$hash)){
        $error="Current password incorrect.";
    } elseif($new !== $confirm){
        $error="New password and confirm password do not match.";
    } else {
        $new_hash = password_hash($new,PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($conn, "UPDATE users SET password=? WHERE user_id=?");
        mysqli_stmt_bind_param($stmt, "si", $new_hash, $_SESSION['user_id']);
        if(mysqli_stmt_execute($stmt)){
            $success = "Password changed successfully.";
        } else {
            $error = "Error updating password.";
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Change Admin Password</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
<div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
    <h1 class="text-2xl font-semibold mb-6 text-center text-gray-800">Change Admin Password</h1>

    <?php if($error): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?php echo $error;?></div>
    <?php endif;?>
    <?php if($success): ?>
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4"><?php echo $success;?></div>
    <?php endif;?>

    <form method="POST" class="space-y-5">
        <div class="relative">
            <input type="password" id="current_password" name="current_password" placeholder="Current Password" required class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"/>
            <button type="button" onclick="togglePassword('current_password')" class="absolute right-3 top-2.5 text-gray-500">Show</button>
        </div>
        <div class="relative">
            <input type="password" id="new_password" name="new_password" placeholder="New Password" required class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"/>
            <button type="button" onclick="togglePassword('new_password')" class="absolute right-3 top-2.5 text-gray-500">Show</button>
        </div>


        <div class="relative">
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"/>
            <button type="button" onclick="togglePassword('confirm_password')" class="absolute right-3 top-2.5 text-gray-500">Show</button>
        </div>

        <button class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition-colors">Change Password</button>
    </form>

    <a href="admin.php" class="block mt-4 text-center text-gray-600 hover:underline">Back</a>
</div>

<script>
function togglePassword(id){
    const input = document.getElementById(id);
    if(input.type === "password") input.type = "text";
    else input.type = "password";
}
</script>
</body>
</html>
