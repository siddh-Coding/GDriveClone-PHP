<?php
$file_path = $_GET['file_path'];

// Check if the file exists
if (file_exists($file_path)) {
    // Set headers to force download
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
    header('Content-Length: ' . filesize($file_path));

    // Read the file and output its contents
    readfile($file_path);
    exit;
} else {
    // File not found, handle the error (e.g., show an error message)
    echo "File not found.";
    exit;
}
