<?php
    include('../config/constants.php');

    //Check whether the id and image_name value is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //Get the value and delete
        //echo "Get value and delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove the physical image file if available
        if($image_name != "")
        {
          //Image is available. So remove it
          $path = "../images/food/".$image_name;
          //Remove the image
          $remove = unlink($path);

          //If failed to remove image then add an error message and stop process
          if($remove==false)
          {
            //Set the session message
            $_SESSION['remove'] = "Failed to remove food image";
            //Redirect to manage category page
            header("location:".SITEURL.'admin/manage-food.php');
            //Stop the process
            die();
          }
        }

        //Delete data from database
        $sql = "DELETE FROM tbl_food WHERE id=$id";

        //Execute Query
        $res = mysqli_query($conn,$sql);

        //Check whether the data is delete from database or not
        if($res==true)
        {
          //Set success message and redirect
          $_SESSION['delete'] = "Food has been deleted successfully";
          header("location:".SITEURL.'admin/manage-food.php');
        }
        else
        {
          //Set error message and redirect
          $_SESSION['delete'] = "Failed to delete food";
          header("location:".SITEURL.'admin/manage-food.php');
        }

    }
    else
    {
        //Redirect to manage category page
        header("location:".SITEURL.'admin/manage-category.php');
    }

?>



