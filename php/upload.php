<!-- File Uploading  -->
<?php
// session_start();
include 'db.php';
$uid = $_COOKIE['user_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if file was uploaded without errors
    if (isset($_FILES["newfile"]) && $_FILES["newfile"]["error"] == 0) {
        $target_dir = "../" . "/uploads/" . $uid . "/";
        $target_file = $target_dir . basename($_FILES["newfile"]["name"]);

        $uploadOk = 1;
        // $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;

        }

        // Check file size
        $fileSize = $_FILES["newfile"]["size"];
        if ($fileSize > 500000000) {//50MB
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }



        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["newfile"]["tmp_name"], $target_file)) {
                // File uploaded successfully, update the database
                $filename = basename($_FILES["newfile"]["name"]);
                $file_path = $target_file;
                $upload_date = date("Y-m-d H:i:s");
                // Insert a new record into the files table
                $sql = "INSERT INTO files (user_id, file_name, file_path, upload_date, file_size) VALUES ('$uid', '$filename', '$file_path', '$upload_date', '$fileSize')";
                if ($conn->query($sql) === TRUE) {
                    echo "The file " . $filename . " has been uploaded";
                } else {
                    echo "Error updating database: " . $conn->error;
                }


            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "No file uploaded";
    }
}
