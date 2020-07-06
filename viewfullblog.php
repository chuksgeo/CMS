<?php
include_once("includes/DBConnect.php");
include_once("includes/functions.php");
include_once("includes/sessions.php");

$SearchParameter=$_GET["id"];

if (isset($_POST["Submit"])) {
// Fetching the inputed Data From Form by User
    $Name       = $_POST["CommentatorName"];
    $Email      = $_POST["CommentatorEmail"];
    $Comment   = $_POST["CommentatorThoughts"];
    
// Applying date and time with current time zone
    date_default_timezone_set("Africa/Lagos");
    $CurrentTime=time();
    $DateTime=strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

// Performing Basic validation Before Passing Data to DB  
    if(empty($Name)||empty($Email)||empty($Comment)){
        $_SESSION["ErrorMessage"]="All field must be filled!!!";
        Redirect_To("viewfullblog.php?id=$SearchParameter");
    }
    elseif (strlen($Comments)>500) {
        $_SESSION["ErrorMessage"]="Input Charcter must be more than 500!!!";
        Redirect_To("viewfullblog.php?id=$SearchParameter");
    }
    else{
    // Query to insert Comments Data into our DB
        $ConnectDB;
         $Sql="INSERT INTO comment(datetime,name,email,comments,approvedby,status,post_id) VALUE(:datetimE,:namE,:emaiL,:commentS,'Pending','OFF',:postidfromurL)";
         $Stmt =$ConnectDB->prepare($Sql);
         $Stmt->bindvalue(':datetimE', $DateTime);
         $Stmt->bindvalue(':namE',$Name);
         $Stmt->bindvalue(':emaiL',$Email);
         $Stmt->bindvalue(':commentS',$Comment);
         $Stmt->bindvalue(':postidfromurL',$SearchParameter);
         
         $Execute=$Stmt->execute();

         if($Execute){
             $_SESSION["SuccessMessage"]="New Comment  was Added Successfully!!!";
             Redirect_To("viewfullblog.php?id=$SearchParameter");
         }
         else{
            $_SESSION["ErrorMessage"]="Sorry something went wrong!!!";
            Redirect_To("viewfullblog.php?id=$SearchParameter");
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
    <title>Complete Blogs Content</title>
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
                        <a href="http://#" class="nav-link">Home</a>
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
    <div class="container">
         <div class="row">
             <div class="col-sm-8">
                 <h1>My Complete Responsive CMS Blog</h1>
                 <h1 class="lead">My Complete blog Using PHP by George Chukwuebuka</h1>

                 
            <?php

            echo ErrorMessage();
            echo SuccessMessage();

            $ConnectDB;

            if (isset($_GET["SearchButton"])){
            // Sql Query for Search Parameter
                if (!empty($_GET["Search"])){

                    $Search=$_GET["Search"];
                    $Sql="SELECT * FROM post WHERE datetime LIKE :searcH OR title LIKE :searcH OR category LIKE :searcH OR post LIKE :searcH";
                    $Stmt=$ConnectDB->prepare($Sql);
                    $Stmt->bindvalue(':searcH','%'.$Search.'%');
                    $Stmt->execute();
                }
                else {
                // Default Sql Query
                    $Sql="SELECT * FROM post ORDER BY id DESC";
                    $Stmt=$ConnectDB->query($Sql);
                }
           
            }else {
                $PostIdFromURl=$_GET["id"];
                if(!isset($PostIdFromURl)){
                    $_SESSION["ErrorMessage"]="Bad Request!!!";
                    Redirect_to("blogview.php");
                }
                $Sql="SELECT * FROM post WHERE id='$PostIdFromURl'";
                $Stmt=$ConnectDB->query($Sql);
                // when id is not set  
                $Result=$Stmt->rowcount();
                if ($Result!=1){
                    $_SESSION["ErrorMessage"]="Bad Request!!!";
                    Redirect_to("blogview.php?page=1");
                }
            }
            
            while ($DataRow=$Stmt->fetch()) {
                $PostId         =$DataRow["id"];
                $DateTime       =$DataRow["datetime"];
                $PostTitle      =$DataRow["title"];
                $Category       =$DataRow["category"];
                $Admin          =$DataRow["author"];
                $Image          =$DataRow["image"];
                $PostDescription=$DataRow["post"];

            

            ?>
            <div class="card">
                <img src="uploads/<?php echo htmlentities($Image); ?>" class="image-fluid card-img-top" style="max-height:450px;"></img:src>
                <div class="card-body">
                    <h4 class="card-title"><?php echo htmlentities($PostTitle); ?></h4>
                    <small class="text-muted">Category: <a class="text-info" href="blogview.php?category=<?php echo htmlentities($Category); ?>"><?php echo htmlentities($Category); ?></a> & Written by : <a class="text-info" href="adminprofile.php?username=<?php echo htmlentities($Admin); ?>"><?php echo htmlentities($Admin); ?></a> On: <?php echo $DateTime ?></small>
                    <hr>
                    <p class="card-text"><?php
                        echo htmlentities($PostDescription); 
                    ?></p>
                </div>
            </div>
            <br>
            <?php } ?>
    <!-- Comment Section Begins Here -->
                
                    <span class="fieldinfo">Comments</span><br><br>
        <!-- fetching all existing post in DB -->
                    <?php
        $ConnectDB;
        $Sql = "SELECT * FROM comment WHERE post_id='$SearchParameter' AND status='ON'";
        $Stmt=$ConnectDB->query($Sql);

        while ($DataRow=$Stmt->fetch()) {
            $CommentDate    =$DataRow["datetime"];
            $CommentName    =$DataRow["name"];
            $CommentContent =$DataRow["comments"];
        ?>  
                <div>
                <div class="media CommentBlock">
                    <img class="d-block img-fluid align-self-start" src="images/avatar.png" alt="" width="50px">
                    <div class="media-body ml-2">
                        <h6 class="lead"><?php echo $CommentName ?></h6>
                        <p class="small"><?php echo $CommentDate ?></p>
                        <p><?php echo $CommentContent ?></p>
                    </div>
                </div>
                </div>
                <hr>
        <?php  } ?>

                 
        <!-- comment table for accepting data to send int our DB -->
                <div class="">
                    <form action="viewfullblog.php?id=<?php echo $SearchParameter; ?>" method="post">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="fieldinfo">Share your Thoughts</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"></span>
                                    </div>
                                    <input type="text" class="form-control" name="CommentatorName" placeholder="Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"></span>
                                    </div>
                                    <input type="text" class="form-control" name="CommentatorEmail" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea name="CommentatorThoughts" id="" cols="80" rows="8" class="form-control"></textarea>
                            </div>
                            <div>
                                <button type="submit" name="Submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
             </div>

             <!-- side area section -->
             <div class="col-sm-4">
                <div class="card mt-4">
                    <div class="card-body">
                        <img src="images/ads1.jpg" alt="Ads" class="d-block img-fluid mb-3">
                        <div class="text-center">
                            this is a test of a content management site
                        </div> 
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h2 class="lead">Sign Up!</h2>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-success btn-block text-center text-white mb-4">Join the Forum</button>
                        <a href="login.php" class="btn btn-danger btn-block text-center text-white mb-4">Login</a>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Enter your Email">
                            <div class="input-group-append">
                                <button class="btn btn-primary btn-sm text-center text-white"type="button">Subscribe Now!</button>
                            </div>
                        </div>
                    </div>  
                </div>
                <br>
    <!-- Category section of side bar  -->
                <div class="card">
                    <div class="card-header bg-primary text-light">
                        <h2 class="lead">Categories</h2>
                    </div>
                    <div class="class-body">
                <?php
                    $ConnectDB;
                    $Sql = "SELECT * FROM category ORDER BY id desc";
                    $Stmt=$ConnectDB->query($Sql);
                    while ($DataRow=$Stmt->fetch()) {
                        $CategoryId     = $DataRow["id"];
                        $CategoryName   = $DataRow["title"];
                ?>
                    <a href="blogview.php?category=<?php echo $CategoryName; ?>" target="_blank">
                        <span class="heading"><?php echo $CategoryName; ?><br></span>
                    </a> 
                    
                <?php
                    }
                ?>
                    </div>
                </div>
                <br>
    <!-- Posts section of side bar / -->
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h2 class="lead">Recent Posts</h2>
                    </div>
                    <div class="class-body">
                <?php
                    $ConnectDB;
                    $Sql = "SELECT * FROM post ORDER BY id desc LIMIT 0,5";
                    $Stmt=$ConnectDB->query($Sql);
                    while ($DataRow=$Stmt->fetch()) {
                        $PostId     = $DataRow["id"];
                        $PostTitle  = $DataRow["title"];
                        $PostTime   = $DataRow["datetime"];
                        $PostImage  = $DataRow["image"];
                ?>
                        <div class="media"> 
                            <img src="uploads/<?php echo $PostImage; ?>" alt="<?php echo $PostImage; ?>" class="d-block img-fluid align-self-start" width="100" height="90">
                            <div class="media-body ml-2">
                            <a href="viewfullblog.php?id=<?php echo $PostId; ?>" target="_blank">
                                <h6 class="lead text-dark">
                                    <?php echo $PostTitle; ?>
                                </h6>
                            </a>
                                <p class="small"><?php echo $PostTime; ?></p>
                            </div>
                        </div>
                    <hr>    
                <?php
                    }
                ?>
                    </div>
                </div>

             </div>
         </div>
    </div>
<!-- End of side Area Section  -->



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