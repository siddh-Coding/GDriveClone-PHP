<?php
session_start();
if (!isset($_SESSION["fid"])) {
    $_SESSION['fid'] = $_GET['fid'];
}
?>
<!DOCTYPE html>

<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .share {
            box-sizing: border-box;
            width: 50%;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin: 40px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .share input[type="email"] {
            padding: 10px;
            width: 60%;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .share input[type="submit"] {
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .share input[type="submit"]:hover {
            background-color: #218838;
        }

        .shared {
            width: 80%;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin: 20px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .shared table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .shared table,
        .shared th,
        .shared td {
            border: 1px solid #ddd;
        }

        .shared th,
        .shared td {
            padding: 12px;
            text-align: left;
        }

        .shared th {
            background-color: #f8f8f8;
        }

        .shared tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .shared tr:hover {
            background-color: #f1f1f1;
        }

        .shared a {
            color: #007bff;
            text-decoration: none;
        }

        .shared a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="share">
        <form action="share.php" method="get">
            <input type="email" name="semail" placeholder="Enter Email address" required>
            <input type="submit" value="Share">
        </form>
        <?php
        include "db.php";
        $fid = $_SESSION['fid'];

        if (isset($_GET['semail'])) {
            $email = $_GET['semail'];
            $sql = "SELECT id from users WHERE email='$email'";
            $cmd = mysqli_query($conn, $sql);
            $result = mysqli_fetch_array($cmd);
            if (!isset($result['id'])) {
                echo '<h2>Email not Found In Database...</h2>';
                echo "<a href='home.php'>Go Back</a>";
            } else {
                $uid = $result['id'];
                $query = "INSERT INTO `permissions`(`file_id`, `user_id`, `can_view`, `can_download`) VALUES ('$fid','$uid',1,1)";
                $cmd = mysqli_query($conn, $query);
                if ($cmd) {
                    unset($_SESSION['fid'], $uid);
                    header("Location: home.php?list=home");
                }
            }
        }
        ?>
    </div>
    <div class="shared">
        <table border="1">
            <tr>
                <th>Email</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
            <?php
            include 'db.php';
            $fid = $_SESSION['fid'];
            $sql = "SELECT u.email, u.fname 
                    FROM users u 
                    INNER JOIN permissions p ON u.id = p.user_id 
                    WHERE p.file_id = '$fid'";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['fname']) . "</td>";
                    echo "<td><a href='unshare.php?fid=$fid'>Unshare</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No users have access to this file.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>