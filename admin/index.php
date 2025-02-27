<?php include('partials/menu.php'); ?>

<!-- Main Content Section starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>DASHBOARD<h1>
        <br><br>
        <?php 
                 if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

        ?>
        <br><br>

        <div class="col-4 text-center">

            <?php 
                $sql = "SELECT * FROM tbl_category";
                //Execute QUery
                $res = mysqli_query($conn, $sql);
                //count rows
                $count = mysqli_num_rows($res);
            ?>

            <h1><?php echo $count; ?></h1>
            <br/>
            Categories
    </div>

    <div class="col-4 text-center">

           <?php 
                $sql2 = "SELECT * FROM tbl_food";
                //Execute QUery
                $res2 = mysqli_query($conn, $sql2);
                //count rows
                $count2 = mysqli_num_rows($res2);
            ?>

            <h1><?php echo $count2; ?></h1>
            <br/>
            Foods
    </div>

    <div class="col-4 text-center">

           <?php 
                $sql3 = "SELECT * FROM tbl_order";
                //Execute QUery
                $res3 = mysqli_query($conn, $sql3);
                //count rows
                $count3 = mysqli_num_rows($res3);
            ?>

            <h1><?php echo $count3; ?></h1>
            <br/>
            Total Orders
    </div>

    <div class="col-4 text-center">

            <?php 
                //Create Sl query to get toal revenue generated
                //Aggregate function in SQL
                $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";

                //Execute query
                $res4 = mysqli_query($conn, $sql4);

                //Get values 
                $row4 = mysqli_fetch_assoc($res4);

                //Total Revenue
                $total_reveneu = $row4['Total'];
            
            ?>        

            <h1><h1>$<?php echo $total_reveneu; ?> </h1>
            <br/>
            Revenue Generated
    </div>

    <div class="clearfix">
</div>

<!--Main Content Section Ends -->

<?php include('partials/footer.php'); ?>