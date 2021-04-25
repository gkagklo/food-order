<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h2>Update Password</h2>
        <br><br>

        <?php
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
            }
        ?>

        <form action="" method="POST">

        <div class="row">
            <div class="col-25">
                <label>Current Password: </label>
            </div>
            <div class="col-75">
                <input type="password" name="current_password"  placeholder="Current Password">
            </div>
        </div>

        <div class="row">
            <div class="col-25">
                <label>New Password: </label>
            </div>
            <div class="col-75">
                <input type="password" name="new_password"  placeholder="New Password">
            </div>
        </div>

        <div class="row">
            <div class="col-25">
                <label>Confirm Password: </label>
            </div>
            <div class="col-75">
                <input type="password" name="confirm_password"  placeholder="Confirm Password">
            </div>
        </div>
        <br>
        <div class="row">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" name="submit" value="Change Password" class="btn-secondary">
        </div>
     
        </form>
    </div>
</div>

<?php

//Check whether the submit button is clicked or not
if(isset($_POST['submit']))
{
    //echo "Clicked";

    //1. Get the data from form
    $id = $_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    //2. Check whether the user with current ID and current Password exists or not
    $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

    //Execute the query

    $res = mysqli_query($conn,$sql);

    if($res==true)
    {
        //Check whether data is available or not
        $count=mysqli_num_rows($res);
        if($count==1)
        {
            // User exists and password can be changed
            //echo "User found";

            //check whether the new password and confirm password match or not
            if($new_password==$confirm_password)
            {
                //Update the password
                //echo "Password matched";
                $sql2 = "UPDATE tbl_admin SET
                password='$new_password'
                WHERE id=$id
                ";

                //Execute the Query
                $res2 = mysqli_query($conn,$sql2);

                //Check whether the query executed or not
                if($res2==true)
                {
                    //Display success message
                    $_SESSION['change-pwd'] = "Password changed successfully";
                    header("location:".SITEURL.'admin/manage-admin.php');
                }
                else
                {
                    //Display error message
                    $_SESSION['failed-pwd'] = "Failed to change password";
                    header("location:".SITEURL.'admin/manage-admin.php');
                }
            }
            else
            {
                //Redirect to manage admin page with error message
                $_SESSION['pwd-not-match'] = "Password did not match";
                header("location:".SITEURL.'admin/manage-admin.php');
            }
        }
        else{
            //User does not exist
            $_SESSION['user-not-found'] = "User not found";
            header("location:".SITEURL.'admin/manage-admin.php');
        }
    }

    //3. Check whether the new password and confirm password match or not

    //4. Change password if all above is true
}

?>

<?php include('partials/footer.php'); ?> 