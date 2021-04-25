<?php include('../config/constants.php'); ?>
<html>
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        <div class="login">
            <h2 class="text-center">Login</h2>
            <br>

            <?php if(isset($_SESSION['login'])): ?>
                <div class="alert-danger">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <strong>
                    <?php  echo $_SESSION['login']; ?>
                    </strong>
                </div>
                <?php endif; ?>
            <?php unset($_SESSION['login']); ?> 

            <?php if(isset($_SESSION['no-login-message'])): ?>
                <div class="alert-danger">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <strong>
                    <?php  echo $_SESSION['no-login-message']; ?>
                    </strong>
                </div>
                <?php endif; ?>
            <?php unset($_SESSION['no-login-message']); ?> 

            <form action="" method="POST">
                <label>Username: </label>
                <input type="text" name="username" placeholder="Enter your username">
                <label>Password: </label>
                <input type="password" name="password" placeholder="Enter your password">
                <br><br>
                <input type="submit" name="submit" value="Login" class="btn-primary">
            </form>
        </div>
    </body>
</html>

<?php

    //Check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //Get data from login form
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        //2. Sql to check whether the user with username and password exists or not.
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //3. Execute the query
        $res = mysqli_query($conn,$sql);    

        //4. Count rows to check whether the user exists or not
        $count = mysqli_num_rows($res);

        if($count==1)
        {
            //User Available and login success
            $_SESSION['login'] = "Login Successful.";
            $_SESSION['user'] = $username;
            //Redirect to home page/dashboard
            header("location:".SITEURL.'admin/');
        }
        else
        {
            //User not available and login fail
            //User Available and login success
            $_SESSION['login'] = "Username or Password did not match.";
            //Redirect to home page/dashboard
            header("location:".SITEURL.'admin/login.php');
        }
    }

?>