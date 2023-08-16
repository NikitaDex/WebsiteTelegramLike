<?php
    session_start();
    error_reporting(0); 
    // $_SESSION['auth'] = null;
    session_destroy();


    header('Location: login.php'); 
?>