<?php
    session_start();
    include_once 'includes/db.inc.php';
    $email = $_SESSION['email'];
    $emailarr = explode("@",$email);
    if(isset($_POST['submit_details'])){
        $Name = $_POST['Name'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];
        $gender = $_POST['gender'];
        $speciality = $_POST['speciality'];
        $schedule = $_POST['schedule'];
        $experience = $_POST['experience'];
        $query = 'INSERT INTO DOCTORS' .$emailarr[0] .' (name,age,experience,gender,email,contact,speciality,address,schedule) VALUES(
            ' ."'$Name'," ."'$age'," ."'$experience'," ."'$gender'," ."'$email'," ."'$contact'," ."'$speciality'," ."'$address'," ."'$schedule'" .'
        )';
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        header('Location: home.php?doc_added');
    }

?>

    <div class="right-container">
        <div class="right-top">
            <div class="notification">Doctor Details</div>
        </div>
        <div class="right-bottom">
            <div class="doc-form">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="doc-form-container">
                        <div class="form-group clearfix">
                            <h2 class="heading">General</h2>
                            <input type="text" name="Name" id="" placeholder="Name" class="half mr-5-per">
                            <input type="text" name="age" id="" placeholder="Age" class="half ml-5-per">
                            <input type="text" name="gender" id="" placeholder="Gender" class="half mr-5-per">
                            <input type="text" name="address" id="" placeholder="Address" class="half ml-5-per">
                            <input type="email" name="email" id="" placeholder="Email" class="half mr-5-per">
                            <input type="number" name="contact" id="" placeholder="Phn." class="half ml-5-per">
                        </div>
                        <div class="form-group clearfix">
                            <h2 class="heading">Details</h2>
                            <input type="text" name="speciality" id="" placeholder="Degree" class="half mr-5-per">
                            <input type="text" name="experience" id="" placeholder="Experience"class="half ml-5-per">
                            <input type="text" name="schedule" id="" placeholder="Schedule" class="full">
                        </div>
                        <button type="submit" class="submit-details" name="submit_details">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>