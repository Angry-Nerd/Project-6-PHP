<?php
$servername = "localhost";
$username = "root";
$pwd = "";
$db = "sih";

$dsn = "mysql:host=" .$servername .';dbname=' .$db;
$pdo = new PDO($dsn,$username,$pwd);