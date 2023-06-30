<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['user_id'])) {
    require_once 'connect.php';
    $user_id = $_POST['user_id'];
    $query = "SELECT familiya, imya, otchestvo FROM users WHERE id='$user_id'";
    $result = mysqli_query($connect, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    } else {
        echo json_encode([]);
    }
    mysqli_close($connect);
}
