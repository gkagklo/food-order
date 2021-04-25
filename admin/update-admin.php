<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h2>Update Admin</h2>
        <br><br>
        <?php
        //1. Get the id of selected admin
        $id = $_GET['id'];

        //2. Create sql query to get the details
        $sql = "SELECT * FROM tbl_admin WHERE id=$id";

        $res = mysqli_query($conn,$sql);

        if($res==true)
        {
            $count = mysqli_num_rows($res);
            if($count==1)
            {
                //Get the details
               //echo "Admin Available";
                $row=mysqli_fetch_assoc($res);
                $full_name = $row['full_name'];
                $username = $row['username'];
            }
            else
            {
                //Redirect to manage admin page
                header("location:".SITEURL.'admin/manage-admin.php');
            }
        }
        ?>

        <form name="updateadmin" action="" method="POST" onsubmit="return validate()">

            <div class="row">
                <div class="col-25">
                    <label>Full Name: </label>
                </div>
                <div class="col-75">
                    <input type="text" name="full_name" value="<?php echo $full_name; ?>" placeholder="Enter your name">
                    <span id="full_name_error" style="color:red;"></span>
                </div>
            </div>

            <div class="row">
                <div class="col-25">
                    <label>Username: </label>
                </div>
                <div class="col-75">
                <input type="text" name="username" value="<?php echo $username; ?>" placeholder="Enter your username">
                <span id="username_error" style="color:red;"></span>
                </div>
            </div>
            <br>
            <div class="row">
                <input type="hidden" name="id" value="<?php echo $id;?>">
                <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
            </div>            

        </form>
    </div>
</div>

<?php 
    //Check whether the submit button is clicked or not
    if(isset($_POST['submit'])){
       // echo "Button is clicked";    
       // Get all the values from form to update
       $id = $_POST['id'];
       $full_name = $_POST['full_name'];
       $username = $_POST['username'];

       //Create sql query to update admin
       $sql = "UPDATE tbl_admin SET
       full_name = '$full_name',
       username = '$username'
       WHERE id = '$id'
       ";

       //Execute the query
       $res = mysqli_query($conn,$sql);

       if($res==true)
       {
            //Query executed and admin updated
            $_SESSION['update'] = "Admin has been updated successfully";
            header("location:".SITEURL.'admin/manage-admin.php');
       }
       else
       {
           //Failed to update admin
           $_SESSION['update'] = "Failed to update admin";
           header("location:".SITEURL.'admin/manage-admin.php');
       }
    }
?>


<?php include('partials/footer.php'); ?> 


<script>
function validate(){
    var full_name=document.updateadmin.full_name.value;
    var username=document.updateadmin.username.value;
    var status=true; 

    if(full_name==""){ 
        document.getElementById("full_name_error").innerHTML= "Full name is required";  
        status=false;
    }
    else{
        var regex = /^[a-zA-Z\s]+$/; 
        if(regex.test(full_name) === false) {   
        document.getElementById("full_name_error").innerHTML= "Please enter a valid name";  
        status=false;
        }
    else{
        document.getElementById("full_name_error").innerHTML= ""; 
        }
    }

    if(username==""){ 
        document.getElementById("username_error").innerHTML= "Username is required";  
        status=false;
    }
    else if((username.length <= 3) || (username.length > 20 )){
        document.getElementById("username_error").innerHTML= "Username length must be between 3 and 20 characters";  
        status=false;
    }
    else{
        document.getElementById("username_error").innerHTML= ""; 
    }
  
    return status;  

}
</script>