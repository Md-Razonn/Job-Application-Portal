<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['user_name'])){
   header('location:login_form.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>user page</title>

   <link rel="stylesheet" href="css_login/style.css">

</head>
<body>
   
<div class="container">

   <div class="content">

      <h1>Thank You <span><?php echo $_SESSION['user_name'] ?></span></h1>
      <p>Your Payment is successfully</p>
      

      <a href="logout.php" class="btn">Close</a>
   </div>

</div>

</body>
</html>