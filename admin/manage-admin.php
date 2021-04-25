
<?php include('partials/menu.php'); ?>

        <!-- Main content section starts-->
        <div class="main-content">
            <div class="wrapper">
                <h2>Manage Admin</h2>

                <?php if(isset($_SESSION['add'])): ?>
                <div class="alert-success">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <strong>
                    <?php  echo $_SESSION['add']; ?>
                    </strong>
                </div>
                <?php endif; ?>
                <?php unset($_SESSION['add']); ?>  

                <?php if(isset($_SESSION['delete'])): ?>
                <div class="alert-success">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <strong>
                    <?php  echo $_SESSION['delete']; ?>
                    </strong>
                </div>
                <?php endif; ?>
                <?php unset($_SESSION['delete']); ?>  

                <?php if(isset($_SESSION['update'])): ?>
                <div class="alert-success">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <strong>
                    <?php  echo $_SESSION['update']; ?>
                    </strong>
                </div>
                <?php endif; ?>
                <?php unset($_SESSION['update']); ?> 

                <?php if(isset($_SESSION['user-not-found'])): ?>
                <div class="alert-danger">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <strong>
                    <?php  echo $_SESSION['user-not-found']; ?>
                    </strong>
                </div>
                <?php endif; ?>
                <?php unset($_SESSION['user-not-found']); ?> 

                <?php if(isset($_SESSION['pwd-not-match'])): ?>
                <div class="alert-danger">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <strong>
                    <?php  echo $_SESSION['pwd-not-match']; ?>
                    </strong>
                </div>
                <?php endif; ?>
                <?php unset($_SESSION['pwd-not-match']); ?> 

                <?php if(isset($_SESSION['change-pwd'])): ?>
                <div class="alert-success">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <strong>
                    <?php  echo $_SESSION['change-pwd']; ?>
                    </strong>
                </div>
                <?php endif; ?>
                <?php unset($_SESSION['change-pwd']); ?> 

                <br><br>
                <!-- Button to add admin -->
                <a href="add-admin.php" class="btn-primary">Add Admin</a>
                <br><br>
                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>  
                    <?php
                    //Query to get all admin
                    $sql = "SELECT * FROM tbl_admin";
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
                            //We have data in database
                            while($rows=mysqli_fetch_assoc($res))
                            {
                                //Using while loop to get all the data from database
                                //And while loop will run as long we have data in database

                                //Get individual data
                                $id = $rows['id'];
                                $full_name = $rows['full_name'];
                                $username = $rows['username'];

                                //Display the values in our table
                                ?>

                                <tr>
                                    <td> <?php echo $sn++;?> </td>
                                    <td> <?php echo $full_name;?> </td>
                                    <td> <?php echo $username;?> </td>
                                    <td>
                                        <a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id;?>" class="btn-primary">Change Password</a>
                                        <a href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id;?>" class="btn-secondary">Update Admin</a>
                                        <a href="<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id;?>" class="btn-danger delete">Delete Admin</a>
                                    </td>
                                </tr>   

                                <?php
                            }
                        }
                        else
                        {
                            // We dont have data in database
                        }
                    }
                    ?>   
                </table>    


            </div>
        </div>
        <!-- Main content section ends-->
        
<?php include('partials/footer.php'); ?>  



