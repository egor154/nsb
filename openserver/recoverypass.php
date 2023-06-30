<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <title>Научно-справочная библиотека</title>
</head>
<style>
    h1 {
        color: white;
        text-shadow: 1px 0 1px rgb(0, 0, 0),
            0 1px 1px rgb(0, 0, 0),
            -1px 0 1px rgb(0, 0, 0),
            0 -1px 1px rgb(0, 0, 0);
        margin: 0;
    }

    input[type="text"],
    input[type="password"],
    input[type="submit"] {
        height: 40px;
        width: 290px;
        font-size: large;
    }
</style>

<body style="background-image: url(6.jpg)">
    <div class="zagolovok">
        <h1>Восстановление пароля</h1>
    </div>
    <div class="auth" style="text-align: center">
        <?php
        if (isset($_SESSION["error"])) {
            echo "<p style='color: red'>" . $_SESSION["error"] . "</p>";
            unset($_SESSION["error"]);
        }
        ?>
        <form action="vendor/recovery.php" method="POST">
            <div class="label">
                <label>Логин</label>
                <br>
                <input type="text" name="login" required>
            </div>
            <br>
            <div class="label">
                <label>Пароль</label>
                <br>
                <input type="password" name="pass" required>
            </div>
            <br>
            <div class="label">
                <label>Подтвердите пароль</label>
                <br>
                <input type="password" name="passconfirm" required>
            </div>
            <br>
            <input type="submit" name="submit" value="Восстановить" style="font-size: large; height: 40px; width: 300px;">
        </form>
        <br>
        <form action="auth.php">
            <input type="submit" name="submit" value="Назад" style="font-size: large; height: 40px; width: 300px;">
        </form>
    </div>
</body>

</html>