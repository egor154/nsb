<?php
session_start();
require_once 'connect.php';
$login = $_POST['login'];
$pass = md5($_POST['pass']);
$stmt = mysqli_prepare($connect, "SELECT id, login, familiya, imya, otchestvo, role FROM users WHERE login = ? AND pass = ?");
mysqli_stmt_bind_param($stmt, 'ss', $login, $pass);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $_SESSION['user'] = $user_id;
    $_SESSION['user'] = [
        "id" => $user['id'],
        "login" => $user['login'],
        "familiya" => $user['familiya'],
        "imya" => $user['imya'],
        "otchestvo" => $user['otchestvo'],
        "role" => $user['role']
    ];
}
if ($_SESSION['user']['role'] == 'Пользователь') :
    header('Location: ../mainpagepolz.php');
elseif ($_SESSION['user']['role'] == 'Оператор') :
    header('Location: ../mainpageoper.php');
else :
    $_SESSION[$user] === false;
    $_SESSION['message'] = 'Вы ввели неправильный логин или пароль!' . "\n";
    header('Location: ../auth.php');
endif;
