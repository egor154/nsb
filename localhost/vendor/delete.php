<?php
require_once 'connect.php';
$id = mysqli_real_escape_string($connect, $_REQUEST['id']);
if(isset($_GET['id'])) {
    $query = "SELECT file FROM infprintedit WHERE id = $id";
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result) == 0) {
        // Запись с заданным идентификатором не существует
        // Возможно, вы захотите вывести сообщение об ошибке или выполнить другие действия
        exit("Запись не найдена");  
    }

    $row = mysqli_fetch_assoc($result);
    $file = $row['file'];
    $filePath = "../uploads/$file";
    if(file_exists($filePath)){
        if(unlink($filePath)){
            // Файл успешно удален
            echo "Файл успешно удален";
        } else {
            // Не удалось удалить файл
            echo "Не удалось удалить файл";
        }
    }

    // Удаление записи из таблицы infprintedit
    $deleteQuery = "DELETE FROM infprintedit WHERE id = $id";
    if(mysqli_query($connect, $deleteQuery)){
        // Запись успешно удалена
        echo "Запись успешно удалена";
    } else {
        // Не удалось удалить запись
        echo "Не удалось удалить запись";
    }

    // Возврат на страницу с которой был переход
    echo '<script>window.history.back();</script>';
    exit();
}
?>