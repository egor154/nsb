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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="android-chrome-512x512.png">
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#ffffff">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
</head>

<script>
    // START CLOCK SCRIPT

    Number.prototype.pad = function (n) {
        for (var r = this.toString(); r.length < n; r = 0 + r);
        return r;
    };

    function updateClock() {
        var now = new Date();
        var sec = now.getSeconds(),
            min = now.getMinutes(),
            hou = now.getHours(),
            mo = now.getMonth(),
            dy = now.getDate(),
            yr = now.getFullYear();
        var months = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];
        var tags = ["mon", "d", "y", "h", "m", "s"],
            corr = [months[mo], dy, yr, hou.pad(2), min.pad(2), sec.pad(2)];
        for (var i = 0; i < tags.length; i++)
            document.getElementById(tags[i]).firstChild.nodeValue = corr[i];
    }

    function initClock() {
        updateClock();
        window.setInterval("updateClock()", 1);
    }

// END CLOCK SCRIPT
</script>

<body style="background-image: url(6.jpg)">
    <style>
        input[type="submit"] {
            height: 80px;
            width: 320px;
            font-size: xx-large;
        }

        #timedate {
            font: small-caps lighter 43px/150% "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
            text-align: left;
            width: 50%;
            margin: 40px auto;
            color: #fff;

            padding: 20px;
        }

        a {
            color: white;
            vertical-align: center;
            margin-top: 120px;
            font-size: 100px;
            text-shadow: 1px 0 1px #000,
                0 1px 1px #000,
                -1px 0 1px #000,
                0 -1px 1px #000;
        }
    </style>
    <div class="zagolovok">
        <h1>Научно-справочная библиотека</h1>
    </div>
    <br>
    <div style="display:flex; flex-direction:column; justify-content: center; align-items: center">
        <form action="auth.php">
            <input type="submit" value="Вход">
        </form>
        <br>
        <br>
        <form action="registration.php">
            <input type="submit" value="Регистрация">
        </form>
    </div>

    <body onLoad="initClock()">


        <div id="timedate" style="text-align: center">
            <a id="d">1</a>
            <a id="mon">January</a>

            <a id="y">0</a><br />
            <a id="h">12</a> :
            <a id="m">00</a> :
            <a id="s">00</a>
        </div>
    </body>

</html>