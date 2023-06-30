<?php
session_start();
require_once 'connect.php';
function uploadFile($file, $old_file)
{
    $extensions = ['jpg', 'jpeg', 'png'];
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $file_name = uniqid('', true) . '.' . $file_ext;
    $file_path = '../uploads/' . $file_name;
    if (!empty($old_file)) {
        $old_file_path = '../uploads/' . $old_file;
        if (file_exists($old_file_path)) {
            unlink($old_file_path);
        }
    }
    // загрузка нового файла
    if (in_array($file_ext, $extensions) && $file['error'] === UPLOAD_ERR_OK && is_uploaded_file($file['tmp_name'])) {
        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            return $file_name;
        } else {
            echo "Failed to move uploaded file.";
            exit;
        }
    } else {
        return $old_file;
    }
}
$id = mysqli_real_escape_string($connect, $_POST['id']);
$title = mysqli_real_escape_string($connect, $_POST['title']);
$publicationtype = mysqli_real_escape_string($connect, $_POST['publicationtype']);
$author = mysqli_real_escape_string($connect, $_POST['author']);
$place = mysqli_real_escape_string($connect, $_POST['place']);
$year = mysqli_real_escape_string($connect, $_POST['year']);
$publisher = mysqli_real_escape_string($connect, $_POST['publisher']);
$compedit = mysqli_real_escape_string($connect, $_POST['compedit']);
$countpages = mysqli_real_escape_string($connect, $_POST['countpages']);
$archive = mysqli_real_escape_string($connect, $_POST['archive']);
$BBK = mysqli_real_escape_string($connect, $_POST['BBK']);
$inventnumber = mysqli_real_escape_string($connect, $_POST['inventnumber']);
$numbinstances = mysqli_real_escape_string($connect, $_POST['numbinstances']);
$lasttaker = mysqli_real_escape_string($connect, $_POST['lasttaker']);
$sql = "SELECT file FROM infprintedit WHERE id='$id'";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);
$old_file = $row['file'];
$new_file_name = '';
if (!empty($_FILES['image']['name'])) {
    $new_file_name = uploadFile($_FILES['image'], $old_file);
}
$user = $_SESSION['user'];
$user_id = $user['id'];
$user_id = (int)$user_id;
$id = $_POST['id'];
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    echo "Ошибка";
}
$sql = "UPDATE infprintedit SET
title='$title',
publicationtype = '$publicationtype',
author='$author',
year='$year',
place='$place',
publisher='$publisher',
compedit='$compedit',
countpages='$countpages',
archive='$archive',
BBK='$BBK',
inventnumber='$inventnumber',
numbinstances='$numbinstances',
lasttaker='$lasttaker',
user_id='$user_id',";
$sql .= "publicationtype='$publicationtype'";
if (!empty($new_file_name)) {
    $sql .= ", file='$new_file_name'";
}
$sql .= " WHERE id='$id'";

if (mysqli_query($connect, $sql)) {
    echo 'Record updated successfully!';
    header('Location: ../findoper.php');
} else {
    echo 'Error updating record: ' . mysqli_error($connect);
}
