<?php
require_once 'connect.php';
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['archive'])) {
    $id = $_POST['id'];
    $infprintedit_id = $id;
    $archive = $_POST['archive'];
    $query = "SELECT infprintedit_id, user_id, inventnumber, numbinstances, familiya, imya, otchestvo 
    FROM additional_info AS ai 
    JOIN users AS u ON ai.user_id = u.id 
    WHERE ai.archive = '$archive' AND ai.infprintedit_id = '$infprintedit_id'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $inventnumber = $row['inventnumber'];
        $numbinstances = $row['numbinstances'];
        $familiya = $row['familiya'];
        $imya = $row['imya'];
        $otchestvo = $row['otchestvo'];
        $response = array(
            'inventnumber' => $inventnumber,
            'numbinstances' => $numbinstances,
            'familiya' => $familiya,
            'imya' => $imya,
            'otchestvo' => $otchestvo
        );
        echo json_encode($response);
    } else {
        $response = array(
            'inventnumber' => $inventnumber,
            'numbinstances' => $numbinstances,
            'familiya' => $familiya,
            'imya' => $imya,
            'otchestvo' => $otchestvo
        );
        echo json_encode($response);
    }
    mysqli_close($connect);
}
?>