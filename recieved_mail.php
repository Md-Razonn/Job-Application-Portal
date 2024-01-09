

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





<?php
$sql = "SELECT mail_id, name, email, subject, message FROM mail";
echo '<table class="table ">
<thead>
<tr>
<th>Mail ID</font> </th>
<th> Name</font> </th>
<th> Email</font> </th>
<th> Subject</font> </th>
<th> Message</font> </th>
<th><font color="Red">Delete</font></th>
</tr>
</thead>';

if ($result = $conn->query($sql)) {

while ($row = $result->fetch_assoc()) {

$ID = $row["mail_id"];

$Name = $row["name"];
$email = $row["email"];
$sub = $row["subject"];
$msg = $row["message"];

echo '<tr>
<td>'.$ID.'</td>

<td>'.$Name.'</td>
<td>'.$email.'</td>
<td>'.$sub.'</td>
<td>'.$msg.'</td>

<td>
<button class="btn btn-primary"> <a href="mail_delete.php?
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