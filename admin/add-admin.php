
<?php include('partials/menu.php'); ?>


<!-- Main content section starts-->
<div class="main-content">
    <div class="wrapper">
       <h2>Add Admin</h2>
       <?php if(isset($_SESSION['add'])): ?>
                <div class="alert-danger">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <strong>
                    <?php  echo $_SESSION['add']; ?>
                    </strong>
                </div>
                <?php endif; ?>
        <?php unset($_SESSION['add']); ?>  
       <br><br>
        <form name="addadmin" action="" method="POST" onsubmit="return validate()">
            <div class="row">
                <div class="col-25">
                    <label>Full Name: </label>
                </div>
                <div class="col-75">
                    <input type="text" name="full_name" placeholder="Enter your name">          
                    <span id="full_name_error" style="color:red;"></span>
                </div>      
            </div>

            <div class="row">
                <div class="col-25">
                    <label>Username: </label>
                </div>
                <div class="col-75">
                    <input type="text" name="username" placeholder="Enter your username">
                    <span id="username_error" style="color:red"></span>
                </div>
            </div>

            <div class="row">
                <div class="col-25">
                    <label>Password: </label>
                </div>
                <div class="col-75">
                    <input type="password" name="password" placeholder="Enter your password">
                    <span id="password_error" style="color:red"></span>
                </div>
            </div>
            <br>
            <div class="row">
                <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
            </div>


           
        </form>
    </div>
</div>
<!-- Main content section ends-->



<?php include('partials/footer.php'); ?> 

<?php
    //Process the Value from Form and Save it in database
    //Check whether the submit button is clicked or not

    

    if(isset($_POST['submit'])){
    
        //Button Clicked
        // echo "Button Clicked";

        //1. Get the Data from form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //Password encryption with md5

        //2. SQL Query to Save the data into database
        $sql = "INSERT INTO tbl_admin SET
        full_name='$full_name',
        username='$username',
        password='$password'
        ";

        //3. Execute query and save data into database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        //4. Check whether the (query is executed) data is inserted or not and display appropriate message.
        if($res==TRUE){
            //Data inserted
            //echo "Data inserted";
            //Create a session variable to display a message
            $_SESSION['add'] = "Admin has been added successfully";
            //Redirect Page to Manage admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else{
            //Failed to insert data
            //echo "Failed to insert data";
            //Create a session variable to display a message
            $_SESSION['add'] = "Failed to add admin";
            //Redirect Page to Manage admin
            header("location:".SITEURL.'admin/add-admin.php');
        } 


    }

?>

<script>
function validate(){
    var full_name=document.addadmin.full_name.value;
    var username=document.addadmin.username.value;
    var password=document.addadmin.password.value;
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
  
 
    if(password==""){ 
        document.getElementById("password_error").innerHTML= "Password is required";  
        status=false;
    }
    else if((password.length <= 5) || (password.length > 20 )){
        document.getElementById("password_error").innerHTML= "Password length must be between 5 and 20 characters";  
        status=false;
    }
    else{
        document.getElementById("password_error").innerHTML= ""; 
    }

    return status;  


}
</script>