<?php
$dsn = "mysql:host=localhost;dbname=c1_ovi_tasklist";
$username = "root";
$password = "";

$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
);
