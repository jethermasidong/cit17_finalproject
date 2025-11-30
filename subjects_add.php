<?php
session_start();
include "config.php";
if (!isset($_SESSION['user_id']) || $_SESSION['role']!=='admin') header("Location: login.php");

$error="";
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $name = trim($_POST['subject_name']);
    $stmt = mysqli_prepare($conn,"INSERT INTO subjects (subject_name) VALUES (?)");
    mysqli_stmt_bind_param($stmt,"s",$name);
    if(mysqli_stmt_execute($stmt)) header("Location: subjects.php");
    else $error="Error adding subject.";
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Add Subject</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center px-4">

<div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">

    <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">Add Subject</h1>

    <?php if($error): ?>
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm text-center">
        <?php echo $error;?>
    </div>
    <?php endif;?>

    <form method="POST" class="space-y-5">
        <input type="text" name="subject_name" placeholder="Subject Name" required
            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none"/>

        <button class="w-full bg-green-600 text-white font-medium py-3 rounded-lg hover:bg-green-700 transition">Add Subject</button>

        <a href="subjects.php" class="block text-center mt-3 text-gray-600 hover:underline">Back</a>
    </form>

</div>

</body>
</html>
