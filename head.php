<?php
    #ini_set('display_errors','0');
    $message = '';
    $bootstrapColors=array("primary", "secondary", "success", "danger","warning","info","dark");
    #$GLOBALS['username']='';
    #session_start();
    #$_SESSION["username"];
    $db = new mysqli('localhost:3306', 'lyc', '90034606', 'scheduleOfClasses');
    if ($db->connect_error){
        $message = $db->connect_error;
    }
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Spring 2020</title>
    <link href="./css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="style.php" rel="stylesheet" type="text/css">
    <script src = "./js/jQuery.js" type = "text/javascript"></script>
    <script type="text/javascript">
        function alertModal(text) {
            $(document).ready(function(){
                    $("#error").html(text);
                    $('#alert-modal').modal("show");
                    });
                };
    </script>
    <script src = "./js/bootstrap.bundle.min.js" type = "text/javascript"></script>

</head>