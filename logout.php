<?php
include_once("includes/functions.php");
include_once("includes/sessions.php");

$_SESSION["UserId"]=null;
$_SESSION["UserName"]=null;
$_SESSION["AdminName"]=null;
session_destroy();
Redirect_to("login.php");




?>


