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

if (isset($_POST['submit'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $university = mysqli_real_escape_string($conn, $_POST['university']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $cgpa = mysqli_real_escape_string($conn, $_POST['cgpa']);
    $Category = $_POST['categories'];
    $password = $_POST['password'];
    $pass = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);
    $user_type = "Job Seeker";

    $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {

        $error[] = 'user already exists!';
    } else {


      if ($pass != $cpass) {
         $error[] = 'password not matched!';
     }

   

    else if (is_valid_password($password)==false) {
      $error[] = "Password must be at least 6 characters long and contain at least one uppercase letter, one lowercase letter, one number and one special character .";
  }

        else if (empty($name)) {
            $error[] = "Your name is required.";
        } else if (!preg_match("/^[a-zA-Z .]+$/", $name)) {
            $error[] = "Your name can only contain alphabets and spaces.";
        } else if (empty($email)) {
            $error[] = "Your e-mail is required.";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strpos($email, '.') === false) {
         $error[] = "Invalid email format. Email must contain a dot '.'.";
        } else if (empty($number)) {
            $error[] = "Your contact number is required.";
        } else if (strlen($number) != 11 || substr($number, 0, 2) !== "01") {
            $error[] = "Contact number must be 11 digits and start with '01'.";
        } else if (empty($university)) {
            $error[] = "Your University name is required.";
        } else if (!preg_match("/^[a-zA-Z ]+$/", $university)) {
            $error[] = "Your university name can only contain alphabets and spaces.";
        } else if (empty($department)) {
            $error[] = "Your department name is required.";
        } else if (!preg_match("/^[a-zA-Z ]+$/", $department)) {
            $error[] = "Your department name can only contain alphabets.";
        } else if (empty($cgpa) || !is_numeric($cgpa) || $cgpa < 0.00 || $cgpa >= 4.00) {
         $error[] = "CGPA must be a numeric value between 0.00 and 4.00 exclusive.";
     } 

        else if ($Category == 'Categories') {
         $error[] = "Please select your interested area.";
     }
         else if (empty($pass)) {
            $error[] = "Password is required for Log-in.";
        } else if (empty($cpass)) {
            $error[] = "You don't confirm your password.";
        }  
         else {
            $insert = "INSERT INTO user_form(name, email, number, university, department, cgpa, interest, password, user_type) 
                       VALUES('$name','$email','$number','$university','$department','$cgpa','$Category','$pass','$user_type')";
            mysqli_query($conn, $insert);
            header('location:login_form.php');
        }
    }
}
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
   <link href="css/style.css" rel="stylesheet">


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
      <input type="text" name="name" required placeholder="enter your name">
      <input type="email" name="email" required placeholder="enter your email">
      <input type="text" name="number" required placeholder="enter your Contact Number">
      <input type="text" name="university" required placeholder="enter your University Name">
      <input type="text" name="department" required placeholder="enter your Department">
      <input type="text" name="cgpa" required placeholder="enter your Average CGPA in University">

      <div class="form-floating">
                        <label for="categories">Interested Areas</label>
                        <div class="col-md-6">
                                    <select name="categories" id="categories" class="form-floating" style="width: 100%; padding: 12px 20px; margin: 8px 0; display: inline-block; border-radius: 4px; box-sizing: border-box;" onchange="changeCategory()">
       
          <option selected>Categories</option>
          <option value="Information Technology">Information Technology</option>
          <option value="Engineering">Engineering</option>
          <option value="Healthcare">Healthcare</option>
          <option value="Finance">Finance</option>
          <option value="Education">Education</option>
          <option value="Sales and Marketing">Sales and Marketing</option>
          <option value="Creative Arts">Creative Arts</option>
          <option value="Human Resources">Human Resources</option>
          <option value="Manufacturing and Production">Manufacturing and Production</option>
          <option value="Customer Service">Customer Service</option>
          <!-- Add more categories as needed -->
        </select>
      </div>

      

      <input type="password" name="password" required placeholder="enter your password">
      <input type="password" name="cpassword" required placeholder="confirm your password">

      

      <div class="form-floating">
                        <label for="Job Seekers">User Type</label>
                        <input type="text" name="Job Seekers" id="Job Seekers" placeholder="Job Seekers" value="Job Seekers" readonly>
                    </div>
      <input type="submit" name="submit" value="register now" class="form-btn">
      <p>already have an account? <a href="login_form.php">login now</a></p>
   </form>

</div>



</body>
</html>