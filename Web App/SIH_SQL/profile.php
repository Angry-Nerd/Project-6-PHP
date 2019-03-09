<?php
    session_start();
    include_once 'includes/db.inc.php';
    $email = $_SESSION['email'];
    $emailarr = explode("@",$email);
    $msg = '';
    $color = 'white';
    
    if(isset($_POST['submit_details'])){
        $det_contact = $_POST['det-contact'];
        $det_address = $_POST['det-address'];
        $det_name = $_POST['det-name'];
        $det_docs = $_POST['det-docs'];
        $det_staff = $_POST['det-staff'];
        $facilities = $_POST['det-facilities'];
        $types = $_POST['det-type'];
        $query = 'UPDATE PROFILES set contact = ? , address = ? , name = ? , noofdoctors = ? , noofstaff = ?, facilities = ?, type = ? where email = ?' ;
        $stmt = $pdo->prepare($query);
        $stmt->execute([$det_contact,$det_address,$det_name,$det_docs,$det_staff,$facilities,$types,$email]);
        header("Location: profile.php?updated");
        if($stmt->rowCount()){ 
            $msg = 'Updated Successfully';
            $color = 'primary';
        }
        else{
            $msg = 'Cannot Update';
            $color = 'danger';
        }
    }
    $check_query = "SELECT * FROM PROFILES where email = ?";
    $check_stmt = $pdo->prepare($check_query);
    $check_stmt->execute([$email]);
    $result = $check_stmt->fetch(PDO::FETCH_ASSOC);
    $name = $result['name'];
    $phn = $result['contact'];
    $facilities = $result['facilities'];
    $type = $result['type'];
    $noofdoctors = $result['noofdoctors'];
    $noofstaff = $result['noofstaff'];
    $location = $result['address'];
    $emailVal = $result['email'];
    $contact = $result['contact'];
    
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/profile.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <title>Profile</title>
    <style>
        .top{
            flex-basis: 75%;
        }
        .bottom{
            flex-basis: 25%;
            padding: 30px 0;
        }
    </style>
</head>
<body>
    <header class="header">
            <div class="container">
                <div class="m-auto">
                    <div class="d-flex">
                        <div class="logo-container d-flex">
                            <a href="home.php">
                                <div class="logo-img"></div>
                                <div class="logo-text">ESI Care</div>
                            </a>
                        </div>
                        <div class="nav-menu ml-auto">
                            <ul class="nav-list d-flex mb-0">
                                <li class="nav-list-item"><a href="home.php" class="nav-list-links">Home</a></li>
                                <!-- <li class="nav-list-item"><a href="#" class="nav-list-links">Profile</a></li>
                                <li class="nav-list-item"><a href="#" class="nav-list-links">Notification</a></li> -->
                                <!-- <li class="nav-list-item">
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="m-0">
                                        <button name="logout" id="logout" href="" class="nav-list-links p-0">Logout</button>
                                    </form>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
    </header>
    <div class="profile-form">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="h-100">
            <div class="form-container d-flex flex-column m-0">
                <div class="top">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">Email</label>
                            <input type="email" class="form-control" id="inputEmail4" value="<?php echo $emailVal; ?>" placeholder="Email" disabled>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Name</label>
                            <input type="text" class="form-control" id="inputPassword4" value="<?php echo $name; ?>" placeholder="Not Set" name="det-name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Address(Must have long and lats sep by ,)</label>
                        <input type="text" class="form-control" id="inputAddress" value="<?php echo $location; ?>" placeholder="Not Set" name="det-address">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">No of Doctors</label>
                        <input type="text" class="form-control" id="inputAddress" value="<?php echo $noofdoctors; ?>" placeholder="Not Set" name="det-docs">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">No of Staff</label>
                        <input type="text" class="form-control" id="inputAddress" value="<?php echo $noofstaff; ?>" placeholder="Not Set" name="det-staff">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Contact</label>
                        <input type="text" class="form-control" id="inputAddress" value="<?php echo $contact; ?>" placeholder="Not Set" name="det-contact">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Facilities</label>
                        <input type="text" class="form-control" id="inputAddress" value="<?php echo $facilities; ?>" placeholder="Not Set" name="det-facilities">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Type</label>
                        <input type="text" class="form-control" id="inputAddress" value="<?php echo $type; ?>" placeholder="Not Set" name="det-type">
                    </div>
                    <div class="text-<?php echo $color; ?>"><?php echo $msg; ?> </div>
                </div>
                <button class="bottom text-center" name="submit_details" type="submit">Submit</button>

            </div>
        </form>
    </div>
    
</body>
</html>