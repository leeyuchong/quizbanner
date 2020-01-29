<?php require 'head.php';
    ?>
    <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
        <span class="navbar-brand mb-0">Spring 2020</span>
        <br>
        <button class ="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav mr-auto">
                <a class="d-block d-md-none nav-item nav-link" href="#">Search</a>
                <a class="d-block d-md-none nav-item nav-link active" href="scheduler.php">Scheduler<span class="sr-only">(current)</span></a>
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

<body>
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
</body>