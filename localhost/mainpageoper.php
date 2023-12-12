<?php
session_start();
if (!$_SESSION['user']) {
    header('Location: /');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Научно-справочная библиотека</title>
</head>

<body style="background-image: url(6.jpg)">
    <style>
        input[type="submit"] {
            height: 100px;
            width: 300px;
            font-size: xxx-large;
            color: black;
        }

        h3 {
            text-align: center;
            font-size: 60px;
            color: white;
        }
    </style>
    <div class="zagolovok1">
        <?php
        if (isset($_SESSION['user'])) {
            echo "<h3>Здравствуйте," . $_SESSION['user']['login'] . "! <br> Ваша роль " . $_SESSION['user']['role'] . ".</h3>";
        }
        ?>
    </div>
    <br>
    <br>
    <div style="display:flex; flex-direction: row; justify-content: center; align-items: center">
        <div class="info">
            <form action="entry.php">
                <input type="submit" name="SubmitForm" value="Заполнить">
            </form>
        </div>
        <br>
        <br>
        <div class="info">
            <form action="findoper.php">
                <input type="submit" name="SubmitForm" value="Поиск">
            </form>
        </div>
        <br>
        <br>
        <div class="info">
            <form action="vendor/logout.php">
                <input type="submit" name="SubmitForm" value="Выход">
            </form>
        </div>
    </div>
</body>

</html>