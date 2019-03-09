<?php
    session_start();
    $to  = "atulsagotra774@gmail.com";
    $subject = "Request of the Medical Camp";
    $message = "This request is from organistaionname from organisationaddress  with noofemployees. 
    They have requested for a medical
    camp in their organisation. We hospitalname from hospitaladdress 
    have approved the request and selected the following doctors and staff members:- 
    
    for loop list of all the doctors 
    and  ESI Dispensary pharmaaddress will provide the medical
     support
    Please confirm the medical camp by approving the confirmation.</p>";
    
    $headers = "From: esicare6@gmail.com";
    
    if(mail($to, $subject, $message, $headers))
        echo "Mail sendSuccesfully";
    else{
        echo "Cannot Send Mail";
    }
    
    include_once 'includes/db.inc.php';
    $email = $_SESSION['email'];
    $emailarr = explode("@",$email);

    if(isset($_POST['submit-details'])){
        $Name = $_POST['Name'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $rating = $_POST['rating'];
        $timing = $_POST['timing'];
    
        $query = 'INSERT INTO PHARMACISTS' .$emailarr[0] .' (name,email,contact,address,rating,timing) VALUES(
            ' ."'$Name'," ."'$contact'," ."'$email'," ."'$address'," ."'$rating'," ."'$timing'" .'
        )';
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        header('Location: home.php?pharmacist_added');
    }

?>

    <div class="right-container">
        <div class="right-top">
            <div class="notification">Pharmacist Details</div>
        </div>
        <div class="right-bottom">
            <div class="doc-form">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="doc-form-container">
                        <div class="form-group clearfix">
                            <h2 class="heading">General</h2>
                            <input type="text" name="Name" id="" placeholder="Name" class="half mr-5-per">
                            
                            <input type="email" name="email" id="" placeholder="Email" class="half mr-5-per">
                            <input type="number" name="contact" id="" placeholder="Phn." class="half mr-5-per">
                        </div>
                        <div class="form-group clearfix">
                            <h2 class="heading">Details</h2>
                            <input type="text" name="address" id="" placeholder="Address" class="full">
                            <input type="text" name="rating" id="" placeholder="Rating" class="full">
                            <input type="text" name="timing" id="" placeholder="Timing" class="full">
                        </div>
                        <button class="submit-details" name="submit-details">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>