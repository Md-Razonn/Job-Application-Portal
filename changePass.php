<?php

@include 'config.php';

$userName = isset($_GET['userName']) ? urldecode($_GET['userName']) : '';
$userEmail = isset($_GET['userEmail']) ? urldecode($_GET['userEmail']) : '';

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

// Initialize an empty array for messages
$message = array();

if(isset($_POST['submit'])){
    $C_pass = md5($_POST['c_password']);
    $password = $_POST['password'];
    $pass = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);

    if (empty($C_pass) || empty($pass) || empty($cpass)) {
        $message[] = "Fill all the given fields.";
    } else {
        if ($pass != $cpass) {
            $message[] = 'Password not matched!';
        } else if (is_valid_password($password) == false) {
            $message[] = "Password must be at least 6 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
        } else {
            $stmt = $conn->prepare("SELECT password FROM `user_form` WHERE `email` = ?");
            $stmt->bind_param("s", $userEmail);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) {
                // Fetch the data from the result set
                $row = $result->fetch_assoc();

                if ($row) {
                    // Extract university and cgpa values
                    $currentpass = $row['password'];
                    if ($C_pass == $currentpass) {
                        $update = mysqli_query($conn, "UPDATE `user_form` SET `password`='$pass' WHERE `email`='$userEmail'");
                        header("Location: index.php");
                    } else {
                        $message[] = 'This is not the current password';
                    }
                }
            }
        }
    }
}
?>
<html>
<head>
<title>Change Password</title>
<link rel="stylesheet" type="text/css" href="Pass.css" />
<link rel="stylesheet" type="text/css" href="form.css" />
</head>
<body>
    <div class="phppot-container tile-container">
        <form name="frmChange" method="post" action=""
            onSubmit="return validatePassword()">

            <div class="validation-message text-center"><?php if(isset($message)) { echo implode('<br>', $message); } ?></div>

            <h2 class="text-center">Change Password</h2>
            <div>
                <div class="row">
                    <label class="inline-block">Current Password</label>
                    <span id="currentPassword"
                        class="validation-message"></span> <input
                        type="password" name="c_password"
                        class="full-width">

                </div>
                <div class="row">
                    <label class="inline-block">New Password</label> <span
                        id="newPassword" class="validation-message"></span><input
                        type="password" name="password"
                        class="full-width">

                </div>
                <div class="row">
                    <label class="inline-block">Confirm Password</label>
                    <span id="confirmPassword"
                        class="validation-message"></span><input
                        type="password" name="cpassword"
                        class="full-width">

                </div>
                <div class="row">
                    <input type="submit" name="submit" value="Submit"
                        class="full-width">
                </div>
            </div>

        </form>
    </div>
</body>
</html>