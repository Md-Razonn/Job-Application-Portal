<?php

@include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $user_type = $_POST['user_type'];

   $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $error[] = 'user already exist!';

   }else{

      if($pass != $cpass){
         $error[] = 'password not matched!';
      }else{
         $insert = "INSERT INTO user_form(name, email, password, user_type) VALUES('$name','$email','$pass','$user_type')";
         mysqli_query($conn, $insert);
         header('location:view_users.php');
      }
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
 <div> Name: <input type="text" name="name" value="" required placeholder="enter your name" 
 style="width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 4px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;"/> </br>
 Email: <input type="email" name="email" required placeholder="enter your email"
 style="width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 4px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;"/></br>
  Enter password: <input type="password" name="password" required placeholder="enter your password"
 style="width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 4px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;"/></br>

Conferm password: <input type="password" name="cpassword" required placeholder="confirm your password"
 style="width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 4px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;"/></br>

Select User: <select name="user_type" style="width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 4px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;">
         <option value="user">user</option>
         <option value="admin">admin</option>
         </select>
 </br>

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
$sql = "SELECT id, name, email, user_type FROM user_form";
echo '<table class="table ">
<thead>
<tr>
<th>ID</font> </th>
<th> User Name</font> </th>
<th> Email</font> </th>
<th> User Type</font> </th>
<th><font color="Red">Delete</font></th>
</tr>
</thead>';

if ($result = $conn->query($sql)) {

while ($row = $result->fetch_assoc()) {

$ID = $row["id"];

$Name = $row["name"];
$email = $row["email"];
$user = $row["user_type"];

echo '<tr>
<td>'.$ID.'</td>

<td>'.$Name.'</td>
<td>'.$email.'</td>
<td>'.$user.'</td>

<td>
<button class="btn btn-primary"> <a href="single_delete.php?
deleteid='.$ID.'"><font color="Red">Delete</font></a></button>

</td>

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