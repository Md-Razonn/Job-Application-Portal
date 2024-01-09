<?php

@include 'config.php';

session_start();
$userName = isset($_SESSION['userName']) ? $_SESSION['userName'] : '';
$userEmail = isset($_SESSION['userEmail']) ? $_SESSION['userEmail'] : '';


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

      <h1>Thank You <span><?php echo $userName ?></span></h1>
      <p>Your Payment is successfully</p>
      

      <a href="job-list.php?userName=<?php echo urlencode($userName); ?>&userEmail=<?php echo urlencode($userEmail); ?>" class="btn">Close</a>
   </div>

</div>

</body>
</html>