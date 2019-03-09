<?php

    require 'init.php';
    $email = $_POST['email'];
    $name = $_POST['name'];
    $number = $_POST['number'];
    $address = $_POST['address'];
    $org = $_POST['organisation'];
    $manager = $_POST['chairperson'];
    $noe = $_POST['noe'];
    $query = "UPDATE USERS SET Name = '$name' , contactnumber = '$number' ,address = '$address'
    ,organisation = '$org' ,chairperson = '$manager' ,noofemployees = '$noe' where email = '$email'";
    mysqli_query($conn,$query);

