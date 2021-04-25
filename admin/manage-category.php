
<?php include('partials/menu.php'); ?>

<!-- Main content section starts-->
<div class="main-content">
    <div class="wrapper">
        <h2>Manage Category</h2>
        <br><br>
                <!-- Button to add category -->
                <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>
                <br><br>

                <?php if(isset($_SESSION['add'])): ?>
                <div class="alert-success">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <strong>
                    <?php  echo $_SESSION['add']; ?>
                    </strong>
                </div>
                <?php endif; ?>
                <?php unset($_SESSION['add']); ?>   

                <?php if(isset($_SESSION['remove'])): ?>
                <div class="alert-danger">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <strong>
                    <?php  echo $_SESSION['remove']; ?>
                    </strong>
                </div>
                <?php endif; ?>
                <?php unset($_SESSION['remove']); ?> 

                <?php if(isset($_SESSION['delete'])): ?>
                <div class="alert-success">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <strong>
                    <?php  echo $_SESSION['delete']; ?>
                    </strong>
                </div>
                <?php endif; ?>
                <?php unset($_SESSION['delete']); ?> 

                <?php if(isset($_SESSION['no-category-found'])): ?>
                <div class="alert-danger">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <strong>
                    <?php  echo $_SESSION['no-category-found']; ?>
                    </strong>
                </div>
                <?php endif; ?>
                <?php unset($_SESSION['no-category-found']); ?> 

                <?php if(isset($_SESSION['update'])): ?>
                <div class="alert-success">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <strong>
                    <?php  echo $_SESSION['update']; ?>
                    </strong>
                </div>
                <?php endif; ?>
                <?php unset($_SESSION['update']); ?> 

                <?php if(isset($_SESSION['upload'])): ?>
                <div class="alert-danger">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <strong>
                    <?php  echo $_SESSION['upload']; ?>
                    </strong>
                </div>
                <?php endif; ?>
                <?php unset($_SESSION['upload']); ?> 
   
          
                    <?php
                    //Query to get all admin
                    $sql = "SELECT * FROM tbl_category";
                    //Execute the Query
                    $res = mysqli_query($conn,$sql);
                    //Check whether the query is executed or not
                    if($res==TRUE)
                    {
                        //Count rows to check whether we have data in database or not
                        $count = mysqli_num_rows($res); //Function to get all the rows in database

                        $sn = 1; //Create a variable and assign the value

                        //Check the num of rows
                        if($count > 0)
                        {
                        ?>

                            <table class="tbl-full">
                            <tr>
                                <th>S.N.</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Featured</th>
                                <th>Active</th>
                                <th>Actions</th>
                            </tr> 

                            <?php
                            //We have data in database
                            while($rows=mysqli_fetch_assoc($res))
                            {
                                //Using while loop to get all the data from database
                                //And while loop will run as long we have data in database

                                //Get individual data
                                $id = $rows['id'];
                                $title = $rows['title'];  
                                $image_name = $rows['image_name'];                         
                                $featured = $rows['featured'];
                                $active = $rows['active'];
                                //Display the values in our table
                                ?>

                                <tr>
                                    <td> <?php echo $sn++;?> </td>                                 
                                    <td> <?php echo $title;?> </td>
                                    <td>
                                        <?php
                                        if($image_name!="")
                                        {
                                        ?>
                                         <img src="<?php echo SITEURL;?>/images/category/<?php echo $image_name;?>" alt="" width="200" height="180">
                                        <?php
                                        }
                                        else
                                        {
                                            //Display error message
                                            echo "<div class='error'>Image not added.</div>";
                                        }
                                        ?>
                                    </td>  
                                    <td <?php if($featured == "Yes"): ?> style="color:green;" <?php else :?> style="color:red;" <?php endif; ?> > <?php echo $featured; ?></td>
                                    <td <?php if($active == "Yes"): ?> style="color:green;" <?php else :?> style="color:red;" <?php endif; ?> > <?php echo $active; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL;?>admin/update-category.php?id=<?php echo $id;?>" class="btn-secondary">Update Category</a>
                                        <a href="<?php echo SITEURL;?>admin/delete-category.php?id=<?php echo $id;?>&image_name=<?php echo $image_name;?>" class="btn-danger delete">Delete Category</a>
                                    </td>
                                </tr>  
                                 

                                <?php
                            }
                        }
                        else
                        {
                            // We dont have data in database
                            echo "<div class='error'>No categories found</div>";
                        }
                    }
                    ?>                               
        </table> 
    </div>
</div>
<!-- Main content section ends-->

<?php include('partials/footer.php'); ?>  

