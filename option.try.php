<?php
include_once("includes/DBConnect.php");

if(isset($_POST["Submit"])){
    $Category=$_POST['SelectCategory'];
    $PostTitle="PostTitle";
    $Image    ="name.jpeg";
    $PostText ="PostDescription";
    $Admin = "George";
    $dateTime="10:20:30pm";
    
    if (!empty("$Category")){

        $ConnectDB;
        $Sql="INSERT INTO post(datetime,title,category,author,image,post) VALUE('$dateTime','$PostTitle','$Category','$Admin','$Image','PostText')";
        $Stmt =$ConnectDB->prepare($Sql);
        $Execute=$Stmt->execute();

        echo "data successfulky added";

    }
    else {
        echo "pleae select any option!!!";
    }

    
    

}
else{

    echo "database not connected";
}


?>

<html>
<head>
<title>
</title>
</head>
<body>
    <form action="option.try.php" method="POST">
        <select  name="SelectCategory">
            <!-- Fetching all the category from the category table in the DB -->
                <?php
                    $ConnectDB;
                    $sql = "SELECT id,title FROM category";
                    $Stmt = $ConnectDB->query($sql);
                    while($DataRow=$Stmt->fetch()){
                    $id             = $DataRow["id"];
                    $CategoryName   = $DataRow["title"];
                ?>
                <option ><?php echo $CategoryName; ?></option>                                    
                <?php } ?>
        </select>
        <button type="submit" name="Submit">clik</button>
    </form>
</body>

</html>
