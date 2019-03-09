<header class="header">
        <div class="container">
            <div class="m-auto">
                <div class="d-flex">
                    <div class="logo-container d-flex">
                        <a href="#">
                            <div class="logo-img"></div>
                            <div class="logo-text">ESI Care</div>
                        </a>
                    </div>
                    <div class="nav-menu ml-auto">
                        <ul class="nav-list d-flex mb-0">
                            <li class="nav-list-item text-center"><a href="home.php" class="nav-list-links">Home</a></li>
                            <li class="nav-list-item text-center"><a href="profile.php" class="nav-list-links">Profile</a></li>
                            <li class="nav-list-item text-center">
                                <div class="dropdown" style="height: 80px">
                                    <button class="btn btn-default dropdown-toggle p-0 text-white" style="margin-top: calc(40px - 14px)" type="button" data-toggle="dropdown">Update</button>
                                    <ul class="dropdown-menu p-0 m-0">
                                        <li><button id="addDoc" class="btn p-0 w-100 pl-3">Add Doctor</button></li>
                                        <li><button id="addPharma" class="btn p-0 w-100 pl-3">Add Pharmacist</button></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-list-item text-center">
                                <div class="dropdown" style="height: 80px">
                                    <button class="btn btn-default dropdown-toggle p-0 text-white" style="margin-top: calc(40px - 14px)" type="button" data-toggle="dropdown">Events</button>
                                    <ul class="dropdown-menu p-0 m-0">
                                        <li><button id="" class="myBtn btn p-0 w-100 pl-3" onclick = 'window.location = "addEvent.php"'>Add Event</button></li>
                                        <li><button id="" class="myBtn btn p-0 w-100 pl-3" onclick = 'window.location = "seeEvent.php"'>See Event</button></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-list-item text-center">
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