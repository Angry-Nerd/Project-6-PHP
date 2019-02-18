<?php
    session_start();
    if(isset($_POST['is_logged_in'])){
        echo 'Please Log in First';
        die();
    }
    if(isset($_POST['logout'])){
        if(isset($_SESSION['email'])){
            header('Location: index.php');
            unset($_SESSION['is_logged_in']);
            session_destroy();
        }
    }




?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <script src="https://www.gstatic.com/firebasejs/5.8.3/firebase.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="home-style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <style>
        #logout{
            background: transparent;
            border:none;
        }   
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="m-auto">
                <div class="d-flex">
                    <div class="logo-container d-flex">
                        <a href="#">
                            <div class="logo-img"></div>
                            <div class="logo-text">Website</div>
                        </a>
                    </div>
                    <div class="nav-menu ml-auto">
                        <ul class="nav-list d-flex mb-0">
                            <li class="nav-list-item"><a href="#" class="nav-list-links">Home</a></li>
                            <li class="nav-list-item"><a href="#" class="nav-list-links">Profile</a></li>
                            <li class="nav-list-item"><a href="#" class="nav-list-links">Notification</a></li>
                            <li class="nav-list-item">
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="m-0">
                                <button name="logout" id="logout" href="" class="nav-list-links p-0">Logout</button>
                            </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="content-container">
        <div class="row no-gutters">
            <div class="col-12 col-md-4 h-100 left-container">
                <div class="profile-container text-center">
                    <div class="profile-img"><i class="fas fa-user"></i></div>
                    <div class="esi-name my-3 text-white">Name of esi</div>
                    <div class="location my-2 w-80 mx-auto clearfix t-bigger">
                        <div class="text-white float-left">Location:</div>
                        <div class="text-white ml-4 float-right">Hydrebad</div>
                    </div>
                    <div class="location my-2 w-80 mx-auto clearfix t-bigger">
                        <div class="text-white float-left">Location:</div>
                        <div class="text-white ml-4 float-right">Hydrebad</div>
                    </div>  
                    <div class="location my-2 w-80 mx-auto clearfix t-bigger">
                        <div class="text-white float-left">Location:</div>
                        <div class="text-white ml-4 float-right">Hydrebad</div>
                    </div>
                    <div class="location my-2 w-80 mx-auto clearfix t-bigger">
                        <div class="text-white float-left">Location:</div>
                        <div class="text-white ml-4 float-right">Hydrebad</div>
                    </div>
                    <div class="location my-2 w-80 mx-auto clearfix t-bigger">
                        <div class="text-white float-left">Location:</div>
                        <div class="text-white ml-4 float-right">Hydrebad</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8 h-100 right-container">
                
                <div class="right-top">
                    <div class="notification">Requests</div>
                </div>
                <div class="right-bottom">
                    <div class="no-notification none">
                        <i class="far fa-comment no-notification-icon mb-3"></i>
                        There is no notifications to show.
                    </div>

                    <div class="card-block">
                        <div class="media-card">
                            <div class="media">
                                <i class="far fa-user industury-icon"></i>
                                <div class="media-body">
                                    <h5 class="mt-0">Request 1</h5>
                                    Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                                </div>
                            </div>
                        </div>
                        <div class="media-card">
                            <div class="media">
                                <i class="far fa-user industury-icon"></i>
                                <div class="media-body">
                                    <h5 class="mt-0">Request 2</h5>
                                    Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                                </div>
                            </div>
                        </div>
                        <div class="media-card">
                            <div class="media">
                                <i class="far fa-user industury-icon"></i>
                                <div class="media-body">
                                    <h5 class="mt-0">Request 3</h5>
                                    Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                                </div>
                            </div>
                        </div>
                        <div class="media-card">
                            <div class="media">
                                <i class="far fa-user industury-icon"></i>
                                <div class="media-body">
                                    <h5 class="mt-0">Request 2</h5>
                                    Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                                </div>
                            </div>
                        </div>
                    </div>


                </div>


            </div>
        </div>
    </div>

    <script>
        var config = {
            apiKey: "AIzaSyAP_6xvNhK1oyicxNVPuyrw8Lmpl0h36Zs",
            authDomain: "web-sih.firebaseapp.com",
            databaseURL: "https://web-sih.firebaseio.com",
            projectId: "web-sih",
            storageBucket: "web-sih.appspot.com",
            messagingSenderId: "755025351445"
        };
        firebase.initializeApp(config);
        firebase.auth().onAuthStateChanged(firebaseUser => {
            if(firebaseUser){
                console.log(firebaseUser);
            } else console.log('Not Logged In');
            
        })
    
    </script>
</body>
</html>