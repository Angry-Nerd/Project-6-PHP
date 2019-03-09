<?php
    session_start();
    include_once './includes/db.inc.php';
    $email = $_SESSION['email'];
    $emailarr = explode("@",$email);
    $query = 'SELECT * from requests' .$emailarr[0];
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($res as $r){
        if($r['status']==''){
            echo '<div class="media-card">
            <div class="media">
                <i class="far fa-user industury-icon"></i>
                <div class="media-body clearfix">
                    <h5 class="float-right mr-4">' .$r['type'] .'</h5>
                    
                    <h4 class="mt-0">' .$r["Org"] .'</h4>
                    <h5 class="mt-0">' .$r["Address"] .'</h5>
                    ' .$r['description'] .'
                </div>
            </div>
            <div class="float-right decide-container">
                <button class = "decide-btn bg-danger text-white " data-toggle="modal" data-target="#myModal" onclick="callMe(' ."'" .$r['id'] ."'" .')">
                Decline</button>
                <button class = "decide-btn bg-primary text-white approve" onclick="approve(' ."'" .$r['id'] .',' .$r['type'] .',' .$r['id'] ."'" .')">Approve</button>
            </div>
            </div>';
        }
    }