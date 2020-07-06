<!-- Also Known as ADD-NEW-POST.PHP -->
<?php    
include_once("includes/DBConnect.php");
include_once("includes/functions.php");
include_once("includes/sessions.php");

confirm_login();

$SearchQueryParameter=$_GET["id"];

// Fetching Existing data from DB 
$ConnectDb;
$Sql="SELECT * FROM post WHERE id='$SearchQueryParameter'";
$Stmt=$ConnectDB->query($Sql);
while ($DataRow=$Stmt->fetch()) {
    $PostTitleDelete  =$DataRow["title"];
    $CategoryDelete  =$DataRow["category"];
    $ImageDelete      =$DataRow["image"];
    $PostDelete       =$DataRow["post"];

    }

if (isset($_POST["Submit"])) {
    
    // Query to Delete Data From Our DB
        $ConnectDB;
        $Sql="DELETE FROM post WHERE id='$SearchQueryParameter'";
        $Execute=$ConnectDB->query($Sql);
         
         if($Execute){
        // Deleting image save in a directory 
             $Target_Path_To_Delete_Image="uploads/$ImageDelete";
             unlink($Target_Path_To_Delete_Image);

             $_SESSION["SuccessMessage"]="Post with id : " . $ConnectDB->lastinsertid($SearchQueryParameter)  . " was Deleted Successfully!!!";
             Redirect_To("blog.php");
         }
         else{
            $_SESSION["ErrorMessage"]="Sorry something went wrong!!!";
            Redirect_To("blog.php");
         }

}



?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta hhtp-equiv="X-UA-Compatible" content="ie=edge">
    <title>DELETE POST</title>
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
                    <h1>DELETE POST</h1>
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



            ?>
                <form action="deleteblog.php?id=<?php echo $SearchQueryParameter; ?>" method="POST" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title">
                                    <span class="fieldinfo">Post Title:</span>
                                </label>
                                <input disabled class="form-control" type="text" name="PostTitle" id="title" value="<?php echo $PostTitleDelete ; ?>">
                            </div>
                            <div class="form-group">
                                <span class="fieldinfo">Existing Category : </span><?php echo $CategoryDelete; ?>
                                <br>
                            </div>
                            <div class="form-group">
                            <span class="fieldinfo ">Existing Image : </span><img class="mb-2" src="uploads/<?php echo $ImageDelete; ?>" alt="<?php echo $ImageDelete; ?>" width="170px" height="80px">
                                <br>
                            </div>
                            <div class="form-group">
                                <label for="Post">
                                    <span class="fieldinfo"> Post: </span>
                                </label>
                                <textarea disabled class="form-control" name="PostDescription" id="Post" cols="30" rows="8" ><?php echo $PostDelete; ?></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="http://dashboard.php" class="btn btn-warning btn-block">BACK To Dashboard</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" class="btn btn-danger btn-block" name="Submit">Delete</button>
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