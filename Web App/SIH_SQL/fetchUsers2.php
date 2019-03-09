<?php

    require 'init.php';
    $query = 'SELECT * FROM profiles';
    $res = mysqli_query($conn,$query);
    $array = array();
    while($r = mysqli_fetch_assoc($res)){
        $array[] = $r;
    }
    echo json_encode($array);