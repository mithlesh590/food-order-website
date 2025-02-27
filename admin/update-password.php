<?php include('partials/menu.php'); ?>

<div class="main-content">
<div class="wrapper">
    <h1>Change Password</h1>
    <br><br>

    <?php 

        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
        }

        ?>


    <form action="" method="POST">

        <table clas="tbl-30">
            <tr>
            <td>Current Password:</td>
                <td>
                    <input type="password" name="current_password" placeholder="Current Password">
                </td>
            </tr>

            <tr>
                <td>New Password:</td>
                <td>
                    <input type="password" name="new_password" placeholder="New Password">
                </td>
            </tr>

            <tr>
                <td>Confirm Password:</td>
                <td>
                    <input type="password" name="confirm_password" placeholder="Confirm Password">
                </td>
            </tr>

            <tr>
                <td colspan="2">

                <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="change password" class="btn-secondary">
                </td>
            </tr>

                
      </table>


  </form>

</div>
</div>

<?php

        //Checking whether Submit Button is Clicked or not
        if(isset($_POST['submit']))
        {
                //echo "Clicked";

                //1. Get the Data from Form
                $id=$_POST['id'];
                $current_password=md5($_POST['current_password']);
                $new_passord=md5($_POST['new_password']);
                $confirm_password=md5($_POST['confirm_password']);


                //2. Checking whether User with current ID and Current Password Exists or Not
                $sql= "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

                //Execute the Query
                $res= mysqli_query($conn, $sql);
                if($res==true)
                {
                    //Checking whether Data ia Available or not
                    $count=mysqli_num_rows($res);

                    if($count==1)
                    {
                        //User Exista and Password can be Changed
                        //echo "User Found";

                        //Check whether New Password and Confirm Password match or not
                        if($new_passord==$confirm_password)
                        {
                            //Update the Password
                            $sql2 = "UPDATE tbl_admin SET
                                password = '$new_passord'
                                WHERE id=$id
                            ";

                            //Execute the Query
                            $res2 = mysqli_query($conn, $sql2);

                            //Check whether the Query Executed or not
                            if($res2==true)
                            {
                                //Display Success Message
                                //Redirect to Manage Admin page with Success Message
                                $_SESSION['change-pwd']="<div class='success'>Password Changed Successfully</div>";
                                //Redirect the User
                                header('location:' .SITEURL.'admin/manage-admin.php');
                            }
                            else{
                                //Display Error Message
                                //Redirect to Manage Admin page with Error Message
                                $_SESSION['change-pwd']="<div class='error'>Failed to Change Password</div>";
                                //Redirect the User
                                header('location:' .SITEURL.'admin/manage-admin.php');
                            }
                        }
                        else{
                            //Redirect to Manage Admin page with Error Message
                            $_SESSION['pwd-not-match']="<div class='error'>Password Did Not Match</div>";
                            //Redirect the User
                            header('location:' .SITEURL.'admin/manage-admin.php');
                        }

                    }
                    else{
                        //User Doesn't Exists Set Message and Redirect
                        $_SESSION['user-not-found']="<div class='error'>User Not Found</div>";
                        //Redirect the User
                        header('location:' .SITEURL.'admin/manage-admin.php');
                    }
                }

                //3. Check Whether New Password and Confirm Password Match or Not

                //4. Change Password if all above is true
        } 
        ?>


<?php include('partials/footer.php'); ?>