<?php

    require 'init.php';
    // $email = $_POST['email'];
    $query = 'SELECT * FROM profiles';
    $result = mysqli_query($conn,$query);
    $array = array();
    while($r = mysqli_fetch_assoc($result)){
        $array[] = $r;
    }
    echo json_encode($array);
