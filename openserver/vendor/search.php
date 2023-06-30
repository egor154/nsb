<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])) {
   require_once 'connect.php';
   $search = $_POST['search'];
   $limit = 25;
   $query = "SELECT infprintedit.*, users.familiya, users.imya, users.otchestvo FROM infprintedit JOIN users ON infprintedit.user_id = users.id WHERE infprintedit.title LIKE '%$search%' LIMIT $limit";
   $result = mysqli_query($connect, $query);
   if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
         $id = $row['id'];
         $title = $row['title'];
         $file = $row['file'];
         $id = $row['id'];
         $author = $row['author'];
         $publicationtype = $row['publicationtype'];
         $place = $row['place'];
         $year = $row['year'];
         $publisher = $row['publisher'];
         $compedit = $row['compedit'];
         $countpages = $row['countpages'];
         $archive = $row['archive'];
         $BBK = $row['BBK'];
         $inventnumber = $row['inventnumber'];
         $numbinstances = $row['numbinstances'];
         $lasttaker = $row['lasttaker'];
         $user_id = $row['user_id'];
         echo "<div class='title_item' 
         data-file='$file'
         data-author='$author' 
         data-id='$id' 
         data-publicationtype='$publicationtype' 
         data-place='$place' 
         data-year='$year' 
         data-publisher='$publisher' 
         data-compedit='$compedit' 
         data-countpages='$countpages' 
         data-archive='$archive'  
         data-BBK='$BBK' 
         data-inventnumber='$inventnumber'
         data-numbinstances='$numbinstances' 
         data-lasttaker='$lasttaker'
         data-user='$user_id'><span class='title'>$title</span></div>";
      }
   }
   mysqli_close($connect);
}
?>