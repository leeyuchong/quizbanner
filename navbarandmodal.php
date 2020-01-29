    <!-- Log In/Sign up -->
    <form method="post">
        <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Log in/Sign up</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                        <div class="modal-body">
                            <input class = "form-control m-2 bd-highlight" type="text" placeholder ="Username" aria-label="Username" name="usernameinput" id="usernameinput">
                            <input class = "form-control m-2 bd-highlight" type="text" placeholder ="Password" aria-label="Password" name="passwordinput" id="passwordinput">
                            <p class="text-danger">NOTE: Your username and password are not encrypted and are stored as plain text on the server. Do not use passwords that you use elsewhere.</p>
                            <?php 
                                if(isset($_POST['searchTerm'])){
                                    $currentSearchTerm=$_POST['searchTerm'];
                                }
                                else{
                                    $currentSearchTerm="";
                                }
                            ?>
                            <input class = "form-control mr-2 bd-highlight" type="hidden" placeholder ="Search" aria-label="Search" name="searchTerm" id="searchTerm" value="<?=$currentSearchTerm?>">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="loginBtn" id="loginBtn" value="loginBtn" class="btn btn-primary">Log in</button>
                            <button type="submit" name="signUpBtn" id="signUpBtn" value="signUpBtn" class="btn btn-primary">Sign up</button>
                        </div>
                </div>
            </div>
        </div>
    </form>
    
    <div id="alert-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="alert-modal-title">Alert</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p id="error">Username/Password is incorrect. Please try again. </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="login-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Alert</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Please login/sign up to use the scheduler</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id ="help" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Help</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                        <div class="card p-0 mb-2">
                            <button class ="collapsed m-0 p-0" data-toggle = "collapse" data-target="#codes" aria-expanded="false" aria-controls="codes">
                                <div class="card-header text-left m-0">
                                    Search for terms using codes. Click for list of codes.
                                </div>
                            </button>
                            
                            <?php require 'help.php'; ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id ="about" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">About</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!--<img src="profile.jpg">-->
                    <p class="text-center">Jason Lee<br>Vassar College Class of 2022<br>Please send bugs or feature requests to: <a href="mailto:lyuchong@vassar.edu">lyuchong@vassar.edu</a></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>