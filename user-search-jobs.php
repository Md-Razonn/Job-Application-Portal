
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    

    <!--  Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">
</head>
<body>


<!-- Search Start -->
<div class="container-fluid bg-primary mb-5 wow fadeIn" data-wow-delay="0.1s" style="padding: 35px;">
<form action="#" method="post">

<div class="container" style="background-color:#08b474";>
                <div class="row g-2">
                    <div class="col-md-10">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <input type="text" name="Title" class="form-control border-0" placeholder="Keyword" />
                            </div>
                            <div class="col-md-4">
                                <select class="form-select border-0" name="Location">
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
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        
                        <input class="btn btn-dark border-0 w-100" type="submit" name="search" value="Search"/>

                    </div>
                </div>
            </div>

</form>

</div>


<?php
 @include 'config.php';

if(isset($_POST['search'])){

$Title= $_POST['Title'];
$Location= $_POST['Location'];


$sql = "SELECT  id, Title, Location, Salary FROM job_offer WHERE Title = '$Title' && Location = '$Location'" ;


//$run =mysqli_query($conn,$sql);

if ($result = $conn->query($sql)) {

    while ($row = $result->fetch_assoc()) {
    
    $ID   = $row["id"]; 
    $Title = $row["Title"];
    $Location = $row["Location"];
    $Salary = $row["Salary"];
    
    
    
    
    
    
    
    
    echo '<div id="tab-1" class="tab-pane fade show p-0 active">
    <div class="job-item p-4 mb-4">
        <div class="row g-4">
            <div class="col-sm-12 col-md-8 d-flex align-items-center">
                
                <div class="text-start ps-4">
    
    
                <h5 class="mb-3">'.$Title.'</h5>
    <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>'.$Location.'</span>
    <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i>'.$Salary. 'TK</span>                                  
                </div>
            </div>
            <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                <div class="d-flex mb-3">
                    <a class="btn btn-primary" href="job-detail.php?jobid='.$ID.'">Apply Now</a>
                    
                </div>
            </div>
        </div>
    </div>
    
    </div>
    ';
    
    }
    
    $result->free();
    
    }
    
    $conn ->close();

}
    
    
    ?>
        <!-- Search End -->
    
</body>
</html>





