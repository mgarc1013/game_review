<?php
    session_start(); 

    if(isset($_SESSION['logged_in'])) { 
        unset($_SESSION['logged_in']); 
    } 
     
    if(isset($_SESSION['logged_in_username'])) { 
        unset($_SESSION['logged_in_username']); 
    } 
     
    if(isset($_SESSION['logged_in_access_level'])) { 
        unset($_SESSION['logged_in_access_level']); 
    } 
     
    if(isset($_SESSION['logged_in_user_id'])) { 
        unset($_SESSION['logged_in_user_id']); 
    } 
     
    header("Location: login.php"); 
?>