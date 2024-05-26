<?php
include 'db.php';
$show = null;
$uid = $_COOKIE['user_id'];
if (isset($_GET['list'])) {
    $list = $_GET['list'];
    switch ($list) {
        case 'myfiles':
            $sql = "SELECT file_name, upload_date, file_path, file_id, user_id FROM files WHERE user_id = $uid";
            break;
        case 'shared':
            $sql = "SELECT f.file_name, f.upload_date, f.file_path, f.file_id, f.user_id FROM files f INNER JOIN permissions p ON f.file_id = p.file_id WHERE p.user_id = $uid";
            break;
        case 'recent':
            $sql = "SELECT file_name, upload_date, file_path, file_id, user_id FROM files WHERE user_id = $uid ORDER BY upload_date DESC";
        default:
            $sql = "SELECT file_name, upload_date, file_path, file_id, user_id FROM files WHERE user_id = $uid";
            $show = true;
    }
} else {
    $show = true;
    $sql = "SELECT file_name, upload_date, file_path, file_id, user_id FROM files WHERE user_id = $uid";
}
$result = $conn->query($sql);

$sql2 = "SELECT file_id from permissions where user_id = $uid";
$result2 = $conn->query($sql2);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><a href='preview.php?file_path=" . urlencode($row["file_path"]) . "&uid=" . urlencode($row["user_id"]) . "'>" . $row["file_name"] . "</a></td>"; //$row["file_name"]
        echo "<td>" . $row["upload_date"] . "</td>";
        echo "<td><a href='share.php?fid=" . urlencode($row["file_id"]) . "'><img src='../assets/share.svg' style='width:25px;margin-left:10px;'></a></td>";
        echo "<td><a href='download.php?file_path=" . urlencode($row["file_path"]) . "'><img src='../assets/download.svg' style='width:25px;margin-left:25px;'></a></td>";
        echo "<td><a href='delete.php?file_id=" . urlencode($row["file_id"]) . "'><img src='../assets/delete.svg' style='width:25px;margin-left:15px;'></a></td>";
        echo "</tr>";

    }
} else {
    echo "<style> .files{display:block;} .showFiles{display:none;} </style>";
}

if ($result2->num_rows > 0) {
    if ($show == true) {
        while ($row = $result2->fetch_assoc()) {
            $id = $row['file_id'];
            $q = "SELECT file_name, upload_date, file_path,file_id,user_id FROM files WHERE file_id=$id";
            $result3 = $conn->query($q);
            while ($data = $result3->fetch_assoc()) {
                echo "<tr>";
                echo "<td><a href='preview.php?file_path=" . urlencode($data["file_path"]) . "&uid=" . urlencode($data["user_id"]) . "'>" . $data["file_name"] . "</a></td>"; //$row["file_name"]
                echo "<td>" . $data["upload_date"] . "</td>";
                // echo "<td><i class='fa fa-share'></i></td>";
                echo "<td><a href='share.php?fid=" . urlencode($data["file_id"]) . "'><img src='share.svg' style='width:25px;margin-left:10px;'></a></td>";
                echo "<td><a href='download.php?file_path=" . urlencode($data["file_path"]) . "'><img src='download.svg' style='width:25px;margin-left:25px;'></a></td>";
                echo "<td><a href='delete.php?file_id=" . urlencode($row["file_id"]) . "'><img src='delete.svg' style='width:25px;margin-left:15px;'></a></td>";
                echo "</tr>";
            }
        }
    }

}

$conn->close();
