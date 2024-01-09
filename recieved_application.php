

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
$sql = "SELECT * FROM apply_job";
echo '<table class="table ">
<thead>
<tr>
<th>Job ID</font> </th>
<th>Job Title</font> </th>
<th>Applicant ID</font> </th>
<th> Name</font> </th>
<th> Email</font> </th>
<th> Number</font> </th>
<th> Letter</font> </th>
<th>Additional File</th>
</tr>
</thead>';

if ($result = $conn->query($sql)) {

while ($row = $result->fetch_assoc()) {


    $job_title = $row["job_title"];
    $job_id = $row["job_id"];    
$ID = $row["apply_id"];
$Name = $row["name"];
$email = $row["email"];
$number = $row["number"];
$letter = $row["letter"];
$file = $row["file"];

echo '<tr>
<td>'.$job_id.'</td>
<td>'.$job_title.'</td>

<td>'.$ID.'</td>
<td>'.$Name.'</td>
<td>'.$email.'</td>
<td>'.$number.'</td>
<td>'.$letter.'</td>

<td>
<button class="btn btn-primary"> <a href="download.php?
file='.$file.'"><font color="white">Download</font></a></button>

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