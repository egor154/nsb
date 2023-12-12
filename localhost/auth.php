<?php
session_start();
if (isset($_SESSION['user'])) {
    // проверяем роль пользователя
    if ($_SESSION['user']['role'] == 'Оператор') {
        // редирект на страницу для оператора
        header('Location: mainpageoper.php');
        exit();
    } elseif ($_SESSION['user']['role'] == 'Пользователь') {
        // редирект на страницу для обычного пользователя
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Научно-справочная библиотека</title>
</head>

<body style="background-image: url(6.jpg)">
    <style>
        a {
            color: white;
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
            width: 290px;
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
        <h1>Вход</h1>
    </div>
    <div class="auth" style="text-align: center;padding-bottom: 120px;">
        <form action="vendor/signin.php" method="POST">
            <div class="label">
                <label>Логин</label>
                <br>
                <input type="text" name="login" required>
            </div>
            <div class="label">
                <label>Пароль</label>
                <br>
                <input type="password" name="pass" required>
            </div>
            <br>
            <input type="submit" value="Вход" style="font-size: large;">
            <?php
            if (isset($_SESSION["success"])) {
                echo "<p style='color: green'>" . $_SESSION["success"] . "</p>";
                unset($_SESSION["success"]);
            }
            if (isset($_SESSION["error"])) {
                echo "<p style='color: red'>" . $_SESSION["error"] . "</p>";
                unset($_SESSION["error"]);
            }
            ?>
            <p>
                Забыли пароль? - <a href="recoverypass.php"> изменить </a>
            </p>
            <p>
                У вас еще нет аккаунта? - <a href="registration.php"> зарегистрируйтесь </a>
            </p>

            <?php
            if ($_SESSION['msg']) {
                echo '<p class="msg"> ' . $_SESSION['msg'] . ' </p>';
                unset($_SESSION['msg']);
            }
            if ($_SESSION['message']) {
                echo '<p class="message"> ' . $_SESSION['message'] . ' </p>';
                unset($_SESSION['message']);
            }
            ?>
        </form>
    </div>

</body>

</html>