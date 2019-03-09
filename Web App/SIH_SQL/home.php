<?php
    session_start();
    include_once 'includes/db.inc.php';
    
    if(isset($_SESSION['is_logged_in'])){} 
    else{
        include_once 'loginFirst.php';
        die();
    }
    $email = $_SESSION['email'];
    $emailarr = explode("@",$email);
    $query = 'SELECT * FROM PROFILES WHERE email = ?';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $name = $result['name'];
    if(isset($_POST['delete'])){
        echo 'Delete';
    }
    if(isset($_POST['logout'])){
        header('Location: index.php');
        unset($_SESSION['email']);
        unset($_SESSION['is_logged_in']);
        session_destroy();
        sessifon_abort();
    }
    if(isset($_POST['reject_btn'])){
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $reason = $_POST['text_to_reject'];
        $name = $_POST['hidden_name'];
        $query = "UPDATE requests" .$emailarr[0] ." SET status = '" .$reason ."' WHERE id = '" .$name ."'";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $url = '';
        if($reason=='') $url = 'false';
        else $url = 'true';
        header('Location: home.php?declined=' .$url);
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/home-style.css">
    <link rel="stylesheet" href="./css/doc.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    
    <script>
        var id = '';
        $(document).ready(function(){
            $('#addDoc').click(function(){
                $('.right-container').load('doctordetails.php');
            })
            $('#addPharma').click(function(){
                $('.right-container').load('pharmacist.php');
            })
            $('.card-block').load('requestsFetch.php');
         });    
    
    </script>
    <style>
        .decide-container{
            margin-right: 40px;
            margin-top: 10px;
        }
        .decide-btn{
            margin: 0px 5px 15px;
            border: none;
            box-shadow: 0 2px 10px -2px rgba(0,0,0,.5);
            padding: 5px 10px;
        }
        .doc-form-container2,.width-80{
            width: 80%;
            margin: 0 10%;
            padding: 30px 10%;
        }
        .width-80{
            width: 60%;
            margin: 10% 20%;
            padding: 5px 5px;
        }
        .w-80Per{
            width: 100%;
            margin: 10px 0;
        }
        .doc-form-container label{
            font-size: 20px;
        }
        option,select{
            background: #07f;
            color: white;
            font-size: 18px;
            padding: 6px 20px;
            border: none;
        }
        select{
            width: 80%;
        }
        option{
            padding: 12px 0;
            display: block;
        }
        .listItem{
            display: inline-block;
            width: auto;
            overflow: hidden;
            background: #aaa;
            border-radius: 20px;
            color:white;
            padding: 5px 10px;
            font-size: 14px;
            margin: 5px;
        }
        .listRef{
            font-size: 14px;
            color:white;
            margin: 5px 10px 5px 5px;
        }
        .back{
            position: relative;
            top:50%;
            transform: translateY(-50%)
        }
        .next{
            position: absolute;
            top:50%;
            right: 0;
            transform: translateY(-50%)
        }
    </style>
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

    <div class="content-container">
        <div class="row no-gutters">
            <div class="col-12 col-md-4 h-100 left-container">
                <div class="profile-container text-center">
                    <div class="profile-img"><i class="fas fa-user"></i></div>
                    <div class="esi-name my-3 text-white"><?php echo $name; ?></div>
                    <div class="location my-2 w-80 mx-auto clearfix t-bigger">
                        <div class="text-white float-left">Email:</div>
                        <div class="text-white ml-4 float-right"><?php echo $result['email']?$result['email']:'Not Set'; ?></div>
                    </div>
                    <div class="location my-2 w-80 mx-auto clearfix t-bigger">
                        <div class="text-white float-left">Location:</div>
                        <div class="text-white ml-4 float-right"><?php echo $result['address']?$result['address']:'Not Set'; ?></div>
                    </div>  
                    <div class="location my-2 w-80 mx-auto clearfix t-bigger">
                        <div class="text-white float-left">Phone no:</div>
                        <div class="text-white ml-4 float-right"><?php echo $result['contact']?$result['contact']:'Not Set'; ?></div>
                    </div>
                    <div class="location my-2 w-80 mx-auto clearfix t-bigger">
                        <div class="text-white float-left">Doctors:</div>
                        <div class="text-white ml-4 float-right"><?php echo $result['noofdoctors']?$result['noofdoctors']:'Not Set'; ?></div>
                    </div>
                    <div class="location my-2 w-80 mx-auto clearfix t-bigger">
                        <div class="text-white float-left">Staff:</div>
                        <div class="text-white ml-4 float-right"><?php echo $result['noofstaff']?$result['noofstaff']:'Not Set'; ?></div>
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
                    <div class="card-block clearfix">   
                    </div>
                </div>


            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Reason to Decline</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <input type="text" name="hidden_name" class="hidden_id none">
                        <textarea class="rejected_text" name="text_to_reject" id="" rows="10" style="width:90%; margin: 0 5% 20px"></textarea>
                        <br>
                        <button type="submit" name="reject_btn" class="btn btn-primary float-right clearfix mr-4">Decline</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Request approved Confirmation Pending.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            This request has been Approved. It has been sent to delhi headquaters for aprroval.
            </div>
            <div class="modal-footer">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <button type="button" name="delete" class="btn btn-primary reload" data-dismiss="modal">Ok</button>
                </form>
            </div>
            </div>
        </div>
    </div>
    <script>
        function approve(id){
            let arr = id.split(',');
            let val = arr[1];
            let idReq = arr[2];
            if(val.toUpperCase()==='Ambulance'.toUpperCase()){
                $('.right-container').load('ambulance.php',{
                nameofRequest: id,
                idOfReq: idReq                
            });
            } 
            else
            $('.right-container').load('selectDoctor.php',{
                nameofRequest: arr[0],
                docs: '',
                pharmacist: '',
                staff: ''
            });
        }
        function callMe(e){
            id = e;
        }
        $('#myModal').on('shown.bs.modal', function (e) {
            $('.hidden_id').val(id);
        })
        $('.reload').on('click',function(){
            window.location.reload();
        })
    </script>
</body>
</html>