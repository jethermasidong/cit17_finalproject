<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'tutor') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Tutor Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-50 min-h-screen p-6">

<div class="max-w-5xl mx-auto">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-10">
        <h1 class="text-3xl font-bold text-gray-800">Tutor Dashboard</h1>

        <a href="logout.php" 
            class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
            Logout
        </a>
    </div>

    <!-- GRID CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- BOOKINGS -->
        <a href="bookings.php"
            class="group p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition">
            
            <div class="flex items-center gap-4">
                <div class="p-3 bg-indigo-100 rounded-full">
                    <i data-lucide="calendar" class="w-6 h-6 text-indigo-600"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">My Bookings</h2>
                    <p class="text-sm text-gray-500">View your scheduled tutoring sessions</p>
                </div>
            </div>
        </a>

        <!-- REVIEWS -->
        <a href="reviews.php"
            class="group p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition">
            
            <div class="flex items-center gap-4">
                <div class="p-3 bg-pink-100 rounded-full">
                    <i data-lucide="star" class="w-6 h-6 text-pink-600"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">My Reviews</h2>
                    <p class="text-sm text-gray-500">See feedback from your students</p>
                </div>
            </div>
        </a>

    </div>

</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>
