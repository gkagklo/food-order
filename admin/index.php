
<?php include('partials/menu.php'); ?>

        <!-- Main content section starts-->
        <div class="main-content">
            <div class="wrapper">
                <h2>Dashboard</h2>

                <?php if(isset($_SESSION['login'])): ?>
                <div class="alert-success">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <strong>
                    <?php  echo $_SESSION['login']; ?>
                    </strong>
                </div>
                <?php endif; ?>
                <?php unset($_SESSION['login']); ?> 

                <?php
                    $sql = "SELECT * FROM tbl_category";
                    $res = mysqli_query($conn, $sql);
                    $count_categories = mysqli_num_rows($res);

                    $sql2 = "SELECT * FROM tbl_food";
                    $res2 = mysqli_query($conn, $sql2);
                    $count_foods = mysqli_num_rows($res2);

                    $sql3 = "SELECT * FROM tbl_order";
                    $res3 = mysqli_query($conn, $sql3);
                    $count_orders = mysqli_num_rows($res3);

                    $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered '";
                    $res4 = mysqli_query($conn, $sql4);
                    $row4 = mysqli_fetch_assoc($res4);
                    $total_revenue = $row4['Total'];
                ?>

                <div class="col-4 text-center">
                    <h1> <?php echo $count_categories; ?> </h1><br>
                    Categories
                </div>

                <div class="col-4 text-center">
                    <h1> <?php echo $count_foods; ?> </h1><br>
                    Foods
                </div>

                <div class="col-4 text-center">
                    <h1> <?php echo $count_orders; ?> </h1><br>
                    Orders
                </div>

                <div class="col-4 text-center">
                    <h1> $<?php echo $total_revenue; ?> </h1><br>
                    Revenue Generated
                </div>
       
                <div class="clearfix"></div>

            </div>
        </div>
        <!-- Main content section ends-->

<?php include('partials/footer.php'); ?>        