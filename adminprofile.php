<?php
include_once("includes/DBConnect.php");
include_once("includes/functions.php");
include_once("includes/sessions.php");

// Fetching Admin Data from DB using AdminId as parameter 
$SearchQueryParameter = $_GET["username"];
$ConnectDB;
$Sql = " SELECT aname, aheadline, abio, aimage FROM admins WHERE username=:userName";
$Stmt = $ConnectDB->prepare($Sql);
$Stmt->bindValue(':userName', $SearchQueryParameter);
$Stmt->execute();
$Result=$Stmt->rowcount();

if ($Result==1){
    while ($DataRow=$Stmt->fetch()) {
        $ExistingName       = $DataRow["aname"];
        $ExistingHeadline   = $DataRow["aheadline"];
        $ExistingBio        = $DataRow["abio"];
        $ExistingImage      = $DataRow["aimage"];

    }
}else {
    $_SESSION["ErrorMessage"]="Bad Request!!!";
    Redirect_to("blogview.php");
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta hhtp-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
                        <a href="#" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="http://#" class="nav-link">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="http://#" class="nav-link">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="http://#" class="nav-link">Features</a>
                    </li>
                </ul>
                </div>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <form action="blogview.php" class="form-inline d-none d-sm-block">
                            <div class="form-group">
                                <input class="form-control mr-2" type="text" name="Search" placeholder="Search Here">
                                <button  class="btn btn-primary" name="SearchButton">Go</button>
                            </div>
                        </form>
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
                    <h1><?php echo htmlentities($ExistingName); ?></h1>
                    <h6><?php echo htmlentities($ExistingHeadline); ?></h6>
                </div>
            </div>
        </div>
    </Header>
<!-- Header Ends Here  -->
<!-- Main Section Area  -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-md-3">
                <img src="images/profile/<?php echo $ExistingImage; ?>" alt="" class="d-block img-fluid mb-3 rounded">
            </div>
            <div class="col-md-9" style="min-height:400px;">
                <div class="card">
                    <div class="card-body">
                        <p class="lead"><?php echo htmlentities($ExistingBio); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>



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