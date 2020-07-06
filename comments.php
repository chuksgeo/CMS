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
    <title>Comments</title>
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
                        <a href="#" class="nav-link">Dashboard</a>
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
                        <a href="comments.php" class="nav-link  active">Comments</a>
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
<!-- Heaer -->
    <Header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Manage Comments</h1>
                </div>
            </div>
        </div>
    </Header>

    <!-- Main content -->
    <section class="container py-2 mb-4">
        <div class="row" style="min-height:30px;">
            <div class="col-lg-12" style="min-height:400px;">
     <?php
        echo SuccessMessage();
        echo ErrorMessage()
    ?>
        <!-- section for Approving Comments -->
            <h2>Un-Approved Comments</h2>
                <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No.</th>
                        <th>Date&Time</th>
                        <th>Name</th>
                        <th>Comments</th>
                        <th>Approve</th>
                        <th>Delete</th>
                        <th>Details</th>
                    </tr>
                </thead>
       <?php
        $ConnectDB;
        $Sql="SELECT * FROM comment WHERE status='OFF' ORDER BY id desc";
        $Execute= $ConnectDB->query($Sql);
        $SrNo = 0;
        while ($DataRows=$Execute->fetch()){
            $CommentId          = $DataRows["id"];
            $DateTimeofComents  = $DataRows["datetime"];
            $CommentersName     = $DataRows["name"];
            $CommentContent     = $DataRows["comments"];
            $CommentPostId      = $DataRows["post_id"];
            $SrNo++;
        ?>
                <tbody>
                    <tr>
                        <td><?php echo htmlentities($SrNo); ?></td>
                        <td><?php echo htmlentities($DateTimeofComents); ?></td>
                        <td><?php echo htmlentities($CommentersName); ?></td>
                        <td><?php echo htmlentities($CommentContent); ?></td>
                        <td style="min-width:140px;"><a href="approvecomment.php?id=<?php echo $CommentId; ?>" class="btn btn-success">Approve</a></td>
                        <td><a href="deletecomment.php?id=<?php echo $CommentId; ?>" class="btn btn-danger">Delete</a></td>
                        <td style="min-width:140px;"><a href="viewfullblog.php?id=<?php echo $CommentPostId; ?>" class="btn btn-primary" target="_blank">Preview</a></td>
                    </tr>
                </tbody>
            <?php   } ?>
                </table>

    <!-- Section for Un-approving comments -->
    <h2>Approved Comments</h2>
                <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No.</th>
                        <th>Date&Time</th>
                        <th>Name</th>
                        <th>Comments</th>
                        <th>Revert</th>
                        <th>Delete</th>
                        <th>Details</th>
                    </tr>
                </thead>
       <?php
        $ConnectDB;
        $Sql="SELECT * FROM comment WHERE status='ON' ORDER BY id desc";
        $Execute= $ConnectDB->query($Sql);
        $SrNo = 0;
        while ($DataRows=$Execute->fetch()){
            $CommentId          = $DataRows["id"];
            $DateTimeofComents  = $DataRows["datetime"];
            $CommentersName     = $DataRows["name"];
            $CommentContent     = $DataRows["comments"];
            $CommentPostId      = $DataRows["post_id"];
            $SrNo++;
        ?>
                <tbody>
                    <tr>
                        <td><?php echo htmlentities($SrNo); ?></td>
                        <td><?php echo htmlentities($DateTimeofComents); ?></td>
                        <td><?php echo htmlentities($CommentersName); ?></td>
                        <td><?php echo htmlentities($CommentContent); ?></td>
                        <td style="min-width:140px;"><a href="disapprovecomment.php?id=<?php echo $CommentId; ?>" class="btn btn-warning">Dis-Approve</a></td>
                        <td><a href="deletecomment.php?id=<?php echo $CommentId; ?>" class="btn btn-danger">Delete</a></td>
                        <td style="min-width:140px;"><a href="viewfullblog.php?id=<?php echo $CommentPostId; ?>" class="btn btn-primary" target="_blank">Preview</a></td>
                    </tr>
                </tbody>
            <?php   } ?>
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