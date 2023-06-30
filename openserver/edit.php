<?php
session_start();
require_once "vendor/connect.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <script src="scriptedit.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Научно-справочная библиотека</title>
</head>

<body>
    <style>
        h3 {
            color: black;
        }

        label {
            font-size: x-large;
            color: black;
            display: inline-block;
            width: 400px;
            text-align: right;
            white-space: nowrap;
            text-shadow: 1px 0 1px white,
                0 1px 1px white,
                -1px 0 1px white,
                0 -1px 1px white;
        }

        #imageContainer {
            display: flex;
            flex-direction: column;
            align-items: center;
            border: none;
            outline: none;
        }

        #imagePreview {
            display: block;
            width: 200px;
            height: 300px;
            margin: 0;
            padding: 0;
            border: none;
            background: none;
            box-shadow: none;
            outline: none;
        }

        .modal-content {
            width: auto;
            max-height: 100%;
            max-width: 100%;
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .closeButton {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            background-color: transparent;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        input[type="text"] {
            width: 1000px;
            height: 30px;
        }

        input[type="submit"] {
            height: 40px;
            width: 120px;
            font-size: large;
        }

        p {
            font-size: large;
            text-align: center;
            color: black;
            text-shadow: 1px 0 1px white,
                0 1px 1px white,
                -1px 0 1px white,
                0 -1px 1px white;
        }
    </style>
    <?php
    if (isset($_SESSION['user'])) {
        echo "<h3>" . $_SESSION['user']['login'], "," . $_SESSION['user']['role'] . ".</h3>";
    }
    // Получаем значение параметра id из URL
    $id = $_GET['id'];
    // Выполняем запрос к БД для получения данных строки по ее id
    $query = "SELECT * FROM `infprintedit` WHERE id = $id";
    $result = mysqli_query($connect, $query);
    // Обрабатываем результат запроса
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    }
    ?>
    <form method="POST" action="/vendor/update.php" enctype="multipart/form-data" name="editform">
        <div style="display: flex; justify-content: center; flex-direction: column; align-items: center;">
            <div id="imageContainer">
                <a href="#" onclick="openModal(this)">
                    <img id="imagePreview" src="uploads/<?= empty($new_file_name) ? $row['file'] : $new_file_name ?>" width="200" height="300" margin="auto">
                </a>
            </div>
            <br>
            <div class="inputWrapper">
                <input type="file" id="fileInput" name="image" onchange="showImage(this)">
            </div>
            <br>
            <div class="label">
                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                <label>Название:</label>
                <td><input type="text" name="title" value="<?php echo $row['title'] ?>"></td>
            </div>
            <br>
            <div class="label">
                <label>Тип издания:</label>
                <select name="publicationtype">
                    <option value="" <?php if ($row['publicationtype'] == "") echo "selected"; ?>></option>
                    <option value="Однотомное издание" <?php if ($row['publicationtype'] == "Однотомное издание") echo "selected"; ?>>Однотомное издание</option>
                    <option value="Многотомное издание" <?php if ($row['publicationtype'] == "Многотомное издание") echo "selected"; ?>>Многотомное издание</option>
                    <option value="Собрание сочинений" <?php if ($row['publicationtype'] == "Собрание сочинений") echo "selected"; ?>>Собрание сочинений</option>
                    <option value="Периодическое издание" <?php if ($row['publicationtype'] == "Периодическое издание") echo "selected"; ?>>Периодическое издание</option>
                </select>
            </div>
            <br>
            <div class="label">
                <label>Авторы и составители:</label>
                <td><input type="text" name="author" value="<?php echo $row['author'] ?>"></td>
            </div>
            <br>
            <div class="label">
                <label>Под редакцией:</label>
                <td><input type="text" name="compedit" value="<?php echo $row['compedit'] ?>"></td>
            </div>
            <br>
            <div class="label">
                <label>Место:</label>
                <td><input type="text" name="place" value="<?php echo $row['place'] ?>"></td>
            </div>
            <br>
            <div class="label">
                <label>Год:</label>
                <td><input type="text" name="year" value="<?php echo $row['year'] ?>"></td>
            </div>
            <br>
            <div class="label">
                <label>Издательство:</label>
                <td><input type="text" name="publisher" value="<?php echo $row['publisher'] ?>"></td>
            </div>
            <br>
            <div class="label">
                <label>Количество страниц:</label>
                <td><input type="text" name="countpages" value="<?php echo $row['countpages'] ?>"></td>
            </div>
            <br>
            <div class="label">
                <label>Архив:</label>
                <td><input type="text" name="archive" value="<?php echo htmlspecialchars($row['archive'], ENT_QUOTES, 'UTF-8') ?>"></td>
            </div>
            <br>
            <div class="label">
                <label>ББК:</label>
                <td><input type="text" name="BBK" value="<?php echo $row['BBK'] ?>"></td>
            </div>
            <br>
            <div class="label">
                <label>Инвентарный №:</label>
                <td><input type="text" name="inventnumber" value="<?php echo $row['inventnumber'] ?>"></td>
            </div>
            <br>
            <div class="label">
                <label>Количество экземпляров:</label>
                <td><input type="text" name="numbinstances" value="<?php echo $row['numbinstances'] ?>"></td>
            </div>
            <br>
            <div class="label">
                <label>Кому выдано:</label>
                <td><input type="text" name="lasttaker" value="<?php echo $row['lasttaker'] ?>"></td>
            </div>
        </div>
        <br>
        <p>Последний изменивший: <?php
                                    // Выполняем запрос к БД для получения данных строки по ее id
                                    $query = "SELECT users.familiya , users.imya , users.otchestvo  FROM infprintedit INNER JOIN users ON infprintedit.user_id = users.id WHERE infprintedit.id = $id";
                                    $result = mysqli_query($connect, $query);
                                    // Обрабатываем результат запроса
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        $row = mysqli_fetch_assoc($result);
                                    }
                                    echo $row['familiya'] . " ";
                                    echo $row['imya'] . " ";
                                    echo $row['otchestvo'];
                                    ?>
        </p>
        <div style="display:flex; flex-direction: row; justify-content: center; align-items: center; vertical-align: center;margin-bottom: 50px; margin-top: 20px;">
            <div class="btn-group">
                <input type="submit" name="Save" value="Сохранить">
            </div>
    </form>
    <form action="findoper.php">
        <div class="btn-group">
            <input type="submit" name="Back" value="Назад">
        </div>
    </form>
</body>

</html>