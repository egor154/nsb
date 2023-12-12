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
$BBK = mysqli_real_escape_string($connect, $_POST['BBK']);
$UDK = mysqli_real_escape_string($connect, $_POST['UDK']);
$archive = mysqli_real_escape_string($connect, $_POST['archive']);
$inventnumber = mysqli_real_escape_string($connect, $_POST['inventnumber']);
$numbinstances = mysqli_real_escape_string($connect, $_POST['numbinstances']);
$currentDateTime = new DateTime(); // Создание объекта DateTime с текущей датой и временем
$currentTime = $currentDateTime->format('Y-m-d H:i:s'); // Форматирование времени в нужный вам формат
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
   $check_existing_query = "SELECT * FROM additional_info WHERE archive = '$archive' AND infprintedit_id = (SELECT id FROM infprintedit WHERE archive = '$archive')";
   $existing_result = mysqli_query($connect, $check_existing_query);
   $sql = "INSERT INTO infprintedit (file, title, publicationtype, author, year, publisher, compedit, place, countpages, BBK, UDK) VALUES ('$image_name', '$title', '$publicationtype', '$author', '$year', '$publisher', '$compedit', '$place', '$countpages', '$BBK', '$UDK')";
   $result = mysqli_query($connect, $sql);
   $infprintedit_id = mysqli_insert_id($connect);
   if (mysqli_num_rows($existing_result) > 0) {
      $update_query = "UPDATE additional_info SET archive = '$archive', inventnumber = '$inventnumber', numbinstances = '$numbinstances', user_id = '$user_id' WHERE infprintedit_id IN (SELECT id FROM infprintedit WHERE archive = '$archive') AND (archive = 'Архив ГКУ \"ЦГА УР\"' OR archive = 'Филиал ГКУ \"ЦГА УР\"') AND archive = '$archive'";
      $update_result = mysqli_query($connect, $update_query);
      if (!$update_result) {
         echo "Error updating additional_info table: " . mysqli_error($connect);
         exit();
      }
   } else {
      $insert_query = "INSERT INTO additional_info (infprintedit_id, archive, inventnumber, numbinstances, user_id ,datetime) VALUES ('$infprintedit_id', '$archive', '$inventnumber', '$numbinstances', '$user_id', '$currentTime')";
      $insert_result = mysqli_query($connect, $insert_query);
      if (!$insert_result) {
         echo "Error inserting data into additional_info table: " . mysqli_error($connect);
         exit();
      }
   }
} else {
   if (empty($image_name)) {
      $old_file_query = mysqli_query($connect, "SELECT file FROM infprintedit WHERE id = '$id'");
      $image_name = mysqli_fetch_assoc($old_file_query)['file'];
   }
   $sql = "UPDATE infprintedit SET file = '$image_name', title = '$title', publicationtype = '$publicationtype', author = '$author', year = '$year', place = '$place', publisher = '$publisher', compedit = '$compedit', countpages = '$countpages', BBK= '$BBK', UDK = '$UDK' WHERE id = '$id'";
   $result = mysqli_query($connect, $sql);
   $check_existing_query = "SELECT * FROM additional_info WHERE archive = '$archive' AND infprintedit_id = '$id'";
   $existing_result = mysqli_query($connect, $check_existing_query);
   if (mysqli_num_rows($existing_result) > 0) {
      $update_query = "UPDATE additional_info SET archive = '$archive', inventnumber = '$inventnumber', numbinstances = '$numbinstances', user_id = '$user_id'  WHERE infprintedit_id = '$id' AND archive = '$archive'";
      $update_result = mysqli_query($connect, $update_query);
      if (!$update_result) {
         echo "Error updating additional_info table: " . mysqli_error($connect);
         exit();
      }
   } else {
      $insert_query = "INSERT INTO additional_info (infprintedit_id, archive, inventnumber, numbinstances, user_id, datetime) VALUES ('$id', '$archive', '$inventnumber', '$numbinstances', '$user_id','$currentTime')";
      $insert_result = mysqli_query($connect, $insert_query);
/*      if (!$insert_result) {
         echo "Error inserting data into additional_info table: " . mysqli_error($connect);
         exit();
      }
*/
   }
}
if (!$result) {
   echo "Error: " . mysqli_error($connect);
   exit();
}
mysqli_close($connect); // Закрываем соединение с базой данных
header('Location: ../entry.php');
