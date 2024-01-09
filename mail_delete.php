<?php

include_once('config.php');

?>

<?php
    
        if(isset($_GET['deleteid']))

{

$st_id= $_GET['deleteid'];

$sql = "DELETE FROM mail WHERE mail_id='$st_id'";

$run =mysqli_query($conn,$sql) or die(mysqli_query());

if($run){

echo "<h1>Data Deleted</h1>";

header("location:recieved_mail.php");

}

else{

echo "<h1> Data not Deleted</h1>";

}

}

$mysqli ->close();
 


?>