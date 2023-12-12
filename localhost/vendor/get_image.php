<?php
require_once 'connect.php';
$file = $_POST['file'];
$file_path = $_SERVER['DOCUMENT_ROOT'] . 'uploads/' . $file;
$query = "SELECT file FROM infprintedit WHERE file = '$file'";
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $data = base64_encode($row['data']);
    echo json_encode(['data' => $data]);
}
mysqli_close($connect);
