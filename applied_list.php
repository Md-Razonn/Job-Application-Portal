<?php
        @include 'config.php';
        $userName = isset($_GET['userName']) ? urldecode($_GET['userName']) : '';
        $userEmail = isset($_GET['userEmail']) ? urldecode($_GET['userEmail']) : '';


 ?>    


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>JobEntry - Job Portal Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <style>
    .profile-pic {
        border-radius: 50%;
        overflow: hidden;
        width: 40px; /* Adjust the width and height as needed */
        height: 40px;
        margin-right: 10px; /* Adjust the spacing as needed */
    }

    .profile-pic img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar Start -->
        <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
            <a href="index.php" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
                <h1 class="m-0 text-primary">Job Application Portal</h1>
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="index.php" class="nav-item nav-link">Home</a>
                    <a href="about.php?userName=<?php echo urlencode($userName); ?>&userEmail=<?php echo urlencode($userEmail); ?>" class="nav-item nav-link">About</a>
                    <a href="job-list.php?userName=<?php echo urlencode($userName); ?>&userEmail=<?php echo urlencode($userEmail); ?>" class="nav-item nav-link">Jobs</a>
                    <a href="applied_list.php?userName=<?php echo urlencode($userName); ?>&userEmail=<?php echo urlencode($userEmail); ?>" class="nav-item nav-link">Applied List</a>
                    <a href="contact.php?userName=<?php echo urlencode($userName); ?>&userEmail=<?php echo urlencode($userEmail); ?>" class="nav-item nav-link">Contact</a>
                </div>
                
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 profile-menu"> 
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="profile-pic">
                    
                    <img class="img-fluid w-100" src="img/teacher-1.png" alt="Profile Picture">
                </div>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="changePass.php?userName=<?php echo urlencode($userName); ?>&userEmail=<?php echo urlencode($userEmail); ?>"><i class="fas fa-cog fa-fw"></i> Change Password</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt fa-fw"></i> Log Out</a></li>
          </ul>
        </li>
    </ul>
    </div>
        </nav>
        <!-- Navbar End -->


        <!-- Header End -->
        <div class="container-xxl py-5 bg-dark page-header mb-5">
            <div class="container my-5 pt-5 pb-4">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Job List</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb text-uppercase">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Job List</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Header End -->


        <!-- Jobs Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Job Listing</h1>
                <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.3s">
                    
                            <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 active" data-bs-toggle="pill" href="#tab-1">
                                <h6 class="mt-n1 mb-0">Latest Posted Job List</h6>
                            </a>
                        
                    <div class="tab-content">



                    <?php
                        @include 'config.php';
//$sql = "SELECT  id, Title, Location, Salary FROM job_offer";

$userName = isset($_GET['userName']) ? urldecode($_GET['userName']) : '';
$userEmail = isset($_GET['userEmail']) ? urldecode($_GET['userEmail']) : '';
$sql = "SELECT job_id FROM apply WHERE `name`= '$userName' AND `email`= '$userEmail'";


if ($result = $conn->query($sql)) {
    $i=0;

while ($row = $result->fetch_assoc()) {

    $job_id = $row["job_id"];

    $sql1 = "SELECT * FROM `job_posts` WHERE `id`= '$job_id'";


if ($result1 = $conn->query($sql1)) {
    $j=0;

while ($row1 = $result1->fetch_assoc()) {

    $ID = $row1["id"]; 
    $companyName = $row1["company_name"];
$Title = $row1["job_title"];
$Location = $row1["job_location"];
$Salary1 = $row1["salary_from"];
$Salary2 = $row1["salary_to"];
$Date_line = $row1["due_date"];
$vacancy=$row1["vacancy"];



echo '<div id="tab-1" class="tab-pane fade show p-0 active">
    <div class="job-item p-4 mb-4">
    <div class="row g-4">
    <div class="col-sm-12 col-md-8 d-flex align-items-center">
        
        <div class="text-start ps-4">
    
    
        <h5 class="mb-3">'.$Title.'</h5>
        <span class="text-truncate me-3"><i class="fa fa-angle-right text-primary me-2"></i>'.$companyName.'  </span>
        <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>'.$Location.'  </span>
    <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i>'.$Salary1. '-' .$Salary2.'TK</span>    
    <span class="text-truncate me-3"><i class="far fa-calendar-alt text-primary me-2"></i>Vacancy = '.$vacancy.' Position</span>                              
        </div>
    </div>
    <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
    <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
    <div class="d-flex mb-3">
    <a class="btn btn-primary" href="details.php?jobid='.$ID.'&userName='.$userName.'&userEmail='.$userEmail.'">Job Details</a>
        
    </div>
</div>
                                            <small class="text-truncate"><i class="far fa-clock text-primary me-2"></i>Date Line: '.$Date_line.'</small>
                                        </div>
    
    </div>
    
    </div>
    
    </div>
    ';
$j=$j+1;

}

$result1->free();
}



$i=$i+1;

}

$result->free();

}



?>
                        

                       
                        
        <!-- Jobs End -->


        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    
                    
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Contact</h5>
                      <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>442/f1 Shapla soroni,Mirpur Dhaka</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>016********</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>aminulislam1@gmail.com</p>
                       
                    </div>
                    <div class="col-lg-3 col-md-6" style="margin-left: 600px;">
                        <h5 class="text-white mb-4">Log Out</h5>
                        <p>If you done please logout.</p>
                        <div class="position-relative mx-auto" style="max-width: 100px;">
                            <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="">
                            <a href="logout.php" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Log Out</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">JOB PORTAL</a> 
							

							Designed By <a class="border-bottom" href="https://www.facebook.com/profile.php?id=100027742145793">Md Aminul Islam Sajib</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>