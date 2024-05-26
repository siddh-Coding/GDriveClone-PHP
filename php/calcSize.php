<?php
include 'db.php';
$uid = $_COOKIE['user_id'];

// Calculate total size of files uploaded by the user
$sql = "SELECT SUM(file_size) as total_size FROM files WHERE user_id = $uid";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_size = $row['total_size'] ?? 0;
} else {
    $total_size = 0;
}

// Maximum storage limit
$max_size = 500000000; // 500 MB in bytes

// Calculate percentage of storage used
$used_percentage = ($total_size / $max_size) * 100;

$conn->close();