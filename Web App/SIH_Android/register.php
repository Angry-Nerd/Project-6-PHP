<?php

require 'init.php';
// $name = $_POST['name'];
$username = $_POST['user_name'];
$pwd = md5($_POST['pwd']);
$query = "INSERT into users(email,pwd) values('$username','$pwd');";
mysqli_query($conn,$query);