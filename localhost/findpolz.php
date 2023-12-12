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
            background-size: 100%;
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
            color: black;
            font-size: x-large;
            text-shadow: 0px 0 0px #000,
                0 0px 0px #000,
                0px 0 0px #000,
                0 0px 0px #000;
            font-weight: 100;
        }
    </style>
    <div class="wrapper">
        <?php
        if (isset($_SESSION['user'])) {
            echo "<h3>" . $_SESSION['user']['login'], "," . $_SESSION['user']['role'] . ".</h3>";
        }
        ?>
        <form name="search" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div style="display:flex; flex-wrap: wrap; justify-content: center; align-items: center;">
                <div class="label">
                    <div class="info">
                        <input type="text" id="id" name="id" hidden>
                        <label>Название:</label>
                        <input type="text" name="search[title]" value="<?php echo isset($_GET['search']['title']) ? $_GET['search']['title'] : ''; ?>">
                    </div>
                </div>
                <div class="label">
                    <div class="info">
                        <label>Автор:</label>
                        <input type="text" name="search[author]" value="<?php echo isset($_GET['search']['author']) ? $_GET['search']['author'] : ''; ?>">
                    </div>
                </div>
                <div class="label">
                    <div class="info">
                        <label>Место издания:</label>
                        <input type="text" name="search[place]" value="<?php echo isset($_GET['search']['place']) ? $_GET['search']['place'] : ''; ?>">
                    </div>
                </div>
                <div class="label">
                    <div class="info">
                        <label>Год:</label>
                        <input type="text" name="search[year]" value="<?php echo isset($_GET['search']['year']) ? $_GET['search']['year'] : ''; ?>">
                    </div>
                </div>
                <div class="info">
                    <input type="submit" name="submit" value="Поиск" id="submit">
                </div>
        </form>
        <br>
        <div class="info">
            <form action="vendor/logout.php">
                <input type="submit" name="Logout" value="Выход">
            </form>
        </div>
    </div>
    <br>
    <?php
    $queryParams = "";
    function buildQueryParams()
    {
        $queryParams = "";
        if (!empty($_GET['search'])) {
            foreach ($_GET['search'] as $key => $value) {
                if (!empty($value)) {
                    $queryParams .= "&search[$key]=" . urlencode($value);
                }
            }
        }
        return $queryParams;
    }
    $queryCondition = "";
    if (!empty($_GET)) {
        if (isset($_GET["search"])) {
            foreach ($_GET["search"] as $key => $value) {
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
    }
    $queryParams = "";
    $sql = "SELECT 
        infprintedit.id, infprintedit.file, infprintedit.title, infprintedit.publicationtype, infprintedit.author, infprintedit.place, infprintedit.year, infprintedit.publisher, infprintedit.compedit, infprintedit.countpages, infprintedit.BBK, infprintedit.UDK, 
        additional_info1.archive AS archive1, 
        additional_info1.inventnumber as inventnumber1, 
        additional_info1.numbinstances as numbinstances1, 
        additional_info2.archive AS archive2, 
        additional_info2.inventnumber as inventnumber2, 
        additional_info2.numbinstances as numbinstances2 
        FROM infprintedit 
        LEFT JOIN additional_info as additional_info1 ON infprintedit.id = additional_info1.infprintedit_id 
        AND 
        additional_info1.id = (SELECT MIN(id) FROM additional_info WHERE infprintedit_id = infprintedit.id AND archive = 'ГКУ \"ЦГА УР\"') 
        LEFT JOIN additional_info as additional_info2 ON infprintedit.id = additional_info2.infprintedit_id AND 
        additional_info2.id = (SELECT MAX(id) FROM additional_info WHERE infprintedit_id = infprintedit.id AND archive = 'Филиал ГКУ ЦГА УР \"ГАОПИ\"') " . $queryCondition . $queryParams;
    // Определение параметров пагинации
    $resultsPerPage = 20; // Количество результатов на странице
    $totalResults = mysqli_num_rows(mysqli_query($connect, $sql)); // Общее количество результатов
    $totalPages = ceil($totalResults / $resultsPerPage); // Общее количество страниц

    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $startFrom = ($currentPage - 1) * $resultsPerPage;
    $sql .= " LIMIT $startFrom, $resultsPerPage";
    $result = mysqli_query($connect, $sql);
    $res = mysqli_fetch_all($result, MYSQLI_ASSOC);

    echo "<p>Найдено результатов: $totalResults</p>"; // Вывод количества найденных результатов
    echo "<table style='width: 100%;'>
    <tr>
    <th>Обложка</th>
    <th>Название</th>
    <th>Тип издания</th>
    <th>Авторы и составители</th>
    <th>Год</th>
    <th>Место издания</th>
    <th>Издательство</th>
    <th>Под редакцией</th>
    <th>Количество страниц</th>
    <th>ББК</th>
    <th>УДК</th>        
    <th>Архив</th>
    <th>Инвентарные номера</th>
    <th>Количество экземпляров</th>
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
            <td style="position: relative;">
                <?php echo $row["title"] ?>
            </td>
            <td style="position: relative;">
                <?php echo $row["publicationtype"] ?>
            </td>
            <td style="position: relative;">
                <?php echo $row["author"] ?>
            </td>
            <td style="position: relative;">
                <?php echo $row["year"] ?>
            </td>
            <td style="position: relative;">
                <?php echo $row["place"] ?>
            </td>
            <td style="position: relative;">
                <?php echo $row["publisher"] ?>
            </td>
            <td style="position: relative;">
                <?php echo $row["compedit"] ?>
            </td>
            <td style="position: relative;">
                <?php echo $row["countpages"] ?>
            </td>
            <td style="position: relative;">
                <?php echo $row["BBK"] ?>
            </td>
            <td style="position: relative;">
                <?php echo $row["UDK"] ?>
            </td>
            <td style="position: relative; width: 300px; text-align: center;">
                <div style="position: absolute; top: 0; left: 0; right: 0; margin-top: 40px;">
                    <?php echo $row["archive1"]; ?>
                </div>
                <hr style="position: absolute; width: 95%; top: 42%; transform: translateY(-50%); border: none; border-top: 1px solid black;">
                <div style="position: absolute; left: 0; right: 0; margin-top: 13%;">
                    <?php echo $row["archive2"]; ?>
                </div>
            </td>
            <td style="position: relative; white-space: nowrap; max-width: 100px;">
                <div style="overflow-x: scroll; width: 95%; position: absolute; top: 0;margin-top: 20px; transform: rotateX(180deg);">
                    <div style="transform: rotateX(180deg);">
                        <?php echo $row["inventnumber1"]; ?>
                    </div>
                </div>
                <hr style="position: absolute; width: 90%; top: 42%; transform: translateY(-50%); border:none; border-top: 1px solid black;">
                <div style="overflow-x: scroll; width: 95%; position: absolute; bottom: 0; margin-bottom: 25px">
                    <?php echo $row["inventnumber2"]; ?>
                </div>
            </td>
            <td style="position: relative; max-width: 100px; text-align: center;">
                <div style="position: absolute; top: 0; left: 0; right: 0; margin-top: 40px;">
                    <?php echo $row["numbinstances1"]; ?>
                </div>
                <hr style="position: absolute; width: 95%; top: 42%; transform: translateY(-50%); border: none; border-top: 1px solid black;">
                <div style="position: absolute; bottom: 0; left: 0; right: 0; margin-bottom: 35%;">
                    <?php echo $row["numbinstances2"]; ?>
                </div>
            </td>
        </tr>
    <?php
    }
    echo "</table>";
    ?>
    <div class="pagination">
        <?php
        $maxVisiblePages = 5; // Максимальное количество отображаемых кнопок
        $halfMaxVisiblePages = floor($maxVisiblePages / 2);

        if ($totalPages > 1) {
            if ($currentPage > 1) {
                echo "<a href='?page=" . ($currentPage - 1) . buildQueryParams() . "' class='page-link'>Предыдущая</a>";
            }

            // Определение диапазона отображаемых страниц
            $startPage = max($currentPage - $halfMaxVisiblePages, 1);
            $endPage = min($currentPage + $halfMaxVisiblePages, $totalPages);

            // Добавление кнопок пагинации
            if ($startPage > 1) {
                echo "<a href='?page=1" . buildQueryParams() . "' class='page-link'>«</a>";
            }

            // Добавление символа <
            if ($currentPage > 2) {
                echo "<a href='?page=" . ($currentPage - 1) . buildQueryParams() . "' class='page-link'><</a>";
            }

            for ($i = $startPage; $i <= $endPage; $i++) {
                if ($i == $currentPage) {
                    echo "<a href='?page=$i" . buildQueryParams() . "' class='page-link active'>$i</a>";
                } else {
                    echo "<a href='?page=$i" . buildQueryParams() . "' class='page-link'>$i</a>";
                }
            }

            // Добавление символа >
            if ($currentPage < $totalPages - 1) {
                echo "<a href='?page=" . ($currentPage + 1) . buildQueryParams() . "' class='page-link'>></a>";
            }

            // Добавление многоточия, если есть дополнительные страницы в конце
            if ($endPage < $totalPages) {
                echo "<span class='page-ellipsis'>...</span>";
            }

            // Добавление символа » и кнопки "Следующая"
            echo "<a href='?page=$totalPages" . buildQueryParams() . "' class='page-link'>»</a>";
            if ($currentPage < $totalPages) {
                echo "<a href='?page=" . ($currentPage + 1) . buildQueryParams() . "' class='page-link'>Следующая</a>";
            }
        }
        ?>
    </div>
</body>

</html>