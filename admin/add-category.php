
<?php include('partials/menu.php'); ?>
<!-- Main content section starts-->
<div class="main-content">
    <div class="wrapper">
       <h2>Add Category</h2>
       <?php if(isset($_SESSION['add'])): ?>
                <div class="alert-danger">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <strong>
                    <?php  echo $_SESSION['add']; ?>
                    </strong>
                </div>
                <?php endif; ?>
        <?php unset($_SESSION['add']); ?>  
        <?php if(isset($_SESSION['upload'])): ?>
                <div class="alert-danger">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <strong>
                    <?php  echo $_SESSION['upload']; ?>
                    </strong>
                </div>
                <?php endif; ?>
        <?php unset($_SESSION['upload']); ?> 
       <br><br>
        <form name="addcategory" action="" method="POST" enctype="multipart/form-data" onsubmit="return validate()">

            <div class="row">
                <div class="col-25">
                    <label>Title: </label>
                </div>
                <div class="col-75">
                    <input type="text" name="title" placeholder="Enter title">
                    <span id="title_error" style="color:red;"></span>
                </div>
            </div>

            <div class="row">
                <div class="col-25">
                    <label >Image: </label>
                </div>
                <div class="col-75">
                    <label for="file-upload" class="custom-file-upload">
                    <i class="fas fa-cloud-upload-alt"></i> Upload Image
                    </label>
                    <input id="file-upload" name="image" type="file"/> <br>                
                  <span id="image_error" style="color:red;"></span>
                </div>
            </div>

            <div class="row">
                <div class="col-25">
                    <label>Featured: </label>
                </div>
                <div class="col-75">
                    <input type="radio" name="featured" value="Yes"> Yes 
                    <input type="radio" name="featured" value="No"> No
                </div>
            </div>

            <div class="row">
                <div class="col-25">
                    <label>Active: </label>
                </div>
                <div class="col-75">
                    <input type="radio" name="active" value="Yes"> Yes
                    <input type="radio" name="active" value="No"> No 
                    <br>
                    <span id="active_error" style="color:red;"></span>
                </div>
            </div>

            <div class="row">
                <input type="submit" name="submit" value="Add Category" class="btn-secondary">
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
        $title = $_POST['title'];
        if(isset($_POST['featured']))
        {
            $featured = $_POST['featured'];
        }
        else
        {
            $featured = "No";
        }
        if(isset($_POST['active']))
        {
            $active = $_POST['active'];
        }
        else
        {
            $active = "No";
        }


        if(isset($_FILES['image']['name']))
        {
            //Upload Image
            // To upload image we need image name, source path and destination path.
            $image_name = $_FILES['image']['name'];

            //Upload the image only if image is selected
            if($image_name != "")
            {

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
                header("location:".SITEURL.'admin/add-category.php');
                // Stop the process
                die();
            }
        }
        }
        else
        {
            //Set image value as blank
            $image_name = "";
        }

        //2. SQL Query to Save the data into database
        $sql = "INSERT INTO tbl_category SET
        title='$title',
        image_name='$image_name',
        featured='$featured',
        active='$active'
        ";

        //3. Execute query and save data into database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        //4. Check whether the (query is executed) data is inserted or not and display appropriate message.
        if($res==TRUE){
            //Data inserted
            //echo "Data inserted";
            //Create a session variable to display a message
            $_SESSION['add'] = "Category has been added successfully";
            //Redirect Page to Manage admin
            header("location:".SITEURL.'admin/manage-category.php');
        }
        else{
            //Failed to insert data
            //echo "Failed to insert data";
            //Create a session variable to display a message
            $_SESSION['add'] = "Failed to add admin";
            //Redirect Page to Manage admin
            header("location:".SITEURL.'admin/add-category.php');
        } 


    }

?>

<script>
function validate(){
    var title=document.addcategory.title.value;
    var image=document.addcategory.image.value;
    var status=true; 

    if(title==""){ 
        document.getElementById("title_error").innerHTML= "Title is required";  
        status=false;
    }
    else{
        document.getElementById("title_error").innerHTML= ""; 
        
    }

    if(image==""){ 
        document.getElementById("image_error").innerHTML= "Image is required";  
        status=false;
    }
    else{
        document.getElementById("image_error").innerHTML= ""; 
        
    }

  
    return status;  

}
</script>