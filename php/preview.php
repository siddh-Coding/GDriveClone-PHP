<html>

<head>
    <link rel="stylesheet" href="../css/preview.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <div class="top-right"><a href="home.php?list=home"><i class="fa fa-arrow-left"></i></a>
    </div>

    <div class="preview">
        <?php
        if (isset($_GET['file_path'])) {
            $file_path = $_GET['file_path'];
            $filename = basename($file_path);
            if (isset($_GET['uid'])) {
                $id = $_GET['uid'];
                $path = "../uploads/" . $id . "/" . $filename;
            }
            $path2 = "../uploads/" . $_COOKIE['user_id'] . "/" . $filename;

            if (!isset($path))
                $path = $path2;

            if (file_exists($path)) {

                // Check if the file is an image
                $image_extensions = array("jpg", "jpeg", "png", "gif");
                $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                if (in_array($extension, $image_extensions)) {
                    // Display image
                    echo "<img src='$path' alt='Image Preview'>";
                } else {
                    // Display text content
                    echo "<pre>";
                    echo file_get_contents($path);
                    echo "</pre>";
                }
            } else {
                echo "File not found.";
            }
        } else {
            echo "Invalid file path.";
        }
        ?>
    </div>

</body>

</html>