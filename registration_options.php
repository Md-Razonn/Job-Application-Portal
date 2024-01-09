





<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Type</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style2.css">

</head>
<body>
   
<div class="form-container">

   
      <form action="" method="post">
        <h3>User Type</h3>

        <input type="button" value="Company" class="form-btn" onclick="redirectToPage('company')">
        <input type="button" value="User" class="form-btn"onclick="redirectToPage('user')">
     </form>
</div>

<script>
    function redirectToPage(userType) {
        if (userType === 'company') {
            window.location.href = 'register_form_company.php'; 
        } else if (userType === 'user') {
            window.location.href = 'register_form.php'; 
        }
    }
</script>

</body>
</html>