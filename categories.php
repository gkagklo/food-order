<?php include('partials-front/menu.php'); ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>
            <?php
                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                    if($count > 0)
                    {
                        while($rows=mysqli_fetch_assoc($res))
                        {
                            $id = $rows['id'];
                            $title = $rows['title'];
                            $image_name = $rows['image_name'];
                            ?>
                                <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id;?>">
                                    <div class="box-3 float-container">
                                        <?php
                                        if($image_name == "")
                                        {
                                            //Image not available
                                            echo "<div class='error text-center'>Image not found</div>";
                                        }
                                        else
                                        {
                                            //Image available
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="" class="img-responsive img-curve">
                                        <?php
                                        }
                                        ?>
                                        <h3 class="float-text text-white"><?php echo $title; ?></h3>
                                    </div>
                                </a>
                            <?php
                        }
                    }
                    else
                    {
                        // We dont have data in database
                        echo "<div class='error text-center'>Categories not found</div>";
                    }      
            ?>


            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

<?php include('partials-front/footer.php'); ?>