<?php
    require 'init.php';
    $email = $_POST['email'];
    $query = "SELECT * FROM USERS where email = " ."'$email'";
    $res = mysqli_query($conn,$query);
    $array = array();
    while($r = mysqli_fetch_assoc($res)){
        $array[] = $r;
    }
    echo json_encode($array);