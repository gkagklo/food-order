<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
    <h2>Update Category</h2>
    <br><br>

    <?php
        //Check whether the id is set or not
        if(isset($_GET['id']))
        {
            //Get the id and all other details
            //echo "Getting the data";
            $id = $_GET['id'];
            //Create sql query to get all other details
            $sql = "SELECT * FROM tbl_category WHERE id=$id";
            //Execute the query
            $res = mysqli_query($conn,$sql);
            //Count the rows to check whether the id is valid or not
            $count = mysqli_num_rows($res);
            if($count==1)
            {
                $row=mysqli_fetch_assoc($res);
                $title = $row['title'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
            }
            else
            {
                //Redirect to manage category with message
                $_SESSION['no-category-found'] = "Category not found";
                header("location:".SITEURL.'admin/manage-admin.php');
            }
        }
        else
        {
            //Redirect to manage category
            header("location:".SITEURL.'admin/manage-category.php');
        }
    ?>

    <form name="updatecategory" action="" method="POST" enctype="multipart/form-data" onsubmit="return validate()">
    
    <div class="row">
        <div class="col-25">
            <label>Title: </label>
        </div>
        <div class="col-75">
            <input type="text" name="title" placeholder="Enter title" value="<?php echo $title; ?>">
            <span id="title_error" style="color:red;"></span>
        </div>
    </div>

    <div class="row">
        <div class="col-25">
            <p>Current Image: </p>
        </div>
        <div class="col-75">
        <?php
            if($current_image != "")
            {
                //Display image
                ?>
                <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="200" height="180" alt="">
                <?php
            }
            else
            {
                //Display message
                echo "<div class='error'>Image not added</div>";
            }
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-25">
            <label>New Image: </label>
        </div>
        <div class="col-75">
            <label for="file-upload" class="custom-file-upload">
            <i class="fas fa-cloud-upload-alt"></i> Upload Image
            </label>
            <input id="file-upload" name="image" type="file"/>
        </div>
    </div>

    <div class="row">
        <div class="col-25">
            <label>Featured: </label>
        </div>
        <div class="col-75">
            <input <?php if($featured == 'Yes') {echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
            <input <?php if($featured == 'No') {echo "checked";} ?> type="radio" name="featured" value="No"> No
        </div>
    </div>

    <div class="row">
        <div class="col-25">
            <label>Active: </label>
        </div>
        <div class="col-75">
            <input <?php if($active == 'Yes') {echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
            <input <?php if($active == 'No') {echo "checked";} ?> type="radio" name="active" value="No"> No
        </div>
    </div>

    <div class="row">
        <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
    </div>

    </form>

    <?php 
    //Check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
       // echo "Button is clicked";    
       // Get all the values from form to update
       $id = $_POST['id'];
       $title = $_POST['title'];
       $current_image = $_POST['current_image'];
       $featured = $_POST['featured'];
       $active = $_POST['active'];

       //Updating new image if selected
       //Check whether the image is selected or not
        if(isset($_FILES['image']['name']))
        {
            //Get the image details
            $image_name = $_FILES['image']['name'];

            //Check whether the image is available or not
            if($image_name != "")
            {
                //Image available
                //Upload the new image
                //Get the extension of our image
                    $ext = end(explode('.',$image_name));
                    //Get only filename
                    $filename = pathinfo($image_name, PATHINFO_FILENAME);
                    //Rename Image
                    $image_name = $filename.'_'.time().rand(000,999).'.'.$ext;
                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/".$image_name;

                    //Finally upload the image
                    $upload = move_uploaded_file($source_path,$destination_path);

                    //Check whether the image is uploaded or not
                    if($upload==false)
                    {
                        //Set message
                        $_SESSION['upload'] = "Failed to upload image";
                        //Redirect to add category page
                        header("location:".SITEURL.'admin/manage-category.php');
                        // Stop the process
                        die();
                    }
                //Remove current image if available
                if($current_image != "")
                {
                    $remove_path = "../images/category/".$current_image;
                    $remove = unlink($remove_path);

                    //Check whether the image is removed or not
                    //If failed to remove then display message and stop process
                    if($remove==false)
                    {
                        //Failed to remove image
                        $_SESSION['failed-remove'] = "Failed to remove current image";
                        header("location:".SITEURL.'admin/manage-category.php');
                        die();
                    }
                }
                

            }
            else
            {
                $image_name = $current_image;
            }
        }
        else
        {
            $image_name = $current_image;
        }

       //Create sql query to update category
       $sql2 = "UPDATE tbl_category SET
       title = '$title',
       image_name = '$image_name',
       featured = '$featured',
       active = '$active'
       WHERE id = '$id'
       ";

       //Execute the query
       $res2 = mysqli_query($conn,$sql2);

       if($res2==true)
       {
            //Query executed and category updated
            $_SESSION['update'] = "Category has been updated successfully";
            header("location:".SITEURL.'admin/manage-category.php');
       }
       else
       {
           //Failed to update admin
           $_SESSION['update'] = "Failed to update category";
           header("location:".SITEURL.'admin/manage-category.php');
       }
    }
?>

    </div>
</div>

<?php include('partials/footer.php'); ?> 


<script>
function validate(){
    var title=document.updatecategory.title.value;
    var status=true; 

    if(title==""){ 
        document.getElementById("title_error").innerHTML= "Title is required";  
        status=false;
    }
    else{
        document.getElementById("title_error").innerHTML= ""; 
        
    }


    return status;  

}
</script>