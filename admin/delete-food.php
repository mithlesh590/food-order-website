<?php

    include('../config/constants.php');

    //echo "Delete Food Page";
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //1. Get Id and Image name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //2. Remove image if available
        if($image_name !="")
        {
            $path = "../images/food/".$image_name;

            $remove = unlink($path);

            if($remove==false)
            {
                $_SESSION['upload'] = "<div class='error'>Failed to Remove Image File</div>";

                header('location:'.SITEURL. 'admin/manage-food.php');

                die();
            }

        }

        //3. Delete from Db
        $sql = "DELETE FROM tbl_food WHERE id=$id";
        //Execute Query
        $res = mysqli_query($conn, $sql);

        if($res==true)
        {
            //Food Deleted
            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully</div>";
            header('location:'.SITEURL. 'admin/manage-food.php');
        }
        else{
            //Failed to Delete
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Food</div>";
            header('location:'.SITEURL. 'admin/manage-food.php');

        }


    }
    else{

        $_SESSION['unauthorize'] = "<div class='error>Unauthorized Access</div>";
        header('location:' .SITEURL. 'admin/manage-food.php');
    }

?>