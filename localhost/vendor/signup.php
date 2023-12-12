<?php
session_start();
require_once 'connect.php';
$familiya = mysqli_real_escape_string($connect, $_POST['familiya']);
$imya = mysqli_real_escape_string($connect, $_POST['imya']);
$otchestvo = mysqli_real_escape_string($connect, $_POST['otchestvo']);
$login = mysqli_real_escape_string($connect, $_POST['login']);
$pass = mysqli_real_escape_string($connect, $_POST['pass']);
$passconfirm = mysqli_real_escape_string($connect, $_POST['passconfirm']);

if ($pass === $passconfirm) {
    $pass = md5($pass);
    mysqli_query($connect, "INSERT INTO `users` (`id`, `familiya`, `imya`, `otchestvo`, `login`, `pass`, `role`) VALUES (NULL, '$familiya', '$imya', '$otchestvo', '$login', '$pass', 'Пользователь')");
    $_SESSION['msg'] = 'Регистрация прошла успешно!';
    header('Location: ../auth.php');
} else {
    $_SESSION['message'] = 'Пароли не совпадают';
    header('Location: ../registration.php');
}
