<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category Page</h1>

        <br><br>

        <?php 
            if(isset($_SESSION['add'])) 
            {
                echo $_SESSION['add']; 
                unset($_SESSION['add']); 
            }

            if(isset($_SESSION['upload'])) 
            {
                echo $_SESSION['upload']; 
                unset($_SESSION['upload']); 
            }
        ?>

        <br><br>


        <!-- Add Category Form Starts -->
         <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">

                    </td>
                </tr>

                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
        
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category"  class="btn-secondary">
                    </td>
                </tr>

            </table>

         </form>
         <!-- Add Category Form Ends -->

         <?php

            //Check whether the saubmit is clicked oir not
            if(isset($_POST['submit']))
            {
                //echo "Clicked";

                //1. Get the value from Category Form
                $title = $_POST['title'];

                //For Radio input, we need to check whether the button is selected or not
                if(isset($_POST['featured']))
                {
                    //GEt the value from form
                    $featured = $_POST['featured'];
                }
                else{
                    //Set the Default value form
                    $featured = "No";
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else{
                    $active = "No";
                }

                //Check whether the image is selected or not ans set value for image name 
                //print_r($_FILES['image']);

                //die(); //Break the code here

                if(isset($_FILES['image']['name']))
                {
                    //Upload the image
                    //To upload the image we need image name and source oath and destination path
                    $image_name = $_FILES['image']['name'];

                    //Upload the Image only if image is selected
                    if($image_name !="")
                    {

                    

                        //Auto rename our image
                        //Get the extension of our image
                        $ext = end(explode('.', $image_name));

                        //Rename the image
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext; // e.g. Food_Category_834.jpg



                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/category/".$image_name;

                        //Finally Upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //Chech whether the image is uploaded or not
                        //if the image is not uploaded then we will stop the process and redirect with error messsge
                        if($upload==false)
                        {
                            //we will set message
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                            //Redirect to Add Category page
                            header('location:'.SITEURL.'admin/add-category.php');
                            //Stop the process
                            die();
                        }
                    }
                }
                else{
                    //We dont upload the image and setimage_name value blank
                    $image_name = "";
                }

                //2. Create SQL Query to insert Category into Database
                $sql = "INSERT INTO tbl_category SET
                title ='$title',
                image_name = '$image_name',
                featured = '$featured',
                active = '$active'
                ";

                //3. Execute the Query and save in Database
                $res = mysqli_query($conn, $sql);

                //4. Check whether the Query is executed or not and data added  or not
                if($res==true)
                {
                    //Query executed and Categopry added 
                    $_SESSION['add'] = "<div class='success'>Category Added Successfully</div>";
                    //Redirect to manage Category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else{
                    //Failed to add Category
                    $_SESSION['add'] = "<div class='error'>Failed to Add Category</div>";
                    //Redirect to manage Category page
                    header('location:'.SITEURL.'admin/add-category.php');
                }
            }

        ?>



    </div>
</div>

<?php include('partials/footer.php'); ?>
