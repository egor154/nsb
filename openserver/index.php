<?php
session_start();
if (isset($_SESSION['user'])) {
    // проверяем роль пользователя
    if ($_SESSION['user']['role'] == 'Оператор') {
        // редирект на страницу для оператора
        header('Location: mainpageoper.php');
        exit();
    } elseif ($_SESSION['user']['role'] == 'Пользователь') {
        // редирект на страницу для  пользователя
        header('Location: mainpagepolz.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="android-chrome-512x512.png">
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#ffffff">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
</head>

<body style="background-image: url(6.jpg)">
    <style>
        input[type="submit"] {
            height: 80px;
            width: 320px;
            font-size: xx-large;
        }
    </style>
    <div class="zagolovok">
        <h1>Научно-справочная библиотека</h1>
    </div>
    <br>
    <div style="display:flex; flex-direction: row; justify-content: center; align-items: center">
        <form action="auth.php">
            <input type="submit" value="Вход">
        </form>
    </div>
    <br>
    <br>
    <div style="display:flex; flex-direction: row; justify-content: center; align-items: center">
        <form action="registration.php">
            <input type="submit" value="Регистрация">
        </form>
    </div>
</body>

</html>