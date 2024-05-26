<?php
session_start();
include 'db.php';

if (isset($_GET['fid'])) {
    $fid = $_GET['fid'];
    $uid = $_GET['uid'];

    // Remove the permission entry from the database
    $sql = "DELETE FROM permissions WHERE file_id = '$fid'";
    if (mysqli_query($conn, $sql)) {
        echo "Permission revoked successfully.";
    } else {
        echo "Error revoking permission: " . mysqli_error($conn);
    }

    header("Location: share.php?fid=$fid");
} else {
    echo "Invalid request.";
}
