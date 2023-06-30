<?php
$connect = mysqli_connect('192.168.0.104', 'root', '', 'nsb');
if (!$connect) {
    die('Error connect to DataBase');
}
