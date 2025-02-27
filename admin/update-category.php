<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>


        <?php

            //Check whether the id is set or not
            if(isset($_GET['id']))
            {
                //Get the id and all other details
                //echo "Getting data";
                $id = $_GET['id'];
                //Get Sql Query to get all other details
                $sql = "SELECT * FROM tbl_category WHERE id=$id";

                //Execute Query
                $res = mysqli_query($conn, $sql);

                //Count rows to check whether id is valid or not
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //GEt all data
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else{
                    //Redirect to manage category with session message
                    $_SESSION['no-category-found'] = "<div class='error'>Category Not Found</div>";
                    header('location:' .SITEURL.'admin/manage-category.php');
                }
            }
            else{
                //redirect to Manage Categoory
                header('location:' .SITEURL.'admin/manage-category.php');
            }
            ?>

        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">
            <tr>
                <td>Title:</td>
                <td>
                    <input type="text" name="title" value="<?php echo $title; ?>">

                </td>
            </tr>

            <tr>
                <td>Current Image:</td>
                <td>
                    <?php 
                        if($current_image !="")
                        {
                            //Display Image
                            ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                            <?php

                        }
                        else{
                            //Display Message
                            echo "<div class='error'>Image Not Added</div>";
                        }
                        ?>
                    
                        
                </td>
            </tr>
                 
            <tr>
                <td>New Image:</td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>

            <tr>
                <td>Featured:</td>
                <td>
                <input <?php if($featured=="Yes") { echo "checked"; } ?> type="radio" name="featured" value="Yes">Yes
                

                    <input <?php if($featured== "No") { echo "checked"; } ?> type="radio" name="featured" value="No">No
                </td>
            </tr>

            <tr>
                <td>Active:</td>
                <td>
                    <input <?php if($active== "Yes") { echo "checked"; } ?> type="radio" name="active" value="Yes">Yes

                    <input <?php if($active== "No") { echo "checked"; } ?> type="radio" name="active" value="No">No
                </td>
            </tr>

            <tr>
                <td>
                    <input type="hidden" name="currernt_name" value="<?php echo $current_image; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                </td>
            </tr>

        </table>
        </form>

        <?php

            if(isset($_POST['submit']))
            {
               // echo "Clicked";

               //1. Get all the value from Form
               $id = $_POST['id'];
               $title = $_POST['title'];
               $current_image = $_POST['current_image'];
               $featured = $_POST['featured'];
               $active = $_POST['active'];


               //2. Updating new image if selected 
               //Check whether image is selected or not
               if(isset($_FILES['image']['name']))
               {
                //Get the image Details
                $image_name = $_FILES['image']['name'];

                //Check whether image is availablke or not
                if($image_name !="")
                {
                        //image available
                        //A. Upload New image

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
                            header('location:'.SITEURL.'admin/manage-category.php');
                            //Stop the process
                            die();
                        }

                    //B. Remove Current image if available
                    if($current_image!="")
                    {
                        $remove_path = "../images/category/".$current_image;

                        $remove = unlink($remove_path);
    
                        //check whether the image is removed or not
                        //If failed to remove then display message and stop process
                        if($remove==false)
                        {
                            //Failed to remove image
                            $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Current Image</div>";
                            header('location:' .SITEURL. 'admin/manage-category.php');
                            die();//Stop process
                        }
                    }
                   
                }
                else{
                    $image_name = $current_image;
                }
               }
               else{
                $image_name = $current_image;
               }

               //3. update the db
               $sql2 = "UPDATE tbl_category SET
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id

               ";

               //Execute Query
               $res2 = mysqli_query($conn, $sql2);


               //4. Redirect to Manage Category with Message
               //4. check whether Query executed or not
               if($res2==true)
               {
                //Category updated
                $_SESSION['update'] = "<div class='success'>Category Updated Successfully</div>";
                header('location:' .SITEURL.'admin/manage-category.php');
               }
               else{
                //Failed to update Category
                $_SESSION['update'] = "<div class='error'>Failed to Upodate Category</div>";
                header('location:' .SITEURL.'admin/manage-category.php');

               }
            
               

            }

        ?>




    </div>
</div>


<?php include('partials/footer.php'); ?>