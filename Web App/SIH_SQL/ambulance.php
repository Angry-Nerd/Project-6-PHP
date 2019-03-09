<?php
    session_start();
    include_once 'includes/db.inc.php';
    $email = $_SESSION['email'];
    $emailarr = explode("@",$email);
    $id = $_POST['idOfReq'];
    $query = 'SELECT * FROM requests' .$emailarr[0] ." WHERE id = " .$id;
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    if(isset($_POST['select_ambulance'])){
        $query = '';
    }
?>

    <div class="right-top text-white">
        <button class="back btn btn-primary" id="back" 
            onclick="callMe()">
            &lt;
        </button>
        <div class="notification">Select Pharmacist</div>                
    </div>
    <div class="right-bottom">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="">
            <div class="location my-2 w-80 mx-auto clearfix t-bigger mt-5">
                        <div class="float-left">Email:</div>
                        <div class="ml-4 float-right"><?php echo $res['Email']?></div>
                    </div>
                    <div class="location my-2 w-80 mx-auto clearfix t-bigger">
                        <div class="float-left">Location:</div>
                        <div class="ml-4 float-right"><?php echo $res['Address']; ?></div>
                    </div>  
                    <div class="location my-2 w-80 mx-auto clearfix t-bigger">
                        <div class="float-left">Phone no:</div>
                        <div class="ml-4 float-right"><?php echo $res['Contact']; ?></div>
                    </div>
                    <div class="location my-2 w-80 mx-auto clearfix t-bigger">
                        <div class="float-left">Employee:</div>
                        <div class="ml-4 float-right"><?php echo $res['NoOfEmployees']; ?></div>
                    </div>
                    <div class="location my-2 w-80 mx-auto clearfix t-bigger">
                        <div class="float-left">Description:</div>
                        <div class="ml-4 float-right"><?php echo substr($res['description'],0,5) .'...'; ?></div>
                    </div>
            <button type="submit" name="select_ambulance" class="btn btn-primary width-80 submit_det my-2">Proceed</button>
        </form>
    </div>

    <script>
        function callMe(){
            window.location.reload();
        }
    </script>