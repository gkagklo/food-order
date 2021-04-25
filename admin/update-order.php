<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
    <h2>Update Order</h2>
    <br><br>

    <?php
        //Check whether the id is set or not
        if(isset($_GET['id']))
        {
            //Get the id and all other details
            //echo "Getting the data";
            $id = $_GET['id'];
            //Create sql query to get all other details
            $sql = "SELECT * FROM tbl_order WHERE id=$id";
            //Execute the query
            $res = mysqli_query($conn,$sql);
            //Count the rows to check whether the id is valid or not
            $count = mysqli_num_rows($res);
            if($count==1)
            {
                $row=mysqli_fetch_assoc($res);
                $food = $row['food'];
                $price = $row['price'];
                $qty = $row['qty'];
                $total = $row['total'];
                $order_date = $row['order_date'];
                $status = $row['status'];
                $customer_name = $row['customer_name'];
                $customer_contact = $row['customer_contact'];
                $customer_email = $row['customer_email'];
                $customer_address = $row['customer_address'];
            }
            else
            {
                //Redirect to manage order with message
                $_SESSION['no-order-found'] = "Order not found";
                header("location:".SITEURL.'admin/manage-order.php');
            }
        }
        else
        {
            //Redirect to manage order
            header("location:".SITEURL.'admin/manage-order.php');
        }
    ?>

    <form action="" method="POST">
    
    <div class="row">
        <div class="col-25">
            <label>Food: </label>
        </div>
        <div class="col-75">
            <strong><?php echo $food; ?></strong>
        </div>
    </div>

    <div class="row">
        <div class="col-25">
            <label>Price: </label>
        </div>
        <div class="col-75">
            <strong>$<?php echo $price; ?></strong>
        </div>
    </div>

    <div class="row">
        <div class="col-25">
            <label>Qty: </label>
        </div>
        <div class="col-75">
            <input type="number" name="qty" placeholder="Enter quantity" value="<?php echo $qty; ?>">
        </div>
    </div>

    <div class="row">
        <div class="col-25">
            <label>Status: </label>
        </div>
        <div class="col-75">
            <select name="status">
                <option value="Ordered" <?php if($status=='Ordered') {echo "selected";} ?> >Ordered</option>
                <option value="On_Delivery" <?php if($status=='On_Delivery') {echo "selected";} ?> >On_Delivery</option>
                <option value="Delivered" <?php if($status=='Delivered') {echo "selected";} ?> >Delivered</option>
                <option value="Cancelled" <?php if($status=='Cancelled') {echo "selected";} ?> >Cancelled</option>
            </select>

        </div>
    </div>

    
    <div class="row">
        <div class="col-25">
            <label>Customer Name: </label>
        </div>
        <div class="col-75">
            <input type="text" name="customer_name" placeholder="Enter name" value="<?php echo $customer_name; ?>">
        </div>
    </div>

    <div class="row">
        <div class="col-25">
            <label>Phone: </label>
        </div>
        <div class="col-75">
            <input type="text" name="customer_contact" placeholder="Enter contact" value="<?php echo $customer_contact; ?>">
        </div>
    </div>
    
    <div class="row">
        <div class="col-25">
            <label>Email: </label>
        </div>
        <div class="col-75">
            <input type="text" name="customer_email" placeholder="Enter email" value="<?php echo $customer_email; ?>">
        </div>
    </div>

    <div class="row">
        <div class="col-25">
            <label>Address: </label>
        </div>
        <div class="col-75">
            <input type="text" name="customer_address" placeholder="Enter address" value="<?php echo $customer_address; ?>">
        </div>
    </div>


    <div class="row">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="price" value="<?php echo $price; ?>">
        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
    </div>

    </form>

    <?php 
    //Check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
       // echo "Button is clicked";    
       // Get all the values from form to update
       $id = $_POST['id'];
       $price = $_POST['price'];
       $qty = $_POST['qty'];
       $total = $price * $qty;
       $status = $_POST['status'];
       $customer_name = $_POST['customer_name'];
       $customer_contact = $_POST['customer_contact'];
       $customer_email = $_POST['customer_email'];
       $customer_address = $_POST['customer_address'];
  
       //Create sql query to update order
       $sql2 = "UPDATE tbl_order SET
       qty = '$qty',
       total = '$total',
       status = '$status',
       customer_name = '$customer_name',
       customer_contact = '$customer_contact',
       customer_email = '$customer_email',
       customer_address = '$customer_address'
       WHERE id = '$id'
       ";

       //Execute the query
       $res2 = mysqli_query($conn,$sql2);

       if($res2==true)
       {
            //Query executed and order updated
            $_SESSION['update'] = "Order has been updated successfully";
            header("location:".SITEURL.'admin/manage-order.php');
       }
       else
       {
           //Failed to update order
           $_SESSION['update'] = "Failed to update order";
           header("location:".SITEURL.'admin/manage-order.php');
       }
    }
?>

    </div>
</div>

<?php include('partials/footer.php'); ?> 

