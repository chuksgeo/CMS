<!-- Also Known as ADD-NEW-POST.PHP -->
<?php    
include_once("includes/DBConnect.php");
include_once("includes/functions.php");
include_once("includes/sessions.php");

confirm_login();

$SearchQueryParameter=$_GET["id"];

if (isset($_POST["Submit"])) {
    
    $PostTitle=$_POST["PostTitle"];
    $Category =$_POST["Category"];
    $Image    =$_FILES["Image"]["name"];
    $Target   ="uploads/".basename($_FILES["Image"]["name"]);
    $PostText =$_POST["PostDescription"];
    $Admin = "George";
// Applying date and time with current time zone
    date_default_timezone_set("Africa/Lagos");
    $CurrentTime=time();
    $DateTime=strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

    
    if(empty($PostTitle)){
        $_SESSION["ErrorMessage"]="All field must be filled!!!";
        Redirect_To("blog.php");
    }
    elseif (strlen($PostTitle)<5) {
        $_SESSION["ErrorMessage"]="Input Charcter must be more than two!!!";
        Redirect_To("editblog.php");
    }
    elseif (strlen($PostTitle)>9999) {
        $_SESSION["ErrorMessage"]="Input Charcter must be less than One Thousand!!!";
        Redirect_To("editblog.php");
    }
    else{
    // Query to update Data into our DB
        $ConnectDB;

        if (!empty($Image)) {
            $Sql="UPDATE post SET title='$PostTitle', category='$Category', image='$Image', post='$PostText' WHERE id='$SearchQueryParameter'";
        }
        else {
            $Sql="UPDATE post SET title='$PostTitle', category='$Category', post='$PostText' WHERE id='$SearchQueryParameter'";
        }


         
         
         
         $Execute=$ConnectDB->query($Sql);

         move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);

         if($Execute){
             $_SESSION["SuccessMessage"]="Post with id : " . $ConnectDB->lastinsertid($SearchQueryParameter)  . " was Updated Successfully!!!";
             Redirect_To("blog.php");
         }
         else{
            $_SESSION["ErrorMessage"]="Sorry something went wrong!!!";
            Redirect_To("blog.php");
         }
         
    }


}



?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta hhtp-equiv="X-UA-Compatible" content="ie=edge">
    <title>EDIT POST</title>
    <link rel="stylesheet" href="./styles/bootstrap.min.css">
    <link rel="stylesheet" href="./styles/style.css">
    <body>
    <div style="height:10px; background:#27aae1"></div>
<!-- Navigation Menu-Bar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
            <a href="http://#" class="navbar-brand">GEORGESON.COM</a>
    <!-- Navigation Menu-Toggled -->
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapse">
                <ul class="navbar-nav m-auto">
                    <li class="nav-item">
                        <a href="http://#" class="nav-link">My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="http://#" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="http://#" class="nav-link">Post</a>
                    </li>
                    <li class="nav-item">
                        <a href="http://#" class="nav-link">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a href="http://#" class="nav-link">Manage Admin</a>
                    </li>
                    <li class="nav-item">
                        <a href="http://#" class="nav-link">Comments</a>
                    </li>
                    <li class="nav-item">
                        <a href="blogview.php" class="nav-link">Live Blog</a>
                    </li>
                </ul>
                </div>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="http://#" class="nav-link">Logout</a>
                    </li>
                </ul>
        </div>
        </nav>
    <div style="height:10px; background:#27aae1"></div>
<!-- End of Navigation Menu-Bar -->
<!-- Header -->
    <Header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>EDIT POST</h1>
                </div>
            </div>
        </div>
    </Header>
<!-- End of Header -->
<!-- Main Content -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-lg-1 col-lg-10">
            <?php
            echo ErrorMessage();
            echo SuccessMessage();

        // Fetching Existing data from DB
            
            $ConnectDb;
            $Sql="SELECT * FROM post WHERE id='$SearchQueryParameter'";
            $Stmt=$ConnectDB->query($Sql);
            while ($DataRow=$Stmt->fetch()) {
                $PostTitleUpdate  =$DataRow["title"];
                $CategooryUpdate  =$DataRow["category"];
                $ImageUpdate      =$DataRow["image"];
                $PostUpdate       =$DataRow["post"];

            }

            ?>
                <form action="editblog.php?id=<?php echo $SearchQueryParameter; ?>" method="POST" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title">
                                    <span class="fieldinfo">Post Title:</span>
                                </label>
                                <input class="form-control" type="text" name="PostTitle" id="title" value="<?php echo $PostTitleUpdate ; ?>">
                            </div>
                            <div class="form-group">
                                <span class="fieldinfo">Existing Category : </span><?php echo $CategooryUpdate; ?>
                                <br>
                                <label for="CategoryTitle">
                                    <span class="fieldinfo">Choose Category:</span>
                                </label>
                                <select id="CategoryTitle" class="form-control" name="Category">
                            <!-- Fetching all the category from the category table in the DB -->
                                    <?php
                                        $ConnectDB;
                                        $sql = "SELECT id,title FROM category";
                                        $Stmt = $ConnectDB->query($sql);
                                        while($DataRow=$Stmt->fetch()){
                                            $id             = $DataRow["id"];
                                            $CategoryName   = $DataRow["title"];
                                    ?>
                                    <option><?php echo $CategoryName; ?></option>                                    
                                    <?php } ?>

                                </select>
                            </div>
                            <div class="form-group mb-1">
                            <span class="fieldinfo ">Existing Image : </span><img class="mb-2" src="uploads/<?php echo $ImageUpdate; ?>" alt="<?php echo $ImageUpdate; ?>" width="170px" height="80px">
                                <br>
                                <div class="custom-file">
                                    <input class="custom-file-label" type="file" name="Image" id="imageselect" >
                                    <label for="imageselect" class="custom-file-label">Select Image</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Post">
                                    <span class="fieldinfo"> Post: </span>
                                </label>
                                <textarea class="form-control" name="PostDescription" id="Post" cols="30" rows="8" ><?php echo $PostUpdate; ?></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="http://dashboard.php" class="btn btn-warning btn-block">BACK To Dashboard</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" class="btn btn-success btn-block" name="Submit">Publish</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </section>


<!-- End of Main Section -->
<!-- Footer -->
<footer class="bg-dark text-white">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="lead text-center">
                    &copy | GEORGESON | <span id="year"></span>  All right Reserved.
                </p>
                <p class="text-center small">
                    <a style="color:white; text-decoration:none; cursor:pointer;" href="http://">
                        This site was used for skill development on CMS, George Chuks have all the rigths so no one is allowed to distribute
                        <br>&trade;GEORGESON.COM
                    </a>
                </p>
            </div>
        </div>
    </div>
</footer>
<!-- End of Footer -->
    <script src="./scripts/jquery-1.9.1.min.js"></script>
    <script src="./scripts/bootstrap.bundle.min.js"></script>
<!-- Custom Date script of Footer -->
    <script>
    $('#year').text(new Date().getFullYear());
    </script>
    </body> 
    </head>
</html>