<?php
@include 'config.php';
session_start();

if (!isset($_SESSION['admin_name']) || !isset($_SESSION['admin_email'])) {
    header('location: login_form.php');
}

if (isset($_SESSION['admin_name']) || isset($_SESSION['admin_email'])) {
    $admin_name = $_SESSION['admin_name'];
    $admin_email = $_SESSION['admin_email'];
}

$errors = array();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Close the database connection
$conn->close();
?>


<?php
include 'config.php';

if (isset($_POST['delete_id'])) {
    $deleteCompanyId = $_POST['delete_id'];

    $deleteCompanyQuery = "DELETE FROM user_form WHERE id = '$deleteCompanyId'";
    $deleteCompanyResult = mysqli_query($conn, $deleteCompanyQuery);

    if ($deleteCompanyResult) {
        header("Location: AdminPanel.php");
        exit();
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}

if (isset($_POST['delete_job_id'])) {
    $deleteJobId = $_POST['delete_job_id'];

    $deleteJobQuery = "DELETE FROM job_posts WHERE id = '$deleteJobId'";
    $deleteJobResult = mysqli_query($conn, $deleteJobQuery);

    if ($deleteJobResult) {
        header("Location: AdminPanel.php");
        exit();
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin Panel</title>
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

    <!--  Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    
    <link href="css/style.css" rel="stylesheet">
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
            <a href="index.html" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
                <h1 class="m-0 text-primary">ADMIN PANEL</h1>
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                
                <a href="AdminPanel.php" class="nav-item nav-link active">Home</a>
                    <a href="jobSeeker.php" class="nav-item nav-link active">Job Seekers</a>
                </div>
            </div>
        </nav>
        <!-- Navbar End -->

        <!-- Carousel Start -->
        <div class="container-fluid p-0">
            <div class="owl-carousel header-carousel position-relative">
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid" src="img/pexels-lex-photography-1109543.jpg" alt="">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(43, 57, 64, .5);">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-10 col-lg-8">
                                    <h1 class="display-3 text-white animated slideInDown mb-4">Find The Perfect Job That You Deserved</h1>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid" src="img/pexels-vojtech-okenka-392018.jpg" alt="">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(43, 57, 64, .5);">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-10 col-lg-8">
                                    <h1 class="display-3 text-white animated slideInDown mb-4">Find The Best Startup Job That Fits You</h1>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Carousel End -->

        <!-- Search Start -->
        <!-- Search End -->

        <!-- Category Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Manage Company </h1>
               
            </div>
        </div>
        <!-- Category End -->

        <!-- About Start -->
        <!-- About End -->

        <?php
        $select = mysqli_query($conn, "SELECT * FROM user_form WHERE user_type='company' ");

        if (!$select) {
            $message[] = 'Error: ' . mysqli_error($conn);
        } elseif (mysqli_num_rows($select) > 0) {
            while ($row = mysqli_fetch_assoc($select)) {
                $CName = $row['name'];
                $Email = $row['email'];
                $Phone = $row['number'];
                $id = $row['id'];
                echo '
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="job-item p-4 mb-4">
                            <div class="row g-4">
                                <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                    
                                    <div class="text-start ps-4">
                                        <h5 class="mb-3">' . $CName . '</h5>
                                        <span class="text-truncate me-3">Email

:' . $Email . '<br>Contact Number:' . $Phone . '</span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                                <div class="d-flex mb-3">
                                                    
                                                    <form method="POST" action="AdminPanel.php">
    <input type="hidden" name="delete_id" value="' . $id . '">
    <button type="submit" class="btn btn-danger btn-square" onclick="return confirm("Are you sure you want to delete?")">
        <i class="far fa-trash-alt"></i>
    </button>
</form>
                                                </div>
                                            </div>
                            </div>
                        </div>
                    </div>';
            }
        }
        ?>
        <!-- Display Companies End -->

        <!-- Manage Posted Jobs Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Manage Posted Jobs</h1>
                <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.3s">
                    <!-- ... (Your existing tab content) ... -->
                </div>
                <?php
                $selectJobs = mysqli_query($conn, "SELECT * FROM job_posts ");

                if (!$selectJobs) {
                    $message[] = 'Error: ' . mysqli_error($conn);
                } elseif (mysqli_num_rows($selectJobs) > 0) {
                    while ($row = mysqli_fetch_assoc($selectJobs)) {
                        $title = $row['job_title'];
                        $location = $row['job_location'];
                        $ssalary = $row['salary_from'];
                        $esalary = $row['salary_to'];
                        $due_date = $row['due_date'];
                        $id = $row['id'];

                        echo '
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane fade show p-0 active">
                                    <div class="job-item p-4 mb-4">
                                        <div class="row g-4">
                                            <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                                
                                                <div class="text-start ps-4">
                                                    <h5 class="mb-3">' . $title . '</h5>
                                                    <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>' . $location . '</span>
                                                    <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i>' . $ssalary . '-' . $esalary . 'TK</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                            <div class="d-flex mb-3">
                                            
                                            <form method="POST" action="AdminPanel.php">
    <input type="hidden" name="delete_job_id" value="' . $id . '">
    <button type="submit" class="btn btn-danger btn-square" onclick="return confirm("Are you sure you want to delete?")">
        <i class="far fa-trash-alt"></i>
    </button>
</form>
                                        </div>
                                                <small class="text-truncate"><i class="far fa-calendar-alt text-primary me-2"></i>Date Line: ' . $due_date . '</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    }
                }
                ?>
            </div>
            </div>
        </div>
        <!-- Manage Posted Jobs End -->

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
                            <a href="logout.php" name="" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Log Out</a>
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
