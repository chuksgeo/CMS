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
    <title>BLOG</title>
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
                        <a href="post.php" class="nav-link">Post</a>
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
                    <h1>My Blogs</h1>
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
                    <a href="" class="btn btn-success btn-block"> Approve Comments </a>
                </div>
            </div>
        </div>
    </Header>
<!-- main section area -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-lg-12">
            <?php
            echo ErrorMessage();
            echo SuccessMessage();

            ?>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>category</th>
                            <th>Date&Time</th>
                            <th>Author</th>
                            <th>Banner</th>
                            <th>Comments</th>
                            <th>Action</th>
                            <th>Live Preview</th>
                        </tr>
                    </thead>

            <!-- Connecting  to the DB for creating a list of blogs -->
                    <?php
                    $ConnectDB;
                    $Sql="SELECT * FROM post";
                    $Stmt=$ConnectDB->query($Sql);
                    $Sr=0;
                    while ($DataRow=$Stmt->fetch()){
                        $Id         =$DataRow["id"];
                        $DataTime   =$DataRow["datetime"];
                        $PostTitle  =$DataRow["title"];
                        $Category   =$DataRow["category"];
                        $Admin      =$DataRow["author"];
                        $Image      =$DataRow["image"];
                        $PostText   =$DataRow["post"];
                        $Sr++;
                    
                    ?>
                    <tbody>
                        <tr>
                            <td><?php echo $Sr ?></td>
                            <td>
                                <?php
                                    if (strlen($PostTitle)>20){
                                        $PostTitle=substr($PostTitle,0,20).'..';
                                    }
                                    echo $PostTitle 
                                ?>
                            </td>
                            <td><?php echo $Category ?></td>
                            <td>
                            <?php
                                    if (strlen($DataTime)>11){
                                        $DataTime=substr($DataTime,0,11).'..';
                                    }
                                    echo $DataTime 
                                ?>
                            </td>
                            <td><?php echo $Admin ?></td>
                            <td> <img src="uploads/<?php echo $Image ?>" alt="<?php echo $Image ?>" width="170px" height="70px"></td>
                            <td><span class="badge badge-success">
                            <?php
                                $TotalApprove=ApproveCommentsAccordingToPost($Id);
                                echo $TotalApprove;
                            ?>
                                </span>
                                
                            <span class="badge badge-danger">
                            <?php
                                $ConnectDB;
                                $SqlUnapprove="SELECT COUNT(*) FROM comment WHERE post_id='$Id' AND status='ON'";
                                $StmtUnapprove=$ConnectDB->query($SqlUnapprove);
                                $TotalRows=$StmtUnapprove->fetch();
                                $TotalApprove=array_shift($TotalRows);
                                echo $TotalApprove;
                            ?>
                                </span>

                            </td>
                            <td>
                                <a href="editblog.php?id=<?php echo $Id; ?>"><span class="btn btn-warning">Edit</span></a>
                                <a href="deleteblog.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a>
                            </td>
                            <td>
                                <a href="viewfullblog.php?id=<?php echo $Id; ?>" target="_blank">
                                <span class="btn btn-primary">Live Preview</span>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                    
                    <?php
                        }
                    ?>
                </table>
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