<?php
    session_start();
    include_once 'includes/db.inc.php';
    $email = $_SESSION['email'];
    $emailarr = explode("@",$email);
    $query = 'SELECT * FROM EVENTS' .$emailarr[0];
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
        <h1 class="addEventHeading text-center pt-2 pb-3">See Events</h1>
        <div class="events">
            <?php foreach($result as $res): ?>
                <div class="media">
                    <img class="media-image" src="img/head-back.jpg" alt="Generic placeholder image">
                    <div class="media-body">
                        <h5 class="mt-0"><?php echo $res['type'] ?></h5>
                        <div>No of days: <?php echo $res['StartDate'] .'-' .$res['EndDate'] ; ?></div>
                        <div>Timing: <?php echo  $res['StartTime'] .'-' .$res['EndTime']; ?></div>
                        <div>Address: <?php echo $res['Venue'] ?></div>
        
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</body>
</html>