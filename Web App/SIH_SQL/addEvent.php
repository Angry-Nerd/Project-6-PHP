<?php
    session_start();
    include_once 'includes/db.inc.php';
    $email = $_SESSION['email'];
    $emailarr = explode("@",$email);
    if(isset($_POST['submit'])){
        include_once 'includes/db.inc.php';
        $type = $_POST['type'];
        $startdate = $_POST['startdate'];
        $enddate = $_POST['enddate'];
        $starttime = $_POST['start-time'];
        $endtime = $_POST['endtime'];
        $description = $_POST['description'];
        $venue = $_POST['venue'];
        $query = 'INSERT INTO EVENTS' .$emailarr[0]  .'(type,StartDate,EndDate,StartTime,EndTime,Description,venue) 
                VALUES(' ."'$type'," ."'$startdate'," ."'$enddate'," ."'$starttime'," ."'$endtime'," 
                ."'$description'," ."'$venue')";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Event</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/event.css">
    <link rel="stylesheet" href="css/home-style.css">
    <style>
        .nav-list-item{
            width: 80px;
        }
        .dropdown-toggle::after{display: none}
        .dropdown:hover .dropdown-menu{display:block}
        #addDoc,#addPharma,.myBtn{
            color:black; 
            height: 60px;
            font-weight: 400;
            text-align: left
        }
        .dropdown-menu li{line-height: 60px}
        button:focus{outline: none !important;}
    </style>
</head>
<body>
    <?php include_once 'header.php'; ?>
    <div class="form-event-container">
        <h1 class="addEventHeading text-center pt-2 pb-3">Add Event</h1>
        <div class="form-event-carrier">
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class="form">
                <div class="form-row">
                    <div class="form-group col-md-12">
                    <label for="inputEmail4">Type</label>
                    <input type="text" name="type" class="form-control" id="inputEmail4" placeholder="Type" required>
                    </div>
                    
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Start Date</label>
                        <input type="text" name="startdate" class="form-control" id="inputPassword4" placeholder="Start Date" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputAddress">End Date</label>
                        <input type="text" name="enddate" class="form-control" id="inputAddress" placeholder="enddate" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputAddress">Start Time</label>
                        <input type="text" name="start-time" class="form-control" id="inputAddress" placeholder="Start Time" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputAddress">End Time</label>
                        <input type="text" name="endtime" class="form-control" id="inputAddress" placeholder="End Time" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAddress">Description</label>
                    <textarea name="description" class="form-control" id="inputAddress" placeholder="Description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="inputAddress">Venue</label>
                    <input type="text" name="venue" class="form-control" id="inputAddress" placeholder="Venue" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form> 
        </div>
    </div>
</body>
</html>


<!-- <div class="form-row">
                    <div class="form-group col-md-6">
                    <label for="inputCity">City</label>
                    <input type="text" name="city" class="form-control" id="inputCity" required>
                    </div>
                    <div class="form-group col-md-4">
                    <label for="inputState">State</label>
                    <select id="inputState" name="state" class="form-control" required>
                        <option selected>Choose...</option>
                        <option>Punjab</option>
                        <option>Haryana</option>
                        <option>UP</option>
                        <option>Bihar</option>
                    </select>
                    </div>
                    <div class="form-group col-md-2">
                    <label for="inputZip">Zip</label>
                    <input type="text" name="zip" class="form-control" id="inputZip" required>
                    </div>
                </div> -->