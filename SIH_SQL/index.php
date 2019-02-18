<?php
    session_start();
    include_once './includes/db.inc.php';

    $do_not_exists = '';
    $verify = '';
    $wrong_password = '';
    $exists = '';
    $done = '';


    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);



    if(isset($_POST['signup'])){
        $email = $_POST['signup-uid'];
        $pwd = $_POST['signup-pwd'];
        $query = "insert into sih(email,pwd) values('$email','$pwd')";

        $check_query = "SELECT * FROM SIH where email = ?";
        $check_stmt = $pdo->prepare($check_query);
        $check_stmt->execute([$email]);
        $posts_count = $check_stmt->rowCount();
        if($posts_count!=0){
            $exists = "User Exists";
        } else {
            $stmt = $pdo->prepare($query);
            $stmt->execute(['email' => $email, 'pwd' => $pwd]);
            $done = "You are signed up. Please Log in";
        }
    } else if(isset($_POST['signin'])){

        $email = $_POST['signin-uid'];
        $pwd = $_POST['signin-pwd'];

        $query = "SELECT * from sih where email=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$email]);
        $res = $stmt->fetchAll();
        echo sizeof($res);
        if(sizeof($res)==0){
            $do_not_exists = "User do not exists.";
            $wrong_password = "";
            $exists = '';
            $done = '';
            $verify = '';
        } else{
            if($res[0]->pwd == $pwd) {
                $_SESSION['email'] = $email;
                $_SESSION['is_logged_in'] = true;
                header('Location: home.php');
                
            } else {
                $wrong_password = "Wrong Password";
                $exists = '';
                $done = '';
                $do_not_exists = '';
                $verify = '';
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
    <script src="https://www.gstatic.com/firebasejs/5.8.3/firebase.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head> 
<body>

    <div class="login-header">
        <div class="logo-container">
            <div class="logo"></div>
            <div class="site-name roboto">Website</div>
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
                          <input required type="email" class="form-control border-radius-50 input-control" placeholder="username" name="signin-uid" id="signin-uid">
                        </div>
                        <div class="text-danger mb-2"><?php echo $do_not_exists .$verify; ?></div>
                        <div class="form-group">
                            <input required type="password" class="form-control border-radius-50 input-control" placeholder="password" name="signin-pwd" id="signin-pwd">
                        </div>
                        <div class="text-danger"><?php echo $wrong_password; ?></div>
                        <div class="text-center mt-4"> <button name="signin" id="signin" type="submit" class="submit roboto">Log In</button> </div>
                        <div class="text-primary mt-3"><?php echo $done?></div>
                    </form>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="signup-form" method="post" class="sign-user-form none" onsubmit="return validateSignUp()">
                        <div class="form-group">
                          <input required type="email" class="form-control border-radius-50 input-control" placeholder="username" name="signup-uid" id="signup-uid">
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