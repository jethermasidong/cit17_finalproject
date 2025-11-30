<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role']!=='admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen p-10 flex flex-col items-center">


    <h1 class="text-5xl font-extrabold text-gray-900 mb-16">Admin Dashboard</h1>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-12">

        <a href="users.php" class="group flex flex-col items-center justify-center bg-white rounded-3xl w-40 h-40 shadow-md hover:shadow-2xl hover:scale-110 transition">
            <svg class="w-14 h-14 text-blue-600 mb-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.24 0 4.362.515 6.25 1.432M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="text-gray-800 font-semibold text-lg text-center">Users</span>
        </a>

        <a href="subjects.php" class="group flex flex-col items-center justify-center bg-white rounded-3xl w-40 h-40 shadow-md hover:shadow-2xl hover:scale-110 transition">
            <svg class="w-14 h-14 text-green-600 mb-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.567-3 3.5S10.343 15 12 15s3-1.567 3-3.5S13.657 8 12 8z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v6m0 0H9m3 0h3" />
            </svg>
            <span class="text-gray-800 font-semibold text-lg text-center">Subjects</span>
        </a>

        <a href="schedules.php" class="group flex flex-col items-center justify-center bg-white rounded-3xl w-40 h-40 shadow-md hover:shadow-2xl hover:scale-110 transition">
            <svg class="w-14 h-14 text-purple-600 mb-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z" />
            </svg>
            <span class="text-gray-800 font-semibold text-lg text-center">Schedules</span>
        </a>

        <a href="bookings.php" class="group flex flex-col items-center justify-center bg-white rounded-3xl w-40 h-40 shadow-md hover:shadow-2xl hover:scale-110 transition">
            <svg class="w-14 h-14 text-indigo-600 mb-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7v10m8-10v10M3 5h18M5 5v14h14V5" />
            </svg>
            <span class="text-gray-800 font-semibold text-lg text-center">Bookings</span>
        </a>

        <a href="reviews.php" class="group flex flex-col items-center justify-center bg-white rounded-3xl w-40 h-40 shadow-md hover:shadow-2xl hover:scale-110 transition">
            <svg class="w-14 h-14 text-pink-600 mb-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 12h2m-1-1v2m-9 7h18a2 2 0 002-2V7a2 2 0 00-2-2H5l-2 2v10a2 2 0 002 2z" />
            </svg>
            <span class="text-gray-800 font-semibold text-lg text-center">Reviews</span>
        </a>

        <a href="change_admin_password.php" class="group flex flex-col items-center justify-center bg-white rounded-3xl w-40 h-40 shadow-md hover:shadow-2xl hover:scale-110 transition">
            <svg class="w-14 h-14 text-gray-800 mb-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.105 0 2 .895 2 2s-.895 2-2 2-2-.895-2-2 .895-2 2-2z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7V4m0 0a4 4 0 014 4v3m-8 0V8a4 4 0 014-4z" />
            </svg>
            <span class="text-gray-800 font-semibold text-lg text-center">Password</span>
        </a>

        <a href="logout.php" class="group flex flex-col items-center justify-center bg-white rounded-3xl w-40 h-40 shadow-md hover:shadow-2xl hover:scale-110 transition">
            <svg class="w-14 h-14 text-red-600 mb-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 8v8a4 4 0 004 4h4" />
            </svg>
            <span class="text-gray-800 font-semibold text-lg text-center">Logout</span>
        </a>

    </div>

</body>
</html>
