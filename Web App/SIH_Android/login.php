<?php

    require 'init.php';
    $user_name = $_POST['login_name'];
    $user_pwd = md5($_POST['login_pwd']);

    $query = "SELECT * from users where email like '$user_name' and pwd like '$user_pwd'";
    $result = mysqli_query($conn,$query);
    // $res = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result)>0){
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        echo "Login Success...";
    } else {
        echo "Failed";
    }
