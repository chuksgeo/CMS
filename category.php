<?php
include_once("includes/DBConnect.php");
include_once("includes/functions.php");
include_once("includes/sessions.php");

confirm_login();

if (isset($_POST["Submit"])) {
    
    $Category=$_POST["CategoryTitle"];
    $Admin =$_SESSION["UserName"];
// Applying date and time with current time zone

    date_default_timezone_set("Africa/Lagos");
    $CurrentTime=time();
    $DateTime=strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

    
    if(empty($Category)){
        $_SESSION["ErrorMessage"]="All field must be filled!!!";
        Redirect_To("category.php");
    }
    elseif (strlen($Category)<5) {
        $_SESSION["ErrorMessage"]="Input Charcter must be more than Five!!!";
        Redirect_To("category.php");
    }
    elseif (strlen($Category)>49) {
        $_SESSION["ErrorMessage"]="Input Charcter must be less than forty-nine!!!";
        Redirect_To("category.php");
    }
    else{
    // Query to insert Data into our DB
        $ConnectDB;
         $Sql="INSERT INTO category(title,author,datetime) VALUE(:categoryName,:adminName,:dateTime)";
         $Stmt =$ConnectDB->prepare($Sql);
         $Stmt->bindvalue(':categoryName',$Category);
         $Stmt->bindvalue(':adminName',$Admin);
         $Stmt->bindvalue(':dateTime',$DateTime);
         $Execute=$Stmt->execute();

         if($Execute){
             $_SESSION["SuccessMessage"]="New Category with id : " . $ConnectDB->lastinsertid() . " was Added Successfully!!!";
             Redirect_To("category.php");
         }
         else{
            $_SESSION["ErrorMessage"]="Sorry something went wrong!!!";
            Redirect_To("category.php");
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
    <title>CATEGORIES</title>
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
                        <a href="dashboard.php" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="post.php" class="nav-link">Post</a>
                    </li>
                    <li class="nav-item">
                        <a href="category.php" class="nav-link active">Categories</a>
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
<!-- Heaer -->
    <Header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Manage Categories</h1>
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
                <form action="category.php" method="post">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header">
                        <h1>Add New Category</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title">
                                    <span class="fieldinfo">Category Title:</span>
                                </label>
                                <input class="form-control" type="text" name="CategoryTitle" id="title" placeholder="Type your Title Here">
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
    <!-- Table for retriving stored categories from DB -->
                <h2>Existing Categories</h2>
                <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No.</th>
                        <th>Date&Time</th>
                        <th>Category Name</th>
                        <th>Creator Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
       <?php
        $ConnectDB;
        $Sql="SELECT * FROM category ORDER BY id desc";
        $Execute= $ConnectDB->query($Sql);
        $SrNo = 0;
        while ($DataRows=$Execute->fetch()){
            $CategoryId          = $DataRows["id"];
            $CategoryDate  = $DataRows["datetime"];
            $CategoryName     = $DataRows["title"];
            $CreatorName     = $DataRows["author"];
            $SrNo++;
        ?>
                <tbody>
                    <tr>
                        <td><?php echo htmlentities($SrNo); ?></td>
                        <td><?php echo htmlentities($CategoryDate); ?></td>
                        <td><?php echo htmlentities($CategoryName); ?></td>
                        <td><?php echo htmlentities($CreatorName); ?></td>
                        <td><a href="deletecategory.php?id=<?php echo $CategoryId; ?>" class="btn btn-danger">Delete</a></td>
                    </tr>
                </tbody>
            <?php   } ?>
                </table>
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