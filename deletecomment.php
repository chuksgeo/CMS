<?php
include_once("includes/DBConnect.php");
include_once("includes/functions.php");
include_once("includes/sessions.php");

$_SESSION["trackingURL"]=$_SERVER["PHP_SELF"];
confirm_login();



if (isset($_GET["id"])) {
   
    $SearchQuerParameter=$_GET["id"];

    $ConnectDB;

    $Admin = $_SESSION["AdminName"];
    $Sql = "DELETE FROM comment  WHERE id='$SearchQuerParameter'";
    $Execute=$ConnectDB->query($Sql);
    
    if($Execute){
        $_SESSION["SuccessMessage"]="Comment Deleted Successfully!!!";
             Redirect_To("comments.php");
    }
    else{
        $_SESSION["ErrorMessage"]="Sorry Something when wrong try again!!!";
             Redirect_To("comments.php");
    }
}




?>