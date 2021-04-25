
<?php include('partials/menu.php'); ?>

<!-- Main content section starts-->
<div class="main-content">
    <div class="wrapper">
        <h2>Manage Order</h2>

        <br><br>

                <?php if(isset($_SESSION['update'])): ?>
                <div class="alert-success">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <strong>
                    <?php  echo $_SESSION['update']; ?>
                    </strong>
                </div>
                <?php endif; ?>
                <?php unset($_SESSION['update']); ?> 

                <?php
                    //Query to get all admin
                    $sql = "SELECT * FROM tbl_order ORDER BY order_date DESC";
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
                        <th>Food</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Order date</th>
                        <th>Status</th>
                        <th>Customer name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
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
                              $food = $rows['food'];
                              $price = $rows['price'];
                              $qty = $rows['qty'];
                              $total = $rows['total'];
                              $order_date = $rows['order_date'];
                              $status = $rows['status'];
                              $customer_name = $rows['customer_name'];
                              $customer_contact = $rows['customer_contact'];
                              $customer_email = $rows['customer_email'];
                              $customer_address = $rows['customer_address'];

                              //Display the values in our table
                    ?>

                    <tr>
                        <td> <?php echo $sn++; ?> </td>
                        <td> <?php echo $food; ?> </td>
                        <td> <?php echo $price; ?> </td>
                        <td> <?php echo $qty; ?> </td>
                        <td> <?php echo $total; ?> </td>
                        <td> <?php echo $order_date; ?> </td>

                        <td>
                            <?php
                                if($status=="Ordered")
                                {
                                    echo "<span>$status</span>";
                                }
                                elseif($status=="On_Delivery")
                                {
                                    echo "<span style='color:orange;'>$status</span>";
                                }
                                elseif($status=="Delivered")
                                {
                                    echo "<span style='color:green;'>$status</span>";
                                }
                                elseif($status=="Cancelled")
                                {
                                    echo "<span style='color:red;'>$status</span>";
                                }
                            ?>
                        </td>

                        <td> <?php echo $customer_name; ?> </td>
                        <td> <?php echo $customer_contact; ?> </td>
                        <td> <?php echo $customer_email; ?> </td>
                        <td> <?php echo $customer_address; ?> </td>
                        <td>
                        <a href="<?php echo SITEURL;?>admin/update-order.php?id=<?php echo $id;?>" class="btn-secondary">Update Order</a>
                        </td>
                    </tr> 

                    <?php 
                        }
                    }
                    else
                    {
                        // We dont have data in database
                        echo "<div class='error'>No orders found</div>";
                    }
                }
                    ?>
                </table> 


    </div>
</div>
<!-- Main content section ends-->

<?php include('partials/footer.php'); ?>  