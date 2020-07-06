<!-- Also Known as ADD-NEW-POST.PHP -->
<?php    
include_once("includes/DBConnect.php");
include_once("includes/functions.php");
include_once("includes/sessions.php");

$_SESSION["trackingURL"]=$_SERVER["PHP_SELF"];
confirm_login();
// Fetching Existing Admin Data 
$AdminId = $_SESSION["UserId"];
$ConnectDB;
$Sql = "SELECT * FROM admins WHERE id='$AdminId'";
$Stmt = $ConnectDB->query($Sql);
while ($DataRow = $Stmt->fetch()){
        $ExistingUser       = $DataRow["username"];
        $ExistingName       = $DataRow["aname"];
        $ExistingImage      = $DataRow["aimage"];
        $ExistingHeadline   = $DataRow["aheadline"];
        $ExistingBio        = $DataRow["abio"];    
}
// Fetching Admin User data 
if (isset($_POST["Submit"])) {
        $AName      = $_POST["Name"];
        $AHeadline  = $_POST["Headline"];
        $ABio       = $_POST["Bio"];
        $AImage    =$_FILES["Image"]["name"];
        $Target   ="images/profile/".basename($_FILES["Image"]["name"]);
// Applying basic validations
        if (strlen($AHeadline)>60) {
            $_SESSION["ErrorMessage"]="Input Charcter must not be more than Sixty(60)!!!";
            Redirect_To("profile.php");
        }
        elseif (strlen($ABio)>500) {
            $_SESSION["ErrorMessage"]="Input Charcter must be less than Five Hundrer!!!";
            Redirect_To("profile.php");
        }
        else{
// Query to Update ADmin Data into our DB
            $ConnectDB;
            if (!empty($AImage)) {
                $Sql="UPDATE admins SET aname='$AName', aheadline='$AHeadline', abio='$ABio', aimage='$AImage' WHERE id='$AdminId'";
            }
        else {
            $Sql="UPDATE admins SET aname='$AName', aheadline='$AHeadline', abio='$ABio' WHERE id='$AdminId'";
        }

        $Execute=$ConnectDB->query($Sql);

        move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
        if($Execute){
            $_SESSION["SuccessMessage"]="User Info Updated Successfully!!!";
            Redirect_To("profile.php");
        }
        else{
            $_SESSION["ErrorMessage"]="Sorry something went wrong!!!";
            Redirect_To("profile.php");
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
    <title>My Profile</title>
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
                        <a href="profile.php" class="nav-link active">My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="post.php" class="nav-link">Post</a>
                    </li>
                    <li class="nav-item">
                        <a href="category.php" class="nav-link">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a href="admin.php" class="nav-link">Manage Admin</a>
                    </li>
                    <li class="nav-item">
                        <a href="comments.php" class="nav-link">Comments</a>
                    </li>
                    <li class="nav-item">
                        <a href="blogview.php" class="nav-link">Live Blog</a>
                    </li>
                </ul>
                </div>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link">Logout</a>
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
                    <h1>@<?php echo htmlentities($ExistingUser); ?></h1>
                    <small><?php echo htmlentities($ExistingHeadline); ?></small>
                </div>
            </div>
        </div>
    </Header>
<!-- End of Header -->
<!-- Main Content -->
    <section class="container py-2 mb-4">
        <div class="row">
<!-- Left Section ......................... -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <?php echo $ExistingName; ?>
                    </div>
                    <div class="card-body">
                        <img src="images/profile/<?php echo $ExistingImage; ?>" alt="" class="block img-fluid mb-3" >
                        <div class=""><?php echo htmlentities($ExistingBio); ?> </div>
                    </div>
                </div>
            </div>
<!-- Right Section ........................................ -->
            <div class="col-md-9">
            <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
                <form action="profile.php" method="POST" enctype="multipart/form-data">
                    <div class="card bg-dark text-light">

                        <div class="card-header bg-secondary text-light">
                            <h4 class="">Edit Profile</h4>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <input class="form-control" type="text" name="Name"  placeholder="Full Name Here!!!">
                                <span class="text-muted">Existing Name: </span>
                                <span class="text-info"><?php echo htmlentities($ExistingName); ?></span>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" name="Headline"  placeholder="Headline!!!">
                                <small class="text-muted">Add a Profession Headling like 'Engineer at XYZ'</small>
                                <span class="text-danger">Not More than 60 Charcter</span>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="Bio" placeholder="Enter your Bio" cols="30" rows="8" ><?php echo htmlentities($ExistingBio); ?></textarea>
                            </div>
                            <div class="form-group mb-1">
                                <div class="custom-file">
                                    <input class="custom-file-label" type="file" name="Image" id="imageselect" >
                                    <label for="imageselect" class="custom-file-label">Select Image</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="dashboard.php" class="btn btn-warning btn-block">BACK To Dashboard</a>
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