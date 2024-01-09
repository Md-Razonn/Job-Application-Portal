<?php

@include 'config.php';

if(isset($_POST['submit'])){

   $sDec = mysqli_real_escape_string($conn, $_POST['sDec']);
   $lDec = mysqli_real_escape_string($conn, $_POST['lDec']);

  

  
         $insert = "UPDATE `about` SET `sDec`='$sDec',`lDec`='$lDec' WHERE id='1'";
         //UPDATE `about` SET `sDec`='$sDec',`lDec`='$lDec' WHERE id='1'
         mysqli_query($conn, $insert);
         header('location:index_admin.php');
      
   

};



if (isset($_POST['delete'])) {
   $deleteID = $_POST['deleteid'];
       
   $deleteResult = mysqli_query($conn, "DELETE FROM `job_offer` WHERE `id`='$deleteID'");
   
   if ($deleteResult) {
       header('Location: post_job.php');
       exit();
   } else {
       die('Query failed');
   }
};




?>



<!DOCTYPE html>
<html>
<head>
  <title>Admin</title>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
       <link rel="stylesheet" href="./assets/css/style.css"></link>
  </head>
</head>
<body >
    
        <?php
            include "./adminHeader.php";
            include "./sidebar.php";
            include_once "config.php";
        ?>



<form action="" method="post" style="width:60%;border:5px solid green;margin-left:auto;margin-right:auto;">
 <div> Small Description: <input type="text" name="sDec" value="" required placeholder="Enter a small description" 
 style="width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 4px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;"/> </br>
 
 Large Description: <input type="text" name="lDec" required placeholder="Enter a large description"
 style="width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 4px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;"/></br>

 <input type="submit" name="submit" value="Insert" 
 style="width: 10%;
  background-color: Blue;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;"/></div>
 </form>

 




<?php
$sql = "SELECT  sDec,lDec FROM about";
echo '<table style="width:60%;border:5px solid green;margin-left:auto;margin-right:auto;" border="2">
<tr>
<th>Small Description</font> </th>
<th> Large Description</font> </th>
</tr>';

if ($result = $conn->query($sql)) {

while ($row = $result->fetch_assoc()) {


$sDec = $row["sDec"];
$lDec = $row["lDec"];


echo '<tr>
<td>'.$sDec.'</td>
<td>'.$lDec.'</td>





</tr>';

}

$result->free();

}

$conn ->close();


?>

    
            
      


    <script type="text/javascript" src="./assets/js/ajaxWork.js"></script>    
    <script type="text/javascript" src="./assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
 
</html>