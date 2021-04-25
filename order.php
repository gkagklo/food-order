<?php include('partials-front/menu.php'); ?>

<?php
    if(isset($_GET['food_id']))
    {
        $food_id = $_GET['food_id'];
        $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
        $res = mysqli_query($conn, $sql);
        if($res==true)
        {
            $count = mysqli_num_rows($res);
            if($count==1)
            {
                //Get the details of food
                $row=mysqli_fetch_assoc($res);
                $title = $row['title'];
                $price = $row['price'];
                $description = $row['description'];
                $image_name = $row['image_name'];
            }
            else
            {
                //Redirect to home page
                header("location:".SITEURL);
            }
        }
        else
        {
            //Redirect to home page
            header("location:".SITEURL);
        }
    }
    else
    {
         //Redirect to home page
         header("location:".SITEURL);
    }

?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>
            
            <form name="order" action="" method="POST" class="order" onsubmit="return validate()">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php 
                            if($image_name=="")
                            {
                                echo "<div class='error'>Image not available</div>";
                            }
                            else
                            {
                                ?>
                                <img src="<?php echo SITEURL;?>/images/food/<?php echo $image_name; ?>" alt="" class="img-responsive img-curve">
                                <?php
                            }
                        ?>
                       
                    </div>
    
                    <div class="food-menu-desc">
                        <h3> <?php echo $title; ?> </h3>
                        <p class="food-price">$<?php echo $price; ?></p>
                        <p class="food-description"> <?php echo $description; ?> </p>
                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" min=1  required >
                        <br><br>
                    </div>
                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="Enter your name" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="Enter your phone number" class="input-responsive" required>
                    <span id="contact_error" style="color:red;"></span>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="Enter your email" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="Enter your home address" class="input-responsive" required></textarea>
                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

<?php include('partials-front/footer.php'); ?>

<?php

    if(isset($_POST['submit'])){
    
        //Button Clicked
        // echo "Button Clicked";

        //1. Get the Data from form
        $qty = $_POST['qty'];
        $customer_name = $_POST['full-name'];
        $customer_contact = $_POST['contact'];
        $customer_email = $_POST['email'];
        $customer_address = $_POST['address'];
        $total = $price * $qty;
        $order_date = date("Y-m-d h:i");
        $status = "Ordered";

        //2. SQL Query to Save the data into database
        $sql2 = "INSERT INTO tbl_order SET
        food='$title',
        price='$price',
        qty='$qty',
        total='$total',
        order_date='$order_date',
        status='$status',
        customer_name='$customer_name',
        customer_contact='$customer_contact',
        customer_email='$customer_email',
        customer_address='$customer_address'
        ";

        //3. Execute query and save data into database
        $res2 = mysqli_query($conn, $sql2) or die(mysqli_error());

        //4. Check whether the (query is executed) data is inserted or not and display appropriate message.
        if($res==TRUE){
            //Data inserted
            //echo "Data inserted";
            //Create a session variable to display a message
            $_SESSION['order'] = "<div class='success text-center'>Order completed successfully</div>";
            //Redirect home page
            header("location:".SITEURL);
        }
        else{
            //Failed to insert data
            //echo "Failed to insert data";
            //Create a session variable to display a message
            $_SESSION['order'] = "<div class='error text-center'>Your order failed</div>";
            //Redirect home page
            header("location:".SITEURL);
        } 


    }

?>

<script>
function validate(){
    var contact=document.order.contact.value;
    var status=true; 

    if(isNaN(contact)){ 
        document.getElementById("contact_error").innerHTML= "Mobile number not valid";  
        status=false;
    }
    else if(contact.length!=10){
        document.getElementById("contact_error").innerHTML= "Mobile number must be 10 digits"; 
        status=false; 
    }
    else{
        document.getElementById("full_name_error").innerHTML= ""; 
        }

    return status;  

}
</script>

