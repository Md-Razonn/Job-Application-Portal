
<?php
include_once('config.php');
?>

<?php

$id= $_GET['updateid'];
$sql= "SELECT * FROM job_offer WHERE id=$id";
$result=mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);


$Title= $row['Title'];
$Location= $row['Location'];
$Salary= $row['Salary'];
$Description= $row['Description'];


if(isset($_POST['submit'])){
$Title= $_POST['Title'];
$Location= $_POST['Location'];
$Salary= $_POST['Salary'];
$Description= $_POST['Description'];

$sql = "UPDATE job_offer SET id=$id, Title='$Title', Location='$Location',Salary='$Salary',Description='$Description' where id=$id ";

$run =mysqli_query($conn,$sql) or die(mysqli_query());

if($run){

echo "<h1>Data Edited</h1>";

header("location:post_job.php");

}

else{

echo "<h1> Data not Edited </h1>";
}

}

?>

<form action="#" method="post" style="width:60%;border:5px solid green;margin-left:auto;margin-right:auto;">
 <div> Job Title: <input type="text" name="Title" value=<?php echo$Title;?> 
 style="width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 4px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;"/> </br>
  Location: <select name="Location" value="<?php echo$Location;?>" style="width: 100%;
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
  Salary: <input type="text" name="Salary" value=<?php echo$Salary;?>
 style="width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 4px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;"/></br>


Description: <input type="text" name="Description" value=<?php echo$Description;?>
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