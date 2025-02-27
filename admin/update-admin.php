<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br><br>

        <?php
            //1. Get the ID of Selected Admin
            $id=$_GET['id'];

            //2. Create SQL Query to Get the Details
            $sql="SELECT * FROM tbl_admin WHERE id=$id";

            //Execute the Query
            $res=mysqli_query($conn, $sql);

            //Check Whether the Query is Executed or not
            if($res==true)
            {
                //Check Whether data is available or not
                $count = mysqli_num_rows($res);
                //Check whether we have admin data or not
                if($count==1) 
                {
                    //We will Get the Details
                   // echo "Admin Available";
                   $row=mysqli_fetch_assoc($res);

                   $full_name = $row['full_name'];
                   $username = $row['username'];

                }
                else{
                    //We will Redirect to Manage Admin page
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }

            ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name::</td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>

                </tr>

                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" Value="<?php echo $username; ?>">
                    </td>

                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>

                </tr>

            </table>



        </form>

    </div>
</div>

<?php

        //Checking Whether the Submit Button is Clicked or not
        if(isset($_POST['submit']))
        {
           // echo "Button Clicked";
           //Get all the values from Form to Update
            $id = $_POST['id'];
            $full_name = $_POST['full_name'];
            $username = $_POST['username'];

            //Creating SQL Query to update Admin
            $sql = "UPDATE tbl_admin SET
            full_name = '$full_name',
            username = '$username' 
            WHERE id='$id'
            
            ";

            //Execute Query
            $res = mysqli_query($conn, $sql);

            //Checking whether Query executed successfully or not
            if($res==true)
            {
                //Query Executed and Admin Updated 
                $_SESSION['update'] = "<div class='success'>Admin Updated Successfully</div>";

                //Redirect to Manage Admin page
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
            else{
                //Failed to update Admin
                $_SESSION['update'] = "<div class='error'>Failed to Delete Admin</div>";

                //Redirect to Manage Admin page
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }

        ?>


<?php include('partials/footer.php'); ?>