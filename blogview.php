<?php
include_once("includes/DBConnect.php");
include_once("includes/functions.php");
include_once("includes/sessions.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta hhtp-equiv="X-UA-Compatible" content="ie=edge">
    <title>Live Blogs</title>
        <style media="screen">
            .heading{
                color: rgb(251, 174, 44);
                font-family: Bitter, Georgia, 'Times New Roman', Times, serif;
                color:005E90;
            }

            .heading:hover{
                color: #0090DB;
        }
        </style>
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
                        <a href="blogview.php" class="nav-link active">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="aboutus.php" class="nav-link">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="contactus.php" class="nav-link">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="features.php" class="nav-link">Features</a>
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
//  Sql when Search query is Active
            if (isset($_GET["SearchButton"])&&!empty($_GET["Search"])){
                $Search=$_GET["Search"];
                $Sql="SELECT * FROM post WHERE datetime LIKE :searcH OR title LIKE :searcH OR category LIKE :searcH OR post LIKE :searcH";
                $Stmt=$ConnectDB->prepare($Sql);
                $Stmt->bindvalue(':searcH','%'.$Search.'%');
                $Stmt->execute();
            }
// Sql query when pagination is active
            elseif (isset($_GET["page"])) {
                $Page = $_GET["page"];
                if ($Page==0||$Page<1) {
                    $PostPage=0;
                }
                else{
                    $PostPage = ($Page*5)-5;
                }
                $Sql = "SELECT * FROM post ORDER BY id desc LIMIT $PostPage,5";
                $Stmt = $ConnectDB->query($Sql);
            }
// Sql Query when category is set 
            elseif (isset($_GET["category"])) {
                $Category=$_GET["category"];
                $Sql = "SELECT * FROM post WHERE category='$Category' ORDER BY id desc";
                $Stmt=$ConnectDB->query($Sql);
            }
// Default Sql Query
            else {
                $Sql="SELECT * FROM post ORDER BY id DESC LIMIT 0,3";
                $Stmt=$ConnectDB->query($Sql);
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
                    <span class="badge badge-primary text-dark" style="float:right;">Comments 
                        <?php
                            $Total= ApproveCommentsAccordingToPost($PostId);
                            if ($Total>0){
                                echo $Total;
                            }
                        ?>
                    </span>
                    <hr>
                    <p class="card-text"><?php
                        if (strlen($PostDescription)>150) {
                            $PostDescription=substr($PostDescription,0,150).'....';
                        }
                        echo htmlentities($PostDescription); 
                    ?></p>
                    <a href="viewfullblog.php?id=<?php echo $PostId ?>" style="float:right;">
                        <span class="btn btn-info">Read More >></span>
                    </a>
                </div>
            </div>
            <?php } ?>
<!-- Pagination Algorithim -->
            <nav>
                <ul class="pagination pagination-md mt-2">
                <?php
// Creating a Backward butoon
                if (isset($Page)){
                    if($Page>1){
                ?>
                     <li class="page-item">
                    <a href="blogview.php?page=<?php echo $Page-1;?>" class="page-link">&laquo;</a>
                </li>
                <?php
                    }  }
                ?>
                <?php
                    $ConnectDB;
                    $Sql = "SELECT COUNT(*) FROM post";
                    $Stmt = $ConnectDB->query($Sql);
                    $RowPagination = $Stmt->fetch();
                    $TotalPost = array_shift($RowPagination);
                    $PostPagination= $TotalPost/5;
                    $PostPagination=ceil($PostPagination);
                    for ($i=1; $i<=$PostPagination; $i++){
                        $Page=$_GET['page'];
                        if($i==$Page){
                ?>
                    <li class="page-item active">
                        <a href="blogview.php?page=<?php echo $i;?>" class="page-link"><?php echo $i; ?></a>
                    </li>
                    <?php
                        }
                        else{
                    ?>
                    <li class="page-item">
                        <a href="blogview.php?page=<?php echo $i;?>" class="page-link"><?php echo $i; ?></a>
                    </li>
                    <?php } } 
// Creating a froward butoon
                    if (isset($Page)&&!empty($Page)){
                        if($Page+1<=$PostPagination){
                    ?>
                         <li class="page-item">
                        <a href="blogview.php?page=<?php echo $Page+1;?>" class="page-link">&raquo;</a>
                    </li>
                    <?php
                        }  }
                    ?>
                </ul>
            </nav>
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