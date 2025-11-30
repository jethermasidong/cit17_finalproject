<?php
session_start();
include "config.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role']!=='student') header("Location: login.php");

$student_id = $_SESSION['user_id'];

// Fetch student's bookings
$bookings_res = mysqli_query($conn, "
    SELECT b.booking_id, t.name AS tutor_name, t.user_id AS tutor_id, s.subject_id, sub.subject_name, 
           s.day_of_week, s.start_time, s.end_time, b.status
    FROM bookings b
    JOIN tutor_schedules s ON b.schedule_id = s.schedule_id
    JOIN users t ON s.tutor_id = t.user_id
    JOIN subjects sub ON s.subject_id = sub.subject_id
    WHERE b.student_id = $student_id
    ORDER BY b.created_at DESC
");

// Fetch reviews already submitted
$reviewed_bookings = [];
$review_res = mysqli_query($conn, "SELECT booking_id FROM reviews WHERE student_id=$student_id");
while($r = mysqli_fetch_assoc($review_res)){
    $reviewed_bookings[] = $r['booking_id'];
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Student Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
<div class="max-w-6xl mx-auto">
<h1 class="text-3xl font-bold mb-6">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></h1>

<h2 class="text-2xl font-semibold mb-4">My Bookings</h2>

<div class="grid gap-4">
<?php while($row = mysqli_fetch_assoc($bookings_res)): ?>
<div class="bg-white rounded-xl shadow p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center">
    <div class="mb-3 sm:mb-0">
        <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($row['tutor_name']); ?></h3>
        <p class="text-gray-600"><?php echo htmlspecialchars($row['subject_name']); ?></p>
        <p class="text-gray-500"><?php echo $row['day_of_week'] . ' ' . substr($row['start_time'],0,5) . '-' . substr($row['end_time'],0,5); ?></p>
    </div>
    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
        <span class="px-3 py-1 rounded-full <?php
            echo $row['status']=='completed' ? 'bg-green-100 text-green-700' :
                 ($row['status']=='pending' ? 'bg-yellow-100 text-yellow-700' :
                 ($row['status']=='approved' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600'));
        ?>">
            <?php echo ucfirst($row['status']); ?>
        </span>
        <?php if($row['status']==='completed' && !in_array($row['booking_id'],$reviewed_bookings)): ?>
            <form method="POST" action="review_add.php" id="booking-<?php echo $row['booking_id']; ?>" class="inline">
                <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>"/>
                <input type="hidden" name="tutor_id" value="<?php echo $row['tutor_id']; ?>"/>
                <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition">Add Review</button>
            </form>
        <?php elseif(in_array($row['booking_id'],$reviewed_bookings)): ?>
            <span class="text-gray-500">Reviewed</span>
        <?php else: ?>
            <span class="text-gray-400">N/A</span>
        <?php endif; ?>
    </div>
</div>
<?php endwhile; ?>
</div>

<div class="mt-6 flex flex-wrap gap-3">
    <a href="reviews.php" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">My Reviews</a>
    <a href="logout.php" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">Logout</a>
</div>
</div>
</body>
</html>
