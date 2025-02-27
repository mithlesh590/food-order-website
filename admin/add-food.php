<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php 
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">

            <tr>
                <td>Title:</td>
                <td>
                    <input type="text" name="title" placeholder="Title of the Food">
                </td>
            </tr>

            <tr>
                <td>Description:</td>
                <td>
                    <textarea name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                </td>
            </tr>

            <tr>
                <td>Price:</td>
                <td>
                    <input type="number" name="price" >
                </td>
            </tr>

            <tr>
                <td>Select Image: </td>
                <td><input type="file" name="image"></td>
            </tr>

            <tr>
                <td>Category: </td>
                <td>
                    <select name="category" >


                    <?php
                        //Creat php code to display categories from Db
                        //1. First we need to create Sql to get all active categories from dv
                        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                        //Executing Query
                        $res = mysqli_query($conn, $sql);

                        //Count rows to check whether we have categories or not
                        $count = mysqli_num_rows($res);

                        //If count is greater than, we have categories else we dont have categories
                        if($count>0)
                        {
                            //We have categories
                            while($row=mysqli_fetch_assoc($res))
                            {
                                //Get Details of Categories
                                $id = $row['id'];
                                $title = $row['title'];
                                ?>

                                <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                <?php
                            }
                        }
                        else{
                            //we dont have categories
                            ?>
                            <option value="0">No Categories Found</option>
                            <?php
                        }
                        //2. Then we will display dropdown
                    
                    
                    ?>

                       
                    </select>
                </td>
            </tr>

            <tr>
                <td>Featured: </td>
                <td>
                    <input type="radio" name="featured" value="Yes">Yes
                    <input type="radio" name="featured" value="No">No
                </td>
            </tr>

            <tr>
                <td>Active: </td>
                <td>
                    <input type="radio" name="active" value="Yes">Yes
                    <input type="radio" name="active" value="No">No
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                </td>
            </tr>

        </table>
        </form>


        <?php
        
            //check whether button is clicked or not
            if(isset($_POST['submit']))
            {
                //Add food in db
                //echo "Clicked";

                //1. Get data from form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                //check whether radio button for featured and active are clicked or not
                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else{
                    $featured = "No";//Setting default values
                }

                if(isset($_POST['active'])){
                    $active = $_POST['active'];
                }
                else{
                        $active = "No"; // Setting default val
                    }
                

                //2. Upload the Image if selected
                //check whether select image is click or not and upload image only if image is selected
                if(isset($_FILES['image']['name']))
                {
                    //Get details of selected image 
                    $image_name = $_FILES['image']['name'];

                    //check whether image is selected or not and upload image only if selected
                    if($image_name!="")
                    {
                        //image is selected
                        //A. Rename Image
                        $ext = end(explode('.', $image_name));

                        //Create new name for image
                        $image_name = "Food-Name-".rand(0000, 9999).".".$ext; //New Image Name may be "Food-Name-657.jpg"

                        //B. Upload Image
                        //Get the Source path and dest path

                        //Source path is current location of imagr
                        $src=$_FILES['image']['tmp_name'];

                        //Destination path frr images to be uploaded
                        $dst="../images/food/".$image_name;

                        //Finally Upload Food image
                        $upload = move_uploaded_file($src, $dst);

                        //check whether image uploaded or not
                        if($upload==false)
                        {
                            //Failed to upload image
                            //Redirect to Add food page with error message
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                            header('location:'.SITEURL. 'admin/add-food.php');
                            //stop process
                            die();
                        }
                    }
                }
                else{
                    $image_name = ""; //Setting default value as blank
                }

                //3. Insert into db
                //create Sql Query to save or Add food
                $sql2 = "INSERT INTO tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name ='$image_name',
                    category_id = $category,
                    featured = '$featured',
                    active = '$active'
                
                ";

                //Execute Query
                $res2 = mysqli_query($conn, $sql2);

                //check whether data inserted or not 
                //4. Redirect with message to manage Food page

                if($res2==true)
                {
                    //Data inserted successfully
                    $_SESSION['add'] = "<div class='success'>Food Added Successfully</div>";
                    header('location:'.SITEURL. 'admin/manage-food.php');
                }
                else{
                    //Failed to insert data
                    $_SESSION['add'] = "<div class='error'>Failed to Add Food</div>";
                    header('location:'.SITEURL. 'admin/manage-food.php');
                }

                
            }
        
        
        
        ?>
    </div>

</div>



<?php include('partials/footer.php'); ?>

