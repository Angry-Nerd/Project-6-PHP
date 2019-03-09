    <?php
    require 'init.php';
    $email = $_POST['email'];
    $noe = $_POST['noe'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $manager = $_POST['manager'];
    $org = $_POST['org'];
    $title = $_POST['title'];
    $type = $_POST['description'];
    $emailarr = explode("@",$email);
    $query = "INSERT INTO requests" .$emailarr[0] 
    .'(NoOfEmployees,Contact,Address,Manager,Title,Email,description,Org) ' 
    ."values('$noe','$contact','$address','$manager','$title','$email','$type','$org')";
    mysqli_query($conn,$query);
    