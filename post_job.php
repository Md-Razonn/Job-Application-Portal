<?php

@include 'config.php';

if(isset($_POST['submit'])){

   $Title = mysqli_real_escape_string($conn, $_POST['Title']);
   $Location = $_POST['Location'];
   $Salary = mysqli_real_escape_string($conn, $_POST['Salary']);
   $Description = mysqli_real_escape_string($conn, $_POST['Description']);
  

  
         $insert = "INSERT INTO job_offer(Title, Location, Salary, Description) VALUES('$Title','$Location','$Salary','$Description')";
         mysqli_query($conn, $insert);
         header('location:post_job.php');
      
   

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
 <div> Job Title: <input type="text" name="Title" value="" required placeholder="Enter job title" 
 style="width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 4px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;"/> </br>
  Location: <select name="Location" required style="width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 4px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;">
       
        <option selected>Location</option>
         <option value="DHAKA">DHAKA</option>
         <option value="BARISAL">BARISAL</option>
         <option value="CHITTAGONG">CHITTAGONG</option>
         <option value="KHULNA">KHULNA</option>
         <option value="MYMENSINGH">MYMENSINGH</option>
         <option value="RAJSHAHI">RAJSHAHI</option>
         <option value="RANGPUR">RANGPUR</option>
         <option value="SYLHET">SYLHET</option>
         </select>
 </br>
  Salary: <input type="text" name="Salary" required placeholder="enter salary of the job"
 style="width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 4px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;"/></br>


Description: <input type="text" name="Description" required placeholder="Enter the description about the job"
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
$sql = "SELECT id, Title, Location, Salary, Description FROM job_offer";
echo '<table style="width:60%;border:5px solid green;margin-left:auto;margin-right:auto;" border="2">
<tr>
<th>ID</font> </th>
<th> Title</font> </th>
<th> Location</font> </th>
<th> Salary</font> </th>
<th> Description</font> </th>
<th><font color="green">Update</font></th>
<th><font color="Red">Delete</font></th>
</tr>';

if ($result = $conn->query($sql)) {

while ($row = $result->fetch_assoc()) {

$ID = $row["id"];

$Title = $row["Title"];
$Location = $row["Location"];
$Salary = $row["Salary"];
$Description = $row["Description"];

echo '<tr>
<td>'.$ID.'</td>
<td>'.$Title.'</td>
<td>'.$Location.'</td>
<td>'.$Salary.'</td>
<td>'.$Description.'</td>

<td>

<button class="btn btn-primary"> <a href="single_edit.php?
updateid='.$ID.'" style="color: white;" >Update</a></button>

</td>



<td><form action="" method="POST">
                        <input type="hidden" name="deleteid" value="'.$ID.'">
                        <input type="submit" name="delete" value="Delete" class="btn btn-primary">
                    </form></td>



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