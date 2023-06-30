<?php
session_start();
require_once "vendor/connect.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <script src="scriptfind.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Научно-справочная библиотека</title>
</head>

<body>
    <style>
        td {
            font-size: medium;
        }

        th {
            font-size: medium;
        }

        .wrapper {
            position: relative;
            background-image: url('6.jpg');
            background-size: cover;
            background-position: center;
            height: 215px;
        }

        a {
            color: black;
            font-weight: bold;
            text-decoration: none;
        }

        /* Стили для контейнера с изображением */
        .img-container {
            position: relative;
        }

        .img-container img {
            object-fit: contain;
            cursor: pointer;
        }

        /* Стили для модального окна */
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
            z-index: 9999;
        }

        /* Стили для содержимого модального окна */
        .modal-content {
            width: auto;
            max-height: 100%;
            max-width: 100%;
        }

        /* Стили для крестика */
        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            background-color: transparent;
            color: #fff;
            border: none;
            cursor: pointer;
            z-index: 10000;
        }

        input[type="submit"] {
            height: 35px;
            width: 150px;
        }

        input[type="submit"] {
            height: 35px;
            width: 120px;
            color: black;
            font-size: large;
        }

        p {
            text-align: center;
            font-size: large;
        }
    </style>
<div class="wrapper">
        <?php
        if (isset($_SESSION['user'])) {
            echo "<h3>" . $_SESSION['user']['login'], "," . $_SESSION['user']['role'] . ".</h3>";
        }
        ?>
        <form name="search" method="POST" action="findoper.php">
            <div style="display:flex; flex-wrap: wrap; justify-content: center; align-items: center;">
                <div class="label">
                    <div class="info">
                        <input type="text" id="id" name="id" hidden>
                        <label>Название:</label>
                        <input type="text" name="search[title]">
                    </div>
                </div>
                <div class="label">
                    <div class="info">
                        <label>Тип издания:</label>
                        <select name="search[publicationtype]">
                            <option value="" <?php if (isset($search['publicationtype']) && $search['publicationtype'] == "") echo "selected"; ?>></option>
                            <option value="Однотомное издание" <?php if (isset($search['publicationtype']) && $search['publicationtype'] == "Однотомное издание") echo "selected"; ?>>Однотомное издание</option>
                            <option value="Многотомное издание" <?php if (isset($search['publicationtype']) && $search['publicationtype'] == "Многотомное издание") echo "selected"; ?>>Многотомное издание</option>
                            <option value="Собрание сочинений" <?php if (isset($search['publicationtype']) && $search['publicationtype'] == "Собрание сочинений") echo "selected"; ?>>Собрание сочинений</option>
                            <option value="Периодическое издание" <?php if (isset($search['publicationtype']) && $search['publicationtype'] == "Периодическое издание") echo "selected"; ?>>Периодическое издание</option>
                        </select>
                    </div>
                </div>
                <div class="label">
                    <div class="info">
                        <label>Автор:</label>
                        <input type="text" name="search[author]">
                    </div>
                </div>
                <div class="label">
                    <div class="info">
                        <label>Под редакцией:</label>
                        <input type="text" name="search[compedit]">
                    </div>
                </div>
                <div class="label">
                    <div class="info">
                        <label>Год:</label>
                        <input type="text" name="search[year]">
                    </div>
                </div>
                <div class="info">
                    <input type="submit" name="submit" value="Поиск">
                </div>
        </form>
        <div class="info">
            <form action="mainpageoper.php">
                <input type="submit" name="Back" value="Назад">
            </form>
        </div>
        <br>
        <div class="info">
            <form action="vendor/logout.php">
                <input type="submit" name="Logout" value="Выход">
            </form>
        </div>
    </div>
<br>
    <?php
    $queryCondition = "";
    if (!empty($_POST)) {
        $submitForm = $_POST["submit"];
        foreach ($_POST["search"] as $key => $value) {
            if (isset($value)) {
                if (empty($queryCondition)) {
                    $queryCondition = " WHERE ";
                } else {
                    $queryCondition .= " AND ";
                }
                if ($key == "publicationtype") {
                    $queryCondition .= "$key = '$value'";
                } else {
                    $queryCondition .= "$key LIKE '%" . $value . "%'";
                }
            }
        }
    }
    $sql = "SELECT id, file, title, publicationtype, author, place, year, publisher, compedit, countpages, archive, BBK, inventnumber, numbinstances, lasttaker FROM infprintedit " . $queryCondition;
    $result = mysqli_query($connect, $sql);
    $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $totalResults = mysqli_num_rows($result); // кол-во найденных результатов
    echo "<p>Найдено результатов: $totalResults</p>"; // вывод кол-ва найденных результатов
    echo "<table style='width: 100%;'>
        <tr>
        <th>Обложка</th>
        <th>Название</th>
        <th>Тип издания</th>
    <th>Авторы и составители</th>
    <th>Год</th><th>Место издания</th>
    <th>Издательство</th><th>Под редакцией</th>
    <th>Количество страниц</th><th>Архив</th>
    <th>ББК</th>
    <th>Инвентарный номер</th>
    <th>Количество экземпляров</th>
    <th>Кому выдано</th>
    </tr>";
    foreach ($res as $row) {
    ?>
        <tr>
            <td>
                <?php if (!empty($row['file'])) : ?>
                    <div class="img-container">
                        <img src="uploads/<?php echo $row['file']; ?>" onclick="openModal(this)" width="150px" height="200px">
                    </div>
                <?php else : ?>
                    &nbsp;
                <?php endif; ?>
            </td>
            <td>
                <?php echo $row["title"] ?>
            </td>
            <td>
                <?php echo $row["publicationtype"] ?>
            </td>
            <td>
                <?php echo $row["author"] ?>
            </td>
            <td>
                <?php echo $row["year"] ?>
            </td>
            <td>
                <?php echo $row["place"] ?>
            </td>
            <td>
                <?php echo $row["publisher"] ?>
            </td>
            <td>
                <?php echo $row["compedit"] ?>
            </td>
            <td>
                <?php echo $row["countpages"] ?>
            </td>
            <td>
                <?php echo $row["archive"] ?>
            </td>
            <td>
                <?php echo $row["BBK"] ?>
            </td>
            <td>
                <?php echo $row["inventnumber"] ?>
            </td>
            <td>
                <?php echo $row["numbinstances"] ?>
            </td>
            <td>
                <?php echo $row["lasttaker"] ?>
            </td>
        </tr>
    <?
    }
    echo "</table>";
    $result->free();
    ?>
</body>

</html>