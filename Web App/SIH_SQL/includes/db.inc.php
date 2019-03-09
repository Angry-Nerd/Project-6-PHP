<?php
$servername = "localhost";
$username = "root";
$pwd = "";
$db = "sih_final";

$dsn = "mysql:host=" .$servername .';dbname=' .$db;
$pdo = new PDO($dsn,$username,$pwd);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);