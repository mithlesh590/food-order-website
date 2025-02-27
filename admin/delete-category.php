<?php
    //Include Constants File
    include('../config/constants.php');


    //echo "Delete Page";
    //we will check whether the id and image_name value is set or not
    if(isset($_GET['id'])AND isset($_GET['image_name']))
    {
        // we will Get value and Delete
        //echo "GEt value and Delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove Physical image file is available
        if($image_name!="")
        {
            //Image is available, so we will remove it
            $path = "../images/category/".$image_name;
            //Remove the Image
            $remove = unlink($path);

            //If failed to remove image then add an error message and stop process
            if($remove==false)
            {
                //Set Session Message
                $_SESSION['remove']= "<div class='error'>Failed to Remove Category Image</div>";
                //Redirect to Manage Category page
                header('location:' .SITEURL.'admin/manage-category.php');
                //We will stop process
                die();

            }
        }

        //Delete Data from Database
        //ql Query to Delete data from Database
        $sql = "DELETE FROM tbl_category WHERE id=$id";

        //Execute Query
        $res = mysqli_query($conn, $sql);

        //Check whether data is delete from db or not
        if($res==true)
        {
            //Set Success message and Redirect
            $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully</div>";
            //Redirect to Manage Caregory
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else{
            //Set Fail message and Redirect
            $_SESSION['delete'] = "<div class='error'>CFailed to Delete Category</div>";
            //Redirect to Manage Caregory
            header('location:'.SITEURL.'admin/manage-category.php');
        }

        
    }
    else{
        //Redirect to Manage Category Page
        header('location:' .SITEURL.'admin/manage-category.php');

    }

?>