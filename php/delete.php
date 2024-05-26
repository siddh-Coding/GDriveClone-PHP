<?php
include 'db.php';

session_start();
if (!isset($_COOKIE['user_id'])) {
    echo "User not logged in.";
    exit();
}
$uid = $_COOKIE['user_id'];

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["file_id"])) {
    $file_id = $_GET["file_id"];

    // Check if the file is shared with the user
    $sql_shared = "SELECT * FROM permissions WHERE file_id = $file_id AND user_id = $uid";
    $result_shared = $conn->query($sql_shared);

    if ($result_shared->num_rows > 0) {
        // If the file is shared with the user, delete the permission entry
        $sql_delete_permission = "DELETE FROM permissions WHERE file_id = $file_id AND user_id = $uid";
        if ($conn->query($sql_delete_permission) === TRUE) {
            $message = "Permission entry deleted successfully.";
        } else {
            $message = "Error deleting permission entry: " . $conn->error;
        }
    } else {
        // If the file is not shared with the user, delete the file from the server and its entry in the database
        $sql_select_path = "SELECT file_path FROM files WHERE file_id = $file_id AND user_id = $uid";
        $result_select_path = $conn->query($sql_select_path);
        if ($result_select_path->num_rows > 0) {
            $row = $result_select_path->fetch_assoc();
            $file_path = $row["file_path"];

            // Delete file from the server
            if (unlink($file_path)) {
                // Delete file entry from the database
                $sql_delete_file = "DELETE FROM files WHERE file_id = $file_id AND user_id = $uid";
                if ($conn->query($sql_delete_file) === TRUE) {
                    $message = "File deleted successfully.";
                } else {
                    $message = "Error deleting file: " . $conn->error;
                }
            } else {
                $message = "Error deleting file from the server.";
            }
        } else {
            $message = "File path not found.";
        }
    }
} else {
    $message = "Invalid request.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete File</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .container {
            margin-top: 50px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            width: 50%;
            margin: 50px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .message {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .back-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="message">
            <?php echo $message; ?>
        </div>
        <a href="home.php" class="back-button">Go Back</a>
    </div>
</body>

</html>