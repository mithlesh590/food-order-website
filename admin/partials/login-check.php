<?php

    //Authorization or Access COntrol
    //Check whether user is logged in or not 
    if(!isset($_SESSION['user'])) //If user session is not set
    {
        //User is not logged in
        //Redirect to login page with message
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please Login to access Admin Panel</div>";
        //Redirect to login page
        header('location:'.SITEURL.'admin/login.php');

    }

?>