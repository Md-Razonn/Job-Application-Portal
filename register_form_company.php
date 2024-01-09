<?php

@include 'config.php';

function is_valid_password($password) {
   // Password must be at least 6 characters long
   if (strlen($password) < 6) {
       return false;
   }

   // Check for at least one uppercase letter, one lowercase letter, one number, and one special character
   if (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[^a-zA-Z0-9]/', $password)) {
       return false;
   }

   // Password meets all criteria
   return true;
}

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $number = mysqli_real_escape_string($conn, $_POST['number']);
   $Location = $_POST['location'];
   $password = $_POST['password'];
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $user_type = "company";

   $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $error[] = 'user already exist!';

   }else{

      if ($pass != $cpass) {
         $error[] = 'password not matched!';
     }
     else if (is_valid_password($password)==false) {
      $error[] = "Password must be at least 6 characters long and contain at least one uppercase letter, one lowercase letter, one number and one special character .";
  } else if (!preg_match("/[a-zA-Z]/", $name) || !preg_match("/^[a-zA-Z0-9 .\-_]+$/", $name)) {
   $error[] = "Your company name must contain at least one alphabet character and can include alphabets, numbers, spaces, dots, hyphens, and underscores.";
}
else if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strpos($email, '.') === false) {
   $error[] = "Invalid email format. Email must contain a dot '.'.";
  } else if (strlen($number) != 11 || substr($number, 0, 2) !== "01") {
   $error[] = "Contact number must be 11 digits and start with '01'.";
} else if ($Location == 'Location') {
   $error[] = "Please select your company location.";
}
  else{
         $insert = "INSERT INTO user_form(name, email, number, location, password, user_type) VALUES('$name','$email','$number','$Location','$pass','$user_type')";
         mysqli_query($conn, $insert);
         header('location:login_form.php');
      }
   }

};


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css_login/style.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>register now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="name" required placeholder="enter your company name">
      <input type="email" name="email" required placeholder="enter your companies email">
      <input type="text" name="number" required placeholder="enter your companies Contact Number">
      <select name="location" id="location" class="col-12" style="width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
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
      <input type="password" name="password" required placeholder="enter your password">
      <input type="password" name="cpassword" required placeholder="confirm your password">
      <div class="form-floating">
                        <label for="company">User Type</label>
                        <input type="text" name="company" id="company" placeholder="company" value="company" readonly>
                    </div>
      <input type="submit" name="submit" value="register now" class="form-btn">
      <p>already have an account? <a href="login_form.php">login now</a></p>
   </form>

</div>

</body>
</html>