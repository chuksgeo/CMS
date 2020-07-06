<?php
include_once("includes/DBConnect.php");
include_once("includes/functions.php");
include_once("includes/sessions.php");

$_SESSION["trackingURL"]=$_SERVER["PHP_SELF"];
confirm_login();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta hhtp-equiv="X-UA-Compatible" content="ie=edge">
    <title>DASHBOARD</title>
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
                        <a href="profile.php" class="nav-link">My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link active">Dashboard</a>
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
                    <h1>My Dashboard</h1>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="post.php" class="btn btn-primary btn-block"> Add New POST </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="category.php" class="btn btn-info btn-block"> Add New CATEGORY </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="admin.php" class="btn btn-warning btn-block"> Add New ADMIN </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="comments.php" class="btn btn-success btn-block"> Approve Comments </a>
                </div>
            </div>
        </div>
    </Header>
<!-- main section area -->
    <section class="container py-2 mb-4">
        <div class="row" >
            <div class="container">
            <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            </div>       
    <!-- Left Section Area of Dashboard -->
            <div class="col-lg-2 d-none d-md-block">
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Posts</h1>
                        <h4 class="display-5">
                            <?php
                            $ConnectDB;
                            $Sql="SELECT COUNT(*) FROM post";
                            $Stmt=$ConnectDB->query($Sql);
                            $TotalRows=$Stmt->fetch();
                            $TotalPost=array_shift($TotalRows);
                            echo $TotalPost;
                            ?>
                        </h4>
                    </div>
                </div>
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Categories</h1>
                        <h4 class="display-5">
                        <?php
                            $ConnectDB;
                            $Sql="SELECT COUNT(*) FROM category";
                            $Stmt=$ConnectDB->query($Sql);
                            $TotalRows=$Stmt->fetch();
                            $TotalCategory=array_shift($TotalRows);
                            echo $TotalCategory;
                            ?>
                        </h4>
                    </div>
                </div>
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Admins</h1>
                        <h4 class="display-5">
                        <?php
                            $ConnectDB;
                            $Sql="SELECT COUNT(*) FROM admins";
                            $Stmt=$ConnectDB->query($Sql);
                            $TotalRows=$Stmt->fetch();
                            $TotalAdmin=array_shift($TotalRows);
                            echo $TotalAdmin;
                            ?>
                        </h4>
                    </div>
                </div>
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Comments</h1>
                        <h4 class="display-5">
                        <?php
                            $ConnectDB;
                            $Sql="SELECT COUNT(*) FROM comment";
                            $Stmt=$ConnectDB->query($Sql);
                            $TotalRows=$Stmt->fetch();
                            $TotalComment=array_shift($TotalRows);
                            echo $TotalComment;
                            ?>
                        </h4>
                    </div>
                </div>
               
            </div>
        <!-- End Left Section Area of the Dashboard -->
        <!-- Begining Of Right Section Area of Dashboard -->
            <div class="col-lg-10">
                <h1>Top Post</h1>
                <table class="table table-strip table-hover">
                    <thead class="dark">
                        <tr>
                            <th>No.</th>
                            <th>Date&Time</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Comments</th>
                            <th>Details</th>
                        </tr>
                    </thead>
            <?php
            $SrNo=0;
            $ConnectDB;
            $Sql="SELECT * FROM post ORDER BY id desc LIMIT 0,5";
            $Stmt =$ConnectDB->query($Sql);
            while ($DataRows=$Stmt->fetch()){
                $PostId        = $DataRows["id"];
                $PostDateTime  = $DataRows["datetime"];
                $PostTitle     = $DataRows["title"];
                $PostAuthor    = $DataRows["author"];
                // $PostComment   = $DataRows["post_id"];
                // $PostDetails   = $DataRows["post_id"];
                $SrNo++;
            ?>
                    <tbody>
                        <tr>
                            <td><?php echo $SrNo;  ?></td>
                            <td><?php echo $PostDateTime; ?></td>
                            <td><?php echo $PostTitle; ?></td>
                            <td><?php echo $PostAuthor?></td>
                            <td>
                                <span class="badge badge-success">
                            <?php
                                $TotalApprove=ApproveCommentsAccordingToPost($PostId);
                                echo $TotalApprove;
                            ?>
                                </span>
                                <span class="badge badge-danger">
                            <?php
                                $ConnectDB;
                                $SqlUnapprove="SELECT COUNT(*) FROM comment WHERE post_id='$PostId' AND status='ON'";
                                $StmtUnapprove=$ConnectDB->query($SqlUnapprove);
                                $TotalRows=$StmtUnapprove->fetch();
                                $TotalApprove=array_shift($TotalRows);
                                echo $TotalApprove;
                            ?>
                                </span>
                            </td>
                            <td>
                            <a href="viewfullblog.php?id=<?php echo $PostId; ?>" target="_blank">
                                <span class="btn btn-info">Preview</span>
                            </a>
                            </td>
                        </tr>
                    </tbody>
            <?php
            }
            ?>
                </table>
            </div>
        <!-- End of Right Section Area Of Dashboard -->
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