<?php
session_start();
require_once 'connect.php';
$id = $_POST['id'];
$user = $_SESSION['user'];
$user_id = $user['id'];
$user_id = (int)$user_id;
$title = mysqli_real_escape_string($connect, $_POST['title']);
$publicationtype = mysqli_real_escape_string($connect, $_POST['publicationtype']);
$author = mysqli_real_escape_string($connect, $_POST['author']);
$publisher = mysqli_real_escape_string($connect, $_POST['publisher']);
$compedit = mysqli_real_escape_string($connect, $_POST['compedit']);
$place = mysqli_real_escape_string($connect, $_POST['place']);
$year = mysqli_real_escape_string($connect, $_POST['year']);
$countpages = mysqli_real_escape_string($connect, $_POST['countpages']);
$archive = mysqli_real_escape_string($connect, $_POST['archive']);
$BBK = mysqli_real_escape_string($connect, $_POST['BBK']);
$inventnumber = mysqli_real_escape_string($connect, $_POST['inventnumber']);
$numbinstances = mysqli_real_escape_string($connect, $_POST['numbinstances']);
$lasttaker = mysqli_real_escape_string($connect, $_POST['lasttaker']);

if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
   $file = $_FILES['file']['name'];
   $image_tmp = $_FILES['file']['tmp_name'];
   $image_size = $_FILES['file']['size'];
   $image_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
   if ($image_size > 2 * 1024 * 1024) {
      echo "Error: File is too large";
      exit();
   }
   if ($image_ext != "jpg" && $image_ext != "jpeg" && $image_ext != "png") {
      echo "Error: Only JPG, JPEG or PNG are allowed";
      exit();
   }
   $image_name = uniqid() . '.' . $image_ext;
   $upload_dir = '../uploads/';
   $target_file = $upload_dir . $image_name;

   // Remove old file if exists
   $old_file_query = mysqli_query($connect, "SELECT file FROM infprintedit WHERE id = '$id'");
   $old_file = mysqli_fetch_assoc($old_file_query)['file'];
   if (!empty($old_file)) {
      $old_file_path = '../uploads/' . $old_file;
      if (file_exists($old_file_path)) {
         unlink($old_file_path);
      }
   }

   move_uploaded_file($image_tmp, $target_file);
} else {
   // If no new file was uploaded, keep the previous one
   $image_name = '';
}

if ($id == NULL) {
   $sql = ("INSERT INTO infprintedit (file, title, publicationtype, author, year, publisher, compedit, place, countpages, archive, BBK, inventnumber, numbinstances, lasttaker, user_id)
      VALUES ('$image_name', '$title', '$publicationtype', '$author', '$year', '$publisher', '$compedit', '$place', '$countpages', '$archive', '$BBK', '$inventnumber', '$numbinstances', '$lasttaker', '$user_id')");
} else {
   if (empty($image_name)) {
      // Если новый файл не выбран, оставляем прежний файл
      $old_file_query = mysqli_query($connect, "SELECT file FROM infprintedit WHERE id = '$id'");
      $image_name = mysqli_fetch_assoc($old_file_query)['file'];
   }
   $sql = "UPDATE infprintedit SET
  file = '$image_name',
  title = '$title',
  publicationtype = '$publicationtype',
  author = '$author',
  year = '$year',
  place = '$place',
  publisher = '$publisher',
  compedit = '$compedit',
  countpages = '$countpages',
  archive = '$archive',
  BBK = '$BBK',
  inventnumber = '$inventnumber',
  numbinstances = '$numbinstances',
  lasttaker = '$lasttaker',
  user_id = '$user_id'
  WHERE id = '$id'";
   if (empty($image_name)) {
      // Remove the file name from the database record
      $sql = "UPDATE infprintedit SET file = NULL WHERE id = '$id'";
   }
}

$result = mysqli_query($connect, $sql);

if (!$result) {
   echo "Error: " . mysqli_error($connect);
   exit();
}

header('Location: ../entry.php');
