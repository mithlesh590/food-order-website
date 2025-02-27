<?php include('../config/constants.php'); ?>

<html>
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        
        <div class="login">
            <h1 class="text-center">Login</h1>
            <br><br>

            <?php 
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if(isset($_SESSION['no-login-message'] ))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }

            ?>
            <br><br>

            <!-- LOgin Form Starts from Here -->
             <form action="" method="POST" class="text-center">
            Username: <br>
            <input type="text" name="username" placeholder="Enter Username"><br><br>


            password: <br>
            <input type="password" name="password" placeholder="Enter Password"><br><br>


            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br><br>
             </form>
             <!-- LOgin Form Ends from Here -->

            <p class="text-center">Created By - <a href="www.facebook.com/">facebook</a></p>
        </div>


    </body>
</html>

<?php

    //Check whether Submit Button is Clicked or Not
    if(isset($_POST['submit']))
    {
        //We will Process for Login
        //1. Get the Data from Login Form
         $username = $_POST['username'];
         $password = md5($_POST['password']);

         //2. SQl to Check whetheruser with username and password exist or not
         $sql = "SELECT* FROM tbl_admin WHERE username='$username' AND password='$password'";

         //3. Execute the Query
         $res = mysqli_query($conn, $sql);

         //4. Count rows to check whether the user exist or not
         $count = mysqli_num_rows($res);

         if($count==1)
         {
            //User Available and Login Success
            $_SESSION['login'] ="<div class='success'>Login Successfull</div>";
            $_SESSION['user'] = $username;//To Check whether the user is Logged in or not and logout will unset it


            //Redirect to Home Page/Dashboard
            header('location:'.SITEURL.'admin/');
         }
         else{
            //User not Available and Login Fail
            $_SESSION['login'] ="<div class='error text-center'>Username or Password did not match</div>";
            //Redirect to Home Page/Dashboard
            header('location:'.SITEURL.'admin/login.php');
         }
    }

 ?>