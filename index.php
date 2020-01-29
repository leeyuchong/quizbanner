<?php 
session_start();
require 'head.php'; 
?>

<body>
    
    <?php
        if(isset($_POST['loginBtn'])){
            $sql="SELECT * FROM users WHERE username='".$_POST['usernameinput']."'";
            $result = $db->query($sql);
            if(mysqli_num_rows($result)==0){?>
                <script type="text/javascript">
                    alertModal("Username not found.")
                </script>
            <?php }
            else{
                while($row = $result->fetch_assoc()) {
                    if($row['pass']==$_POST['passwordinput']){
                        $_SESSION["username"]=$_POST['usernameinput'];
                        #echo $GLOBALS['username'];
                    }
                    else{ ?>
                        <script type="text/javascript">
                            alertModal("Incorrect password.")
                        </script>
                    <?php }
                }
                
            }
        }
        if(isset($_POST['signUpBtn'])){
            $sql="SELECT username FROM users WHERE username='".$_POST['usernameinput']."'";
            $checkDups = $db->query($sql);
            if(mysqli_num_rows($checkDups)===1){?>
                <script type="text/javascript">
                    alertModal("Username already in use.")
                </script>
            <?php } 
            else {
                $sql= "INSERT INTO users (username, pass) VALUES ('" . $_POST['usernameinput'] . "', '" . $_POST['passwordinput'] . "')";
                if(!$db->query($sql)) {
                    echo $mysqli->error;
                }
                else{
                    $_SESSION["username"]=$_POST['usernameinput'];
                }
            }
        }
        if(isset($_POST['searchTerm'])){
            $currentSearchTerm=$_POST['searchTerm'];
            }
            else{
                $currentSearchTerm="";
            }
    ?>
    <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
        <span class="navbar-brand mb-0">Spring 2020</span>
        <br>
        <button class ="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav mr-auto">
                <a class="d-block d-md-none nav-item nav-link active" href="#">Search<span class="sr-only">(current)</span></a>
                <a class="d-block d-md-none nav-item nav-link" href="scheduler.php">Scheduler</a>
            </div>
            <div class="navbar-nav">
                <?php
                    #echo $GLOBALS['username'];
                    if(isset($_SESSION["username"])){
                        echo '<a class="nav-item nav-link float-right" data-toggle="modal" data-target="#login" href="#"><img src="user.png" width="20" height="20" class="mr-1">'.$_SESSION["username"].'</a>';
                    }
                    else{
                        echo '<a class="nav-item nav-link float-right" data-toggle="modal" data-target="#login" href="#">Log in/Sign up</a>';
                    }
                ?>
                <a class="nav-item nav-link float-right" data-toggle="modal" data-target="#help" href="#">Help</a>
                <a class="nav-item nav-link float-right" data-toggle="modal" data-target="#about" href="#">About</a>

            </div>
        </div>
    </nav>
    <?php require 'navbarandmodal.php'; ?>

    <div class="container-fluid">
        <div class="row align-items-start">
            <div class="col">
                <div id = 'form'>
                    <form method="post">
                            <div class="container d-flex bd-highlight m-2">
                                <input class = "form-control mr-2 bd-highlight" type="text" placeholder ="Search" aria-label="Search" name="searchTerm" id="searchTerm">
                                <button class="btn btn-outline-success bd-highlight" type="submit" name="search" id="search" value="search">Search</button>
                            </div> 
                    </form>
                </div>
                <?php 
                    if ($message) {
                        echo "<h2> $message </h2>";
                    } else { 
                        if(!isset($_POST['searchTerm'])){?>
                            <div class="card p-0 mb-2">
                            <button class ="collapsed m-0 p-0" data-toggle = "collapse" data-target="#codes" aria-expanded="false" aria-controls="codes">
                                <div class="card-header text-left m-0">
                                    Search for terms using codes. Click for list of codes.
                                </div>
                            </button>
                            <?php 
                            require 'help.php';
                        }
                        else { ?>
                            <p>
                                Searching for: <?php echo $_POST['searchTerm']?>
                            </p>
                            
                            <?php 
                            $searchArray = explode(" ", $_POST['searchTerm']);
                            $query = "";
                            foreach($searchArray as $val){
                                $search = mysqli_real_escape_string($db, trim($val));
                                if(!empty($query)) {
                                    $query = $query . " AND ";
                                }
                                if(strtoupper($val)=='FR'){
                                    $query = $query."fr LIKE 1";
                                }
                                elseif(strtoupper($val)=='NR' || $val=='NRO'){
                                    $query = $query.'gm LIKE "NR"';
                                }
                                elseif(strtoupper($val)=="SU"){
                                    $query = $query.'gm LIKE "SU"';
                                }
                                elseif(strtoupper($val)=='YL'){
                                    $query = $query."yl LIKE 1";
                                }
                                elseif(strtoupper($val)=='QA'){
                                    $query = $query."qa LIKE 1";
                                }
                                elseif(strtoupper($val)=='LA'){
                                    $query = $query."la LIKE 1";
                                }
                                elseif(strtoupper($val)=='CLS'){
                                    $query = $query.'format LIKE "CLS"';
                                }
                                elseif(strtoupper($val)=='INT'){
                                    $query = $query.'format LIKE "INT"';
                                }
                                elseif(strtoupper($val)=='OTH'){
                                    $query = $query.'format LIKE "OTH"';
                                }
                                elseif(strtoupper($val)=='MON' || strtoupper($val)=='MONDAY'){
                                    $query = $query.'d1 LIKE "%M%"';
                                }
                                elseif(strtoupper($val)=='TUE'|| strtoupper($val)=='TUES'||strtoupper($val)=='TUESDAY'){
                                    $query = $query.'d1 LIKE "%T%"';
                                }
                                elseif(strtoupper($val)=='WED' || strtoupper($val)=='WEDNESDAY'){
                                    $query = $query.'d1 LIKE "%W%"';
                                }
                                elseif(strtoupper($val)=='THUR' || strtoupper($val)=='THURS' || strtoupper($val)=='THURSDAY'){
                                    $query = $query.'d1 LIKE "%R%"';
                                }
                                elseif(strtoupper($val)=='Fri' || strtoupper($val)=='Friday'){
                                    $query = $query.'d1 LIKE "%F%"';
                                }
                                else{
                                    $query = $query."CONCAT(IFNULL(courseID, ''), '', IFNULL(title, ''), '', IFNULL(units, ''), '', IFNULL(sp, ''), '', IFNULL(max, ''), '', IFNULL(enr, ''), '', IFNULL(avl, ''), '', IFNULL(wl, ''), '', IFNULL(gm, ''), '', IFNULL(yl, ''), '', IFNULL(pr, ''), '', IFNULL(fr, ''), '', IFNULL(la, ''), '', IFNULL(qa, ''), '', IFNULL(format, ''), '', IFNULL(d1, ''), '', IFNULL(time1, ''), '', IFNULL(d2, ''), '', IFNULL(time2, ''), '', IFNULL(loc, ''), '', IFNULL(instructor, ''), IFNULL(starttime1, ''), IFNULL(starttime2, '')) LIKE '%$search%'";
                                }
                            }
                            if(empty($query)){
                                $sql = 'SELECT * FROM schedule';
                                $result = $db->query($sql);
                            }
                            else{
                                $sql = "SELECT * FROM schedule WHERE $query";
                                $result = $db->query($sql);
                            }
                            $i = 0;?>
                            <div id = "accordion">
                            <?php while($row = $result->fetch_assoc()) { 
                                    $i++;?>
                                        <div class = "card mb-1 shadow-sm">
                                            <div class="container p-0 m-0 no-gutters">
                                                <div class="row p-0 m-0 no-gutters">
                                                    <div class="col p-0 m-0 no-gutters" style="width: 100%">
                                                        <button class = "card-header btn collapsed text-left" data-toggle = "collapse" data-target="#collapse<?=$i?>" aria-expanded="false" aria-controls="collapse<?=$i?>" style="width: 100%; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-style: none;">
                                                            <?php 
                                                                if($row['avl']>0){
                                                                    echo '<span class="badge badge-success mr-1"> </span>';
                                                                }
                                                                else{
                                                                    echo '<span class="badge badge-danger mr-1"> </span>';
                                                                }
                                                                echo '<b>'.$row['courseID'].' - '.$row['title'].'</b>  ';
                                                                if($row['gm']=='SU'){
                                                                    echo "<span class='badge badge-primary ml-1'>SU</span>";
                                                                }
                                                                elseif ($row['gm']=='NR'){
                                                                    echo "<span class='badge badge-primary ml-1'>NR</span>";
                                                                }
                                                                if($row['yl']==1){
                                                                    echo "<span class='badge badge-secondary ml-1'>YL</span>";
                                                                }
                                                                if($row['fr']==1){
                                                                    echo "<span class='badge badge-success ml-1'>FR</span>";
                                                                }
                                                                if($row['la']==1){
                                                                    echo "<span class='badge badge-danger ml-1'>LA</span>";
                                                                }
                                                                if($row['qa']==1){
                                                                    echo "<span class='badge badge-warning ml-1'>QA</span>";
                                                                }
                                                                if($row['format']=='CLS'){
                                                                    echo "<span class='badge badge-info ml-1'>CLS</span>";
                                                                }
                                                                elseif($row['format']=='INT'){
                                                                    echo "<span class='badge badge-info ml-1'>INT</span>";
                                                                }
                                                                elseif($row['format']=='OTH'){
                                                                    echo "<span class='badge badge-info ml-1'>OTH</span>";
                                                                }
                                                                if($row['xlist']!=''){
                                                                    echo '<span class="badge badge-dark ml-1">';
                                                                    echo $row['xlist'];
                                                                    echo '</span>';
                                                                } ?>
                                                            <p class="small mb-0">
                                                                <?php
                                                                    echo $row['d1'].' '.$row['time1'];
                                                                    if($row['d2']!=''){
                                                                        echo ' | '.$row['d2'].' '.$row['time2'];
                                                                    }
                                                                    if($row['instructor']!=''){
                                                                        echo ' | '.$row['instructor'];
                                                                    }
                                                                ?>
                                                            </p>
                                                        </button>
                                                    </div>
                                                    <div class="col-1 p-0 m-0 card-header btn collapsed text-left" style="border-top-left-radius: 0px; border-bottom-left-radius: 0px; border-style: none;">
                                                        <form method="post" class="m-0 p-0">
                                                            <button><span class="badge badge-dark mr-1" href="#" style="margin-top: 20px;"><input name="save<?=$row['courseID']?>" id="save<?=$row['courseID']?>" value="<?=$row['courseID']?>" type="hidden">+</span></button>
                                                            <input class = "m-0" type="hidden" placeholder ="Search" aria-label="Search" name="searchTerm" id="searchTerm" value="<?=$currentSearchTerm?>">
                                                            <?php 
                                                                $currentSearchTerm=$_POST['searchTerm'];
                                                                if (isset($_POST['save'.$row['courseID']])) {
                                                                    if(isset($_SESSION["username"])){
                                                                    $query = "SELECT * FROM users WHERE username='".$_SESSION['username']."'";
                                                                    $usersResult = $db->query($query);
                                                                    while($userRow = $usersResult->fetch_assoc()){
                                                                        if($userRow['cal1course1']==''){
                                                                            $saveEntry="UPDATE users SET cal1course1 = '".$row['courseID']."' WHERE username='".$_SESSION['username']."'";
                                                                        }
                                                                        elseif($userRow['cal1course2']==''){
                                                                            $saveEntry="UPDATE users SET cal1course2 = '".$row['courseID']."' WHERE username='".$_SESSION['username']."'";
                                                                        }
                                                                        elseif($userRow['cal1course3']==''){
                                                                            $saveEntry="UPDATE users SET cal1course3 = '".$row['courseID']."' WHERE username='".$_SESSION['username']."'";
                                                                        }
                                                                        elseif($userRow['cal1course4']==''){
                                                                            $saveEntry="UPDATE users SET cal1course4 = '".$row['courseID']."' WHERE username='".$_SESSION['username']."'";
                                                                        }
                                                                        elseif($userRow['cal1course5']==''){
                                                                            $saveEntry="UPDATE users SET cal1course5 = '".$row['courseID']."' WHERE username='".$_SESSION['username']."'";
                                                                        }
                                                                        elseif($userRow['cal1course6']==''){
                                                                            $saveEntry="UPDATE users SET cal1course6 = '".$row['courseID']."' WHERE username='".$_SESSION['username']."'";
                                                                        }
                                                                        else{
                                                                            $saveEntry="UPDATE users SET cal1course7 = '".$row['courseID']."' WHERE username='".$_SESSION['username']."'";
                                                                        }
                                                                    }
                                                                    if(isset($saveEntry)){
                                                                        if(!$db->query($saveEntry)) {
                                                                            echo $mysqli->error;               
                                                                        } 
                                                                    }
                                                                } else{ ?>
                                                                            <script type="text/javascript">
                                                                                alertModal("Please log in or sign up");
                                                                            </script>
                                                                    <?php }
                                                            } ?>
                                                        </form>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div id="collapse<?=$i?>" class="collapse" aria-labelledby="heading<?=$i?>" data-parent="#accordion">
                                                <div class = "card-body">
                                                    <?php foreach ($row as $k => $v){ 
                                                        if($v!='0' && $v!=''){
                                                            if($k=='sp'){
                                                                echo 'Special permission required | ';
                                                            }
                                                            elseif($k=='max'){
                                                                echo "Max = $v | ";
                                                            }
                                                            elseif($k=='enr'){
                                                                echo "Enrolled = $v";
                                                                if($row['wl']!=0){
                                                                    echo " | ";
                                                                }
                                                            }
                                                            elseif($k=='wl'){
                                                                echo "Waitlist = $v";
                                                            }
                                                            elseif($k=='description'){
                                                                echo "<br>$v";
                                                            }
                                                            #echo "$v | ";
                                                        }
                                                    }?>
                                                </div>
                                            </div>
                                        </div>
                                    
                            <?php } echo '</div>';
                            if ($i==0){ ?>
                            <p> No results found for <?php echo $_POST['searchTerm']?></p>
                            <?php } ?>
                <?php } } ?>
            </div>
            <div class="d-none d-sm-block col thing">
                <table class="mt-2 mb-2" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 7%; height: 20px;"></th>
                            <th style="width: 18.6%; height: 20px;">Mon</th>
                            <th style="width: 18.6%;">Tue</th>
                            <th style="width: 18.6%;">Wed</th>
                            <th style="width: 18.6%;">Thu</th>
                            <th style="width: 18.6%;">Fri</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="m-0"><p class="small m-0">0900</p></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="m-0"><p class="small m-0">1000</p></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="m-0"><p class="small m-0">1100</p></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="m-0"><p class="small m-0">1200</p></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="m-0"><p class="small m-0">1300</p></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="m-0"><p class="small m-0">1400</p></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="m-0"><p class="small m-0">1500</p></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="m-0"><p class="small m-0">1600</p></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="m-0"><p class="small m-0">1700</p></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                        <tr>
                            <td class="m-0"><p class="small m-0">1800</p></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="m-0"><p class="small m-0">1900</p></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="m-0"><p class="small m-0">2000</p></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="m-0"><p class="small m-0">2100</p></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="m-0"><p class="small m-0">2200</p></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <?php 
                    if(isset($_SESSION["username"])){
                    if (isset($_POST['del'])) {
                        $query = "SELECT * FROM users WHERE username='".$_SESSION['username']."'";
                        $usersResult = $db->query($query);
                        while($userRow = $usersResult->fetch_assoc()){
                            if($userRow['cal1course1']==$_POST['del']){
                                $delEntry="UPDATE users SET cal1course1 = NULL WHERE username='".$_SESSION['username']."'";
                            }
                            elseif($userRow['cal1course2']==$_POST['del']){
                                $delEntry="UPDATE users SET cal1course2 = NULL WHERE username='".$_SESSION['username']."'";
                            }
                            elseif($userRow['cal1course3']==$_POST['del']){
                                $delEntry="UPDATE users SET cal1course3 = NULL WHERE username='".$_SESSION['username']."'";
                            }
                            elseif($userRow['cal1course4']==$_POST['del']){
                                $delEntry="UPDATE users SET cal1course4 = NULL WHERE username='".$_SESSION['username']."'";
                            }
                            elseif($userRow['cal1course5']==$_POST['del']){
                                $delEntry="UPDATE users SET cal1course5 = NULL WHERE username='".$_SESSION['username']."'";
                            }
                            elseif($userRow['cal1course6']==$_POST['del']){
                                $delEntry="UPDATE users SET cal1course6 = NULL WHERE username='".$_SESSION['username']."'";
                            }
                            else{
                                $delEntry="UPDATE users SET cal1course7 = NULL WHERE username='".$_SESSION['username']."'";
                            }
                        }
                        if(!$db->query($delEntry)) {
                            echo $mysqli->error;               
                        } }
                    $sql = "SELECT * FROM users WHERE username LIKE '".$_SESSION['username']."'";
                    $courseList = $db->query($sql);
                    while($rowInUsers = $courseList->fetch_assoc()){
                        foreach ($rowInUsers as $k => $v){
                            if(($k=='cal1course1' || $k=='cal1course2' || $k=='cal1course3' || $k=='cal1course4' || $k=='cal1course5' || $k=='cal1course6' || $k=='cal1course7') && $v!=''){
                                $query="SELECT * FROM schedule WHERE courseID LIKE '$v'";
                                $course = $db->query($query);
                                while($row = $course->fetch_assoc()){?>
                                    <form method="post">
                                    <div class="desc<?=substr($k, 10)?> position-relative shadow-sm">
                                            <?php if(isset($_POST['searchTerm'])){
                                                    $currentSearchTerm=$_POST['searchTerm'];
                                                    }
                                                    else{
                                                        $currentSearchTerm="";
                                                    }?>
                                            <button class="badge badge-dark float-right mt-2 mr-1 align-middle" href="#"><input name="del" id="del" value="<?=$row['courseID']?>" type="hidden">x</button>
                                            <input class = "form-control mr-2 bd-highlight" type="hidden" placeholder ="Search" aria-label="Search" name="searchTerm" id="searchTerm" value="<?=$currentSearchTerm?>">
                                        </form>
                                        <?php echo '<b>'.$row['courseID'].' - '.$row['title'].'</b>';?>
                                        <p class="small mb-0">
                                            <?php echo $row['d1'].' '.$row['time1'];
                                                    if($row['d2']!=''){
                                                        echo ' | '.$row['d2'].' '.$row['time2'];
                                                    }
                                                    if($row['instructor']!=''){
                                                        echo ' | '.$row['instructor'];
                                                    }
                                                    echo ' ';?>
                                        </p>
                                    </div>
                                    <?php 
                                        for($x=0; $x<strlen($row['d1']); $x++){
                                            $day=$row['d1']{$x};
                                            if($day=='M'){ ?>
                                                <div class="d-flex box<?=substr($k, 10)?> position-absolute" style="left: 9%; height: <?php echo 39.267*$row['duration1']/60;?>px; top: <?php echo ($row['delt91']*40)+47?>px">
                                                    <p class="small m-0"><?php echo $row['courseID']?></p>
                                                </div>
                                            <?php }
                                            elseif($day=='T'){ ?>
                                                <div class="d-flex box<?=substr($k, 10)?> position-absolute" style="left: 27%; height: <?php echo 39.267*$row['duration1']/60;?>px; top: <?php echo ($row['delt91']*40)+47?>px">
                                                    <p class="small m-0"><?php echo $row['courseID']?></p>
                                                </div>
                                            <?php }
                                            elseif($day=='W'){ ?>
                                                <div class="d-flex box<?=substr($k, 10)?> position-absolute" style="left: 44.7%; height: <?php echo 39.267*$row['duration1']/60;?>px; top: <?php echo ($row['delt91']*40)+47?>px">
                                                    <p class="small m-0"><?php echo $row['courseID']?></p>
                                                </div>
                                            <?php }
                                            elseif($day=='R'){ ?>
                                                <div class="d-flex box<?=substr($k, 10)?> position-absolute" style="left: 62.5%; height: <?php echo 39.267*$row['duration1']/60;?>px; top: <?php echo ($row['delt91']*40)+47?>px">
                                                    <p class="small m-0"><?php echo $row['courseID']?></p>
                                                </div>
                                            <?php }
                                            else{ ?>
                                                <div class="d-flex box<?=substr($k, 10)?> position-absolute" style="left: 80.5%; height: <?php echo 39.267*$row['duration1']/60;?>px; top: <?php echo ($row['delt91']*40)+47?>px">
                                                    <p class="small m-0"><?php echo $row['courseID']?></p>
                                                </div>
                                            <?php }
                                        }
                                        for($x=0; $x<strlen($row['d2']); $x++){
                                            $day=$row['d2']{$x};
                                            if($day=='M'){ ?>
                                                <div class="d-flex box<?=substr($k, 10)?> position-absolute" style="left: 9%; height: <?php echo 39.267*$row['duration2']/60;?>px; top: <?php echo ($row['delt92']*40)+47?>px">
                                                    <p class="small m-0"><?php echo $row['courseID']?></p>
                                                </div>
                                            <?php }
                                            elseif($day=='T'){ ?>
                                                <div class="d-flex box<?=substr($k, 10)?> position-absolute" style="left: 27%; height: <?php echo 39.267*$row['duration2']/60;?>px; top: <?php echo ($row['delt92']*40)+47?>px">
                                                    <p class="small m-0"><?php echo $row['courseID']?></p>
                                                </div>
                                            <?php }
                                            elseif($day=='W'){ ?>
                                                <div class="d-flex box<?=substr($k, 10)?> position-absolute" style="left: 44.7%; height: <?php echo 39.267*$row['duration2']/60;?>px; top: <?php echo ($row['delt92']*40)+47?>px">
                                                    <p class="small m-0"><?php echo $row['courseID']?></p>
                                                </div>
                                            <?php }
                                            elseif($day=='R'){ ?>
                                                <div class="d-flex box<?=substr($k, 10)?> position-absolute" style="left: 62.5%; height: <?php echo 39.267*$row['duration2']/60;?>px; top: <?php echo ($row['delt92']*40)+47?>px">
                                                    <p class="small m-0"><?php echo $row['courseID']?></p>
                                                </div>
                                            <?php }
                                            else{ ?>
                                                <div class="d-flex box<?=substr($k, 10)?> position-absolute" style="left: 80.5%; height: <?php echo 39.267*$row['duration2']/60;?>px; top: <?php echo ($row['delt92']*40)+47?>px">
                                                    <p class="small m-0"><?php echo $row['courseID']?></p>
                                                </div>
                                            <?php }
                                        } 
                                } 
                            } 
                        }  
                    }
                }
                ?>
            </div>
        </div>
    </div>
    

<pre>
    <?php
        #if (isset($_POST['search'])) {
            print_r($_POST);
        #}
        echo "SELECT username FROM users WHERE username='".$_POST['usernameinput']."'";
    ?>

</pre>

</body>
</html>