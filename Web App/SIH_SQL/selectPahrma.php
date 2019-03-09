<?php
    session_start();
    include_once 'includes/db.inc.php';
    require 'mail.php';
    $email = $_SESSION['email'];
    $emailarr = explode("@",$email);
    $req = '';
    $docs = '';
    $pharmas = '';
    $resPharma = '';
    $staff = '';
    if(isset($_POST['select_pharma'])){
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $doctors = $_POST['docsInput'];
        $staff = $_POST['staffInput'];
        $pharmacists = $_POST['pharmasInput'];
        $timeOfCamp = $_POST['no_of_days'];
        $people = $_POST['no_of_people'];
        $staff = $_POST['staffInput'];
        $req = $_POST['req'];
        $docsArray = explode(',',$doctors);
        $staffArray = explode(',',$staff);
        $pharmacistsArr = explode(',',$pharmacists);
        // mailAllUsers($docArray);
        // mailAllUsers($staffArray);
        // mailAllUsers($pharmacistsArr);
        $completed_query = 'INSERT INTO EVENTS' .$emailarr[0] .' (status) VALUES(
            ' ."'$doctors'," ."'$staff'," ."'$pharmacists'," ."'$people'," ."'$timeOfCamp'" .')    
        ';
        $completed_stmt = $pdo->prepare($completed_query);
        $completed_stmt->execute();
        $delete_req_query = 'DELETE FROM REQUESTS ' .$emailarr[0] . ' WHERE name = ?';
        $delete_stmt = $pdo->prepare($delete_req_query);
        $delete_stmt->execute([$email]);
        header('Location: home.php?approved=true');
    } else {
        $req = $_POST['req'];
        $docs = $_POST['docs'];
        $pharmas = $_POST['pharmacist'];
        $staff = $_POST['staff'];
        $query = 'SELECT * from PHARMACISTS' .$emailarr[0];
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $resPharma = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

?>
    <style>
        .fancy-text{
            font-size: 22px;
        }
        .back{
            top:90%;
            left: 20px;
            position: absolute;
        }
    </style>
    <div class="right-top text-white">
        <div class="notification">Select Pharmacist</div>                
    </div>
    <div class="right-bottom">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return false">
            <h2 class="notification" style="font-size:16px; top:25%">Send details to pharmacist for requirements</h2>
            <div class="doc-form-container2">
                <input type="hidden" name="req" id="req" value="<?php echo $req; ?>">   
                <input type="hidden" name="docsInput" id="docsInput" value="<?php echo $docs; ?>">    
                <input type="hidden" name="staffInput" id="staffInput" value="<?php echo $staff; ?>">    
                <input type="hidden" name="pharmasInput" id="pharmasInput" value="<?php echo $pharmas; ?>">    
                <div class="form-group row mt-5">
                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm fancy-text">Name of Pharmacist</label>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-7">
                        <select name="selected" id="pharmacistSelector">
                            <?php $var = 0; foreach($resPharma as $r):  ?>
                                <option value="<?php echo $r['Name'] ?>"><?php echo $r['Name']; ?></option>
                            <?php $var++; endforeach; ?>
                        </select>
                        <div class="w-80Per" id="pharmacistList">
                        </div>
                    </div>
                    
                </div>    
                <!-- <div class="form-group row mt-5">
                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">No. of employees</label>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-7">
                        <input type="text" name="no_of_people" id="" class="form-control">
                        <div class="w-80Per" id="docList">
                        </div>
                    </div>
                </div> -->
                <div class="form-group row mt-5">
                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm fancy-text">No. of days</label>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-7">
                        <input type="text" name="no_of_days" id="" class="form-control">
                        <div class="w-80Per" id="docList">
                        </div>
                    </div>
                </div>
                
            </div>
            <button type="submit" name="select_pharma" class="btn btn-primary width-80 submit_det my-2" data-toggle="modal" data-target="#exampleModal">Proceed</button>
        </form>
        <button class="back btn btn-primary" id="back" 
            onclick="callMe()">
            Previous
        </button>
    </div>
    
    <script>        
        $('.submit_det').click(function(){
            $('#req').val($('#req').val());
            $('#docs').val($('#docsInput').val());
            $('#pharmas').val($('#pharmasInput').val());

        })
        $('#pharmacistSelector').on('change',function(){
            $('#pharmasInput').val($('#pharmacistSelector').val())
        })
        $('.back').click(function(){
                $('.right-container').load('selectDoctor.php',{
                    nameofRequest: $('#req').val(),
                    docs: $('#docsInput').val(),
                    pharmacist: $('#pharmasInput').val(),
                    staff: $('#staffInput').val()
                });
            })
    </script>
    