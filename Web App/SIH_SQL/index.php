<?php
    session_start();
    include_once './includes/db.inc.php';
    if(isset($_SESSION['is_logged_in'])){
        header('Location: home.php');
    }
    $do_not_exists = '';
    $verify = '';
    $wrong_password = '';
    $exists = '';
    $done = '';
    if(isset($_POST['signup'])){
        $email = $_POST['signup-uid'];
        $pwd = md5($_POST['signup-pwd'])    ;
        $query = "INSERT INTO PROFILES(email,pwd) values('$email','$pwd')";
        $check_query = "SELECT * FROM PROFILES where email = ?";
        $check_stmt = $pdo->prepare($check_query);
        $check_stmt->execute([$email]);
        $posts_count = $check_stmt->rowCount();
        $emailarr = explode("@",$email);
        if($posts_count!=0){
            echo '<script language="javascript">';
            echo 'alert("User Exists")';
            echo '</script>';
        } else {
                $docTable = 'CREATE TABLE DOCTORS' .$emailarr[0] .'(
                    id int NOT NULL AUTO_INCREMENT,
                    Name varchar(255) NOT NULL,
                    Age varchar(255) NOT NULL,
                    Experience varchar(255) NOT NULL,
                    Gender varchar(10) NOT NULL,
                    Email varchar(255) NOT NULL,
                    Contact varchar(11) NOT NULL,
                    Speciality varchar(255) NOT NULL,
                    Address varchar(255) NOT NULL,
                    Schedule varchar(255) NOT NULL,
                    PRIMARY KEY(id)
                )';
                $pharmaTable = 'CREATE TABLE PHARMACISTS' .$emailarr[0] .'(
                    id int NOT NULL AUTO_INCREMENT,
                    Name varchar(255) NOT NULL,
                    Email varchar(255) NOT NULL,
                    Contact varchar(11) NOT NULL,
                    Address varchar(255) NOT NULL,
                    Rating varchar(5) NOT NULL,
                    Timing varchar(255) NOT NULL,
                    PRIMARY KEY(id)
                )';
                $staffTable = 'CREATE TABLE STAFF' .$emailarr[0] .'(
                    id int NOT NULL AUTO_INCREMENT,
                    Name varchar(255) NOT NULL,
                    Age varchar(255) NOT NULL,
                    Experience varchar(255) NOT NULL,
                    Gender varchar(10) NOT NULL,
                    Email varchar(255) NOT NULL,
                    Contact varchar(11) NOT NULL,
                    Address varchar(255) NOT NULL,
                    PRIMARY KEY(id)
                )';
                $requests = 'CREATE TABLE REQUESTS' .$emailarr[0] .'(
                    id int(10) NOT NULL AUTO_INCREMENT,
                    Title varchar(255) NOT NULL,
                    NoOfEmployees varchar(10) NOT NULL,
                    Manager varchar(50) NOT NULL,
                    Email varchar(255) NOT NULL,
                    Contact varchar(11) NOT NULL,
                    Address varchar(255) NOT NULL,
                    description varchar(255) NOT NULL,
                    type varchar(255) NOT NULL,
                    status varchar(255) NOT NULL,
                    Org varchar(255) NOT NULL,
                    PRIMARY KEY(id)
                )';
                $events = 'CREATE TABLE EVENTS' .$emailarr[0] .'(
                    type varchar(255) NOT NULL,
                    StartDate varchar(25) NOT NULL,
                    EndDate varchar(25) NOT NULL,
                    StartTime varchar(25) NOT NULL,
                    EndTime varchar(25) NOT NULL,
                    Description varchar(255) NOT NULL,
                    Guests varchar(100) NOT NULL,
                    Sponsors varchar(255) NOT NULL,
                    Venue varchar(255) NOT NULL,
                    status varchar(255) NOT NULL
                )';
                
                $doc_stmt = $pdo->prepare($docTable);
                $doc_stmt->execute();
                $pharma_stmt = $pdo->prepare($pharmaTable);
                $pharma_stmt->execute();
                $staff_stmt = $pdo->prepare($staffTable);
                $staff_stmt->execute();
                $requests_stmt = $pdo->prepare($requests);
                $requests_stmt->execute();
                $events_stmt = $pdo->prepare($events);
                $events_stmt->execute();
                $stmt = $pdo->prepare($query);
                $stmt->execute(['email' => $email, 'pwd' => $pwd]);
                $done = "You are signed up. Please Log in";
            }

        }
        else if(isset($_POST['signin'])){

        $email = $_POST['signin-uid'];
        $pwd = md5($_POST['signin-pwd']);
        $query = "SELECT * from PROFILES where email=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$email]);
        $res = $stmt->fetchAll();
        if(sizeof($res)==0){
            $do_not_exists = "User do not exists.";
        } else{
            if($res[0]->pwd == $pwd) {
                $_SESSION['email'] = $email;
                $_SESSION['is_logged_in'] = true;
                header('Location: home.php'); 
            } else {
                $wrong_password = "Wrong Password";
            }
        }


    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head> 
<body>

    <div class="login-header">
        <div class="logo-container">
            <div class="logo"></div>
            <div class="site-name roboto">ESI Care </div>
        </div>
    </div>
    <div class="form-container">
        <div class="row m-0 w-100 h-100">
            <div class="col-md-5 sign-user border-rad-10-left h-100">
                <div class="sign-user-container">
                    <h1 class="roboto text-white sign-user-container-head">Welcome Again</h1>
                    <p class="text-white text-center sign-user-container-p">
                        Welcome here! You can join our org.
                        please login here with your account.
                        Please login here with your.
                    </p>
                    <h2 class="sign-user-container-head-2 text-white">New User?</h2>
                    <button type="button" onclick="toggle(this)" class="sign-toggle">Sign Up</button>
                </div>
            </div>
            <div class="col-md-7 h-100 bg-white user-form-container">
                <div class="form-carrier text-center h-100 roboto">
                    <h2 class="create-account">Log In</h2>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="signin-form" class="sign-user-form" onsubmit="return validateSignIn()">
                        <div class="form-group">
                          <input required type="email" class="form-control border-radius-50 input-control" placeholder="username" name="signin-uid" id="signin-uid" autocomplete="off">
                        </div>
                        
                        <div class="form-group">
                            <input required type="password" class="form-control border-radius-50 input-control" placeholder="password" name="signin-pwd" id="signin-pwd">
                        </div>
                        <div class="text-center mt-4"> <button name="signin" id="signin" type="submit" class="submit roboto">Log In</button> </div>
                        <div class="text-primary mt-3"><?php echo $done?></div>
                        <div class="text-danger mb-2"><?php echo $do_not_exists .$verify; ?></div>
                        <div class="text-danger"><?php echo $wrong_password; ?></div>
                    </form>
                    <form action="<?php echo $_SERVER['PHP_SELF'] .'?sign_up'; ?>" id="signup-form" method="post" class="sign-user-form none" onsubmit="return validateSignUp()">
                        <div class="form-group">
                          <input required type="email" class="form-control border-radius-50 input-control" placeholder="username" name="signup-uid" id="signup-uid" autocomplete="off">
                        </div>
                        <div class="text-danger mb-3"><?php echo $exists?></div>
                        <div class="form-group">
                            <input required type="password" class="form-control border-radius-50 input-control" placeholder="password" name="signup-pwd" id="signup-pwd">
                        </div>
                        <div class="form-group">
                            <input required type="password"  class="form-control border-radius-50 input-control" placeholder="confirm password" name="cpwd" id="cpwd">
                        </div>
                        <div class="text-center mt-4"> <button name="signup" id="signup" type="submit" class="submit roboto">Sign Up</button> </div>
                    </form>
                </div>
            </div>
        </div>



    </div>
    <script>
        function toggle(e){
            let z = e.innerHTML;
            if(z=='Sign Up'){
                document.getElementById('signin-form').style.display = 'none';
                document.getElementById('signup-form').style.display = 'block';
                document.querySelector('.sign-user-container-head').innerHTML = "Join Here";
                document.querySelector('.sign-user-container-p').innerHTML = "Welcome here! You can join our org. Hey there! To keep connected with us Please Signup here with your account.";
                e.innerHTML = 'Log In';
                document.querySelector('.create-account').innerHTML = 'Sign Up';
                document.querySelector('.sign-user-container-head-2').innerHTML = 'Already have <br>an account?'
                document.querySelector('.sign-user-container-head-2').style.marginTop = '95px';

            } else {
                document.getElementById('signin-form').style.display = 'block';
                document.getElementById('signup-form').style.display = 'none';
                document.querySelector('.sign-user-container-head').innerHTML = "Welcome Again";
                document.querySelector('.sign-user-container-p').innerHTML = "Welcome here! You can join our org. Please login here with your account. Please login here with your.";
                e.innerHTML = 'Sign Up';
                document.querySelector('.create-account').innerHTML = 'Log In';
                document.querySelector('.sign-user-container-head-2').innerHTML = 'New User?'
                document.querySelector('.sign-user-container-head-2').style.marginTop = '55px';
            }            
        }
        function validateSignUp(){
            x = document.querySelector('#signup-pwd').value;
            y = document.querySelector('#cpwd').value;
            if(x!=y){
                window.alert('Passwords do not match'); 
                return false;
            } 
            if(x.length<6){
                alert('Length too short.');
                return false;
            }
            //signUp();
            return true;
        }
        function validateSignIn(){
            x = document.querySelector('#signin-pwd').value;
            if(x.length<6){
                alert('Length too short.');
                return false;
            }
            //signIn();
            return true;
        }
        /*var config = {
            apiKey: "AIzaSyAP_6xvNhK1oyicxNVPuyrw8Lmpl0h36Zs",
            authDomain: "web-sih.firebaseapp.com",
            databaseURL: "https://web-sih.firebaseio.com",
            projectId: "web-sih",
            storageBucket: "web-sih.appspot.com",
            messagingSenderId: "755025351445"
        };
        firebase.initializeApp(config);
        function signUp(){
            var uid = document.getElementById('signup-uid');
            var pwd = document.getElementById('signup-pwd');
            var cpwd = document.getElementById('cpwd');
            const temail = uid.value;
            const tpwd = pwd.value;
            const auth = firebase.auth();
            const promise = auth.createUserWithEmailAndPassword(temail,tpwd);
            promise.catch(e => {console.log(e.message)});
            console.log('Done');
            ;
            
        }
        function signIn(){
            var uid = document.getElementById('signin-uid');
            var pwd = document.getElementById('signin-pwd');
            const temail = uid.value;
            const tpwd = pwd.value;
            const auth = firebase.auth();
            const promise = auth.signInWithEmailAndPassword(temail,tpwd);
            promise.catch(e => {console.log(e.message)});
            window.location.href = '../home/home.html';          
        }
        firebase.auth().onAuthStateChanged(firebaseUser => {
            if(firebaseUser){
                console.log(firebaseUser);
            } else console.log('Not Logged In');
            
        })*/
    </script>
</body>
</html>