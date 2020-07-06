<?php
include_once("includes/DBConnect.php");
include_once("includes/functions.php");
include_once("includes/sessions.php");

if (isset($_SESSION["UserId"])) {
    Redirect_To("dashboard.php");
}

if (isset($_POST["Submit"])) {
        $Username        = $_POST["Username"];
        $Password        = $_POST["Password"];

    if(empty($Username)||empty($Password)){
        $_SESSION["ErrorMessage"]="All field must be filled!!!";
        Redirect_To("login.php");
    }
    else{
// Query to insert Data into our DB
    $LoginAccount=Login_Attempt($Username,$Password);
        if ($LoginAccount) {
            $_SESSION["UserId"]=$LoginAccount["id"];
            $_SESSION["UserName"]=$LoginAccount["username"];
            $_SESSION["AdminName"]=$LoginAccount["aname"];

            $_SESSION["SuccessMessage"]="Welcome " . $_SESSION["AdminName"];
            if (isset($_SESSION["TrackingURL"])){
                Redirect_To($_SESSION["TrackingURL"]);
            }
            else {
                Redirect_To("dashboard.php");
            }
        }
        else{
            $_SESSION["SuccessMessage"]="Incorrect Username/Password";
            Redirect_To("login.php");
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
    <title>Login</title>
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
                
        </div>
        </nav>
    <div style="height:10px; background:#27aae1"></div>
<!-- End of Navigation Menu-Bar -->
<!-- Heaer -->
    <Header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    
                </div>
            </div>
        </div>
    </Header>
<!-- Main Area Section -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-sm-3 col-sm-6" style= "min-height:409px;"><br><br>
    <?php
        echo ErrorMessage();
        echo SuccessMessage();
    ?>
                <div class="card bg-secondary text-light">
                    <div class="cad-header">
                        <h4>Welcome Back!</h4>
                    </div>
                    <div class="card-body bg-dark">                      
                        <form action="login.php" method="post">
                            <div class="form-group">
                                <label for="username">
                                    <span class="fieldinfo">Username: </span>
                                </label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="inptu-group-text text-white bg-info"></span>
                                    </div>
                                    <input type="text"  class="form-control" name="Username" id="username">
                                </div>
                                <label for="password">
                                    <span class="fieldinfo">Password: </span>
                                </label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="inptu-group-text text-white bg-info"></span>
                                    </div>
                                    <input type="password"  class="form-control" name="Password" id="password">
                                </div>
                                <input type="submit" class="btn btn-info btn-block" name="Submit" value="Login">
                            </div>
                        </form>
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