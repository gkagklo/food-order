<?php
    include('../config/constants.php');

    //1. Get the id of admin to be deleted
    echo $id = $_GET['id'];

    //2. Create sql query to delete admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    //Execute the query
    $res = mysqli_query($conn,$sql);

    //check whether the query executed successfully or not
    if($res==true)
    {
        //echo "Admin has been deleted successfully";
          //Create a session variable to display a message
          $_SESSION['delete'] = "Admin has been deleted successfully";
          //Redirect Page to Manage admin
          header("location:".SITEURL.'admin/manage-admin.php');
    }
    else{
        //echo "Admin has been deleted successfully";
          //Create a session variable to display a message
          $_SESSION['delete'] = "Failed to delete admin";
          //Redirect Page to Manage admin
          header("location:".SITEURL.'admin/manage-admin.php');
    }


?>
