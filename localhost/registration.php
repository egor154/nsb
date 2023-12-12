<?php
session_start();
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
        a {
            color: #ffffff;
            font-weight: bold;
            text-decoration: none;
            text-shadow: 1px 0 1px rgb(0, 140, 255),
                0 1px 1px rgb(0, 140, 255),
                -1px 0 1px rgb(0, 140, 255),
                0 -1px 1px rgb(0, 140, 255);
        }

        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            height: 40px;
            width: 320px;
        }

        .label {
            font-size: 20px;
            color: white;
            font-weight: bold;
            text-shadow: 1px 0 1px #000,
                0 1px 1px #000,
                -1px 0 1px #000,
                0 -1px 1px #000;
        }
    </style>
    <div class="zagolovok">
        <h1>Регистрация</h1>
    </div>
    <form action="vendor/signup.php" method="POST">
        <div class="reg" style="text-align: center;">
            <div class="label">
                <label>Фамилия</label>
                <br>
                <input type="text" name="familiya" required>
            </div>
            <div class="label">
                <label>Имя</label>
                <br>
                <input type="text" name="imya" required>
            </div>
            <div class="label">
                <label>Отчество</label>
                <br>
                <input type="text" name="otchestvo" required>
            </div>
            <div class="label">
                <label>Логин</label>
                <br>
                <input type="text" name="login" required>
            </div>
            <div class="label">
                <label>Введите пароль</label>
                <br>
                <input type="password" name="pass" required>
            </div>
            <div class="label">
                <label>Повторите пароль</label>
                <br>
                <input type="password" name="passconfirm" required>
            </div>
            <br>
            <input type="submit" value="Регистрация" style="font-size: large; ">
            <p>
                У вас уже есть аккаунт? - <a href="auth.php"> авторизируйтесь</a>
            </p>
            <?php
            if ($_SESSION['msg']) {
                echo '<p class="msg"> ' . $_SESSION['message'] . ' </p>';
            }
            unset($_SESSION['msg']);
            ?>
            <?php
            if ($_SESSION['message']) {
                echo '<p class="message"> ' . $_SESSION['message'] . ' </p>';
            }
            unset($_SESSION['message']);
            ?>
        </div>
    </form>
</body>

</html>