<?php
$connect = mysqli_connect('localhost', 'root', '', 'nsb');
if (!$connect) {
    die('Error connect to DataBase');
}