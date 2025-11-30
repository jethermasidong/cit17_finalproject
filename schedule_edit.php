<?php
session_start();
include "config.php";
if(!isset($_SESSION['user_id']) || $_SESSION['role']!=='admin') header("Location: login.php");

$id = $_GET['id'] ?? 0;
$res = mysqli_query($conn,"SELECT * FROM tutor_schedules WHERE schedule_id=".$id);
$schedule = mysqli_fetch_assoc($res);
if(!$schedule) { header("Location: schedules.php"); exit(); }

$error="";
$tutors = mysqli_query($conn,"SELECT * FROM users WHERE role='tutor'");
$subjects = mysqli_query($conn,"SELECT * FROM subjects");

if($_SERVER['REQUEST_METHOD']==='POST'){
    $tutor_id=$_POST['tutor_id'];
    $subject_id=$_POST['subject_id'];
    $day=$_POST['day_of_week'];
    $start=$_POST['start_time'];
    $end=$_POST['end_time'];
    $status=$_POST['status'];

    $stmt=mysqli_prepare($conn,"UPDATE tutor_schedules SET tutor_id=?,subject_id=?,day_of_week=?,start_time=?,end_time=?,status=? WHERE schedule_id=?");
    mysqli_stmt_bind_param($stmt,"iissssi",$tutor_id,$subject_id,$day,$start,$end,$status,$id);
    if(mysqli_stmt_execute($stmt)) header("Location: schedules.php");
    else $error="Error updating schedule.";
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Edit Schedule</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-6">

<div class="w-full max-w-lg bg-white rounded-2xl shadow-lg p-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-900 text-center">Edit Schedule</h1>

    <?php if($error): ?>
    <div class="bg-red-100 text-red-700 p-4 rounded mb-4"><?php echo $error;?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-5">

        <select name="tutor_id" required class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            <option value="">Select Tutor</option>
            <?php while($row=mysqli_fetch_assoc($tutors)): ?>
            <option value="<?php echo $row['user_id'];?>" <?php if($row['user_id']==$schedule['tutor_id']) echo 'selected';?>><?php echo htmlspecialchars($row['name']);?></option>
            <?php endwhile;?>
        </select>

        <select name="subject_id" required class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            <option value="">Select Subject</option>
            <?php while($row=mysqli_fetch_assoc($subjects)): ?>
            <option value="<?php echo $row['subject_id'];?>" <?php if($row['subject_id']==$schedule['subject_id']) echo 'selected';?>><?php echo htmlspecialchars($row['subject_name']);?></option>
            <?php endwhile;?>
        </select>

        <select name="day_of_week" required class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            <option <?php if($schedule['day_of_week']=='Monday') echo 'selected';?>>Monday</option>
            <option <?php if($schedule['day_of_week']=='Tuesday') echo 'selected';?>>Tuesday</option>
            <option <?php if($schedule['day_of_week']=='Wednesday') echo 'selected';?>>Wednesday</option>
            <option <?php if($schedule['day_of_week']=='Thursday') echo 'selected';?>>Thursday</option>
            <option <?php if($schedule['day_of_week']=='Friday') echo 'selected';?>>Friday</option>
            <option <?php if($schedule['day_of_week']=='Saturday') echo 'selected';?>>Saturday</option>
            <option <?php if($schedule['day_of_week']=='Sunday') echo 'selected';?>>Sunday</option>
        </select>

        <input type="time" name="start_time" value="<?php echo $schedule['start_time'];?>" required 
               class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none"/>

        <input type="time" name="end_time" value="<?php echo $schedule['end_time'];?>" required 
               class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none"/>

        <select name="status" class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            <option value="available" <?php if($schedule['status']=='available') echo 'selected';?>>Available</option>
            <option value="booked" <?php if($schedule['status']=='booked') echo 'selected';?>>Booked</option>
        </select>

        <button class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition">Update Schedule</button>
        <a href="schedules.php" class="block text-center mt-3 text-gray-600 hover:underline">Back</a>

    </form>
</div>

</body>
</html>
