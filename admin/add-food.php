
<?php include('partials/menu.php'); ?>
<!-- Main content section starts-->
<div class="main-content">
    <div class="wrapper">
       <h2>Add Food</h2>

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
        <form name="addfood" action="" method="POST" enctype="multipart/form-data" onsubmit="return validate()">

        <div class="row">
            <div class="col-25">
                <label>Category: </label>
            </div>
            <div class="col-75">
                <select name="category">
                <option disabled selected value> Select one category </option>
                <?php 
                    $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                    $res = mysqli_query($conn, $sql);
                    $count = mysqli_num_rows($res);
                    if($count > 0){
                        while($row=mysqli_fetch_assoc($res))
                        {
                            $id = $row['id'];
                            $title = $row['title'];
                            ?>
                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                            <?php
                        }
                    }
                    else
                    {
                        ?>
                        <option value="0">No category found</option>
                        <?php
                    }
                ?>
                </select>
                <span id="category_error" style="color:red;"></span>
            </div>
        </div>

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
                <label>Description: </label>
            </div>
            <div class="col-75">
                <textarea name="description" placeholder="Some text..."></textarea>
                <span id="description_error" style="color:red;"></span>
            </div>
        </div>

        <div class="row">
            <div class="col-25">
                <label>Price: </label>
            </div>
            <div class="col-75">
                <input type="number" name="price" placeholder="Enter price" min="0" step=".01">
                <span id="price_error" style="color:red;"></span>
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
                <input id="file-upload" name="image" type="file"/>
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
            </div>
        </div>

        <div class="row">        
            <input type="submit" name="submit" value="Add Food" class="btn-secondary">
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
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];
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
            $destination_path = "../images/food/".$image_name;

            //Finally upload the image
            $upload = move_uploaded_file($source_path,$destination_path);

            //Check whether the image is uploaded or not
            if($upload==false)
            {
                //Set message
                $_SESSION['upload'] = "Failed to upload image";
                //Redirect to add category page
                header("location:".SITEURL.'admin/add-food.php');
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
        $sql = "INSERT INTO tbl_food SET
        title='$title',
        description='$description',
        price='$price',
        image_name='$image_name',
        category_id='$category',
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
            $_SESSION['add'] = "Food has been added successfully";
            //Redirect Page to Manage admin
            header("location:".SITEURL.'admin/manage-food.php');
        }
        else{
            //Failed to insert data
            //echo "Failed to insert data";
            //Create a session variable to display a message
            $_SESSION['add'] = "Failed to add food";
            //Redirect Page to Manage admin
            header("location:".SITEURL.'admin/add-food.php');
        } 


    }

?>

<script>
function validate(){
    var category=document.addfood.category.value;
    var title=document.addfood.title.value;
    var price=document.addfood.price.value;
    var description=document.addfood.description.value;
    var image=document.addfood.image.value;
    var status=true; 

    if(category==""){ 
        document.getElementById("category_error").innerHTML= "Category is required";  
        status=false;
    }
    else{
        document.getElementById("category_error").innerHTML= ""; 
        
    }

    if(title==""){ 
        document.getElementById("title_error").innerHTML= "Title is required";  
        status=false;
    }
    else{
        document.getElementById("title_error").innerHTML= ""; 
        
    }

    if(description==""){ 
        document.getElementById("description_error").innerHTML= "Description is required";  
        status=false;
    }
    else{
        document.getElementById("description_error").innerHTML= ""; 
        
    }

    if(price==""){ 
        document.getElementById("price_error").innerHTML= "Price is required";  
        status=false;
    }
    else{
        document.getElementById("price_error").innerHTML= ""; 
        
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