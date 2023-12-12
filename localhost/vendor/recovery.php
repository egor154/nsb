<?php
session_start();
require_once 'connect.php';
if (isset($_POST["submit"])) {
    $login = mysqli_real_escape_string($connect, $_POST['login']);
    $pass = mysqli_real_escape_string($connect, $_POST['pass']);
    $passconfirm = mysqli_real_escape_string($connect, $_POST['passconfirm']);
    if ($pass !== $passconfirm) {
        $error = "Пароли не совпадают!";
    }
    $query = "SELECT * FROM users WHERE login=?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "s", $login);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (md5($pass) === $user['pass']) {
            $error = "Новый пароль не должен совпадать со старым!";
        }
        if (!isset($error)) {
            $new_hash_pass = md5($pass);
            $update_query = "UPDATE users SET pass='$new_hash_pass' WHERE login='$login'";
            if ($connect->query($update_query)) {
                $_SESSION["success"] = "Пароль успешно изменен: " . $pass;
                unset($_SESSION['login']);
                header("Location: ../auth.php");
                exit();
            } else {
                $_SESSION["error"] = "Ошибка при изменении пароля!";
                header('Location: ../recoverypass.php');
                exit();
            }
        }
    } else {
        $error = "Пользователь не найден!";
    }
    $_SESSION['login'] = $login;
    if (isset($error)) {
        $_SESSION["error"] = $error;
        header('Location: ../recoverypass.php');
        exit();
    }
}
function generate_password($length = 8)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $password = "";
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $password;
}
