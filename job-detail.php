
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


include_once('config.php');
$message = array();

$userName = isset($_GET['userName']) ? urldecode($_GET['userName']) : '';
$userEmail = isset($_GET['userEmail']) ? urldecode($_GET['userEmail']) : '';

$select2 = "SELECT * FROM apply WHERE job_id = '{$_GET['jobid']}' AND email = '$userEmail' AND payment_status = 'Unpayed'";


    $result2 = mysqli_query($conn, $select2);
    if (mysqli_num_rows($result2) > 0) {

        $sql = "DELETE FROM `apply` WHERE job_id = '{$_GET['jobid']}' AND email = '$userEmail' AND payment_status = 'Unpayed'";
        mysqli_query($conn, $sql);
    }

if(isset($_POST['submit'])){
    

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $university = mysqli_real_escape_string($conn, $_POST['university']);
    $cgpa = mysqli_real_escape_string($conn, $_POST['cgpa']);
    $pdf_name = $_FILES['pdf']['name'];
    $pdf_size = $_FILES['pdf']['size'];
    $pdf_tmp_name = $_FILES['pdf']['tmp_name'];
    $pdf_folder = 'uploaded_pdf/' . $pdf_name;
    $job_id=$_GET['jobid'];
    $payment_status="Unpayed";

 
        $select = " SELECT * FROM apply WHERE job_id = '$job_id' AND email = '$email' AND payment_status = 'Payed'";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {

        $message[] = 'You already apply for the job';
    }
    else{
        if($pdf_size > 2000000){
            $message[] = 'File size is too large!';
        }else{
            
            $insert = mysqli_query($conn, "INSERT INTO `apply`( `name`, `email`, `number`, `address`, `university`, `CGPA`, `CV`, `job_id`, `payment_status`) VALUES ('$name','$email','$number','$address','$university','$cgpa','$pdf_name','$job_id','$payment_status')");
            
    
            if ($insert) {
                move_uploaded_file($pdf_tmp_name, $pdf_folder);
                $message[] = 'Registered successfully!';
                
                // Start a session (if not already started)
                session_start();
                
                // Store the email in a session variable
                $_SESSION['userEmail'] = $userEmail;
                $_SESSION['job_id'] = $job_id;
                $_SESSION['userName'] = $userName;
                
                header("Location: payment.php");
                exit();
            }
            
            
            else{
                $message[] = 'Registration failed!';
            }
        }
    }
    

    
  
    
}
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
        .confirmation-bar {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
        }
    </style>
    <script>
        function showConfirmation() {
            // Display the confirmation message
            var message = "Form submitted successfully!";
            var confirmationBar = document.createElement("div");
            confirmationBar.classList.add("confirmation-bar");
            confirmationBar.textContent = message;
            document.body.prepend(confirmationBar);
        }
    </script>

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
                <h1 class="display-3 text-white mb-3 animated slideInDown">Job Detail</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb text-uppercase">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Job Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Header End -->




        <!-- Job Detail Start -->





        <?php
        @include 'config.php';

if(isset($_GET['jobid']))

{

$jobid= $_GET['jobid'];
$userName = isset($_GET['userName']) ? urldecode($_GET['userName']) : '';
$userEmail = isset($_GET['userEmail']) ? urldecode($_GET['userEmail']) : '';

$sql = "SELECT `id`, `company_name`, `job_description`, `job_title`, `job_category`, `job_location`, `salary_from`, `salary_to`, `email`, `experience_years`, `due_date`, `vacancy`, `exam_date` FROM `job_posts` WHERE id='$jobid'";// SELECT `id`, `Title`, `Location`, `Salary`, `Description` FROM `job_offer` WHERE id='$jobid'
$result = $conn->query($sql);

        if (!$result) {
            die('Error executing query: ' . $conn->error);
        }

    while ($row = $result->fetch_assoc()) {
    
        $companyName = $row['company_name'];
        $jobDescription = $row['job_description'];
        $jobTitle = $row['job_title'];
        $jobCategory = $row['job_category'];
        $jobLocation = $row['job_location'];
        $salaryFrom = $row['salary_from'];
        $salaryTo = $row['salary_to'];
        $email = $row['email'];
        $experience = $row['experience_years'];
        $dueDate = $row['due_date'];
        $vacancy = $row['vacancy'];
        $exam_date = $row['exam_date'];
    

        $sql = "SELECT `id`, `university`, `cgpa` FROM `user_form` WHERE `name` = '$userName' AND `email` = '$userEmail'";
$result = $conn->query($sql);

if ($result) {
    // Fetch the data from the result set
    $row = $result->fetch_assoc();

    if ($row) {
        // Extract university and cgpa values
        $userid = $row['id'];
        $university = $row['university'];
        $cgpa = $row['cgpa'];
    
    echo '<div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row gy-5 gx-4">
            <div class="col-lg-8">
                <div class="d-flex align-items-center mb-5">
                    <div class="text-start ps-4">
                        <h3 class="mb-3">'.$jobTitle.'        (Job ID-'.$jobid.')</h3>
                        <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>'.$jobLocation.'</span>
                        <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i>'.$salaryFrom. '-' .$salaryTo. 'TK</span>
                        </div>
                        </div>

                        <div class="mb-5">
                            <h4 class="mb-3">Job Description</h4>
                    <p>'.$jobDescription.'</p>




       
        
</div>
        
        <div class="">
            <h4 class="mb-4">Apply For The Job</h4>

    ';
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="alert alert-danger">'.$message.'</div>';
         }
      }
    echo '

                            <form method="POST" enctype="multipart/form-data">
                                <div class="row g-3">
                                <div class="col-12 col-sm-6">
                                        <input type="text" name="name" class="form-control" placeholder="enter your name" value="'.$userName.'" readonly>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <input type="email" name="email" class="form-control" placeholder="enter your email"  value="'.$userEmail.'" readonly>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <input type="text" name="number" class="form-control" placeholder="enter your Contact Number"  required>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <input type="text" name="address" class="form-control" placeholder="enter your present address"  required>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                    <label for="university">Your University</label>
                                        <input type="text" name="university" class="form-control" placeholder="enter your University Name"  value="'.$university.'" readonly>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                    <label for="cgpa">Your CGPA</label>
                                        <input type="text" name="cgpa" class="form-control" placeholder="enter your Average CGPA in University"  value="'.$cgpa.'" readonly>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                    <label for="pdf">Enter your CV</label>
                                        <input type="file" name="pdf" class="form-control" accept="pdf/pdf, pdf/docx, pdf/txt"  required>
                                        
                                    </div>
                                    
                                    <div class="col-12">
                                        <!--<button name="submit" class="btn btn-primary w-100" type="submit">Apply Now</button>-->
                                        <input type="submit" name="submit" value="Apply Now" class="btn btn-primary w-100">
                                        
                                        </div>
                                </div>
                            </form>
                        </div>
                    </div>
        
                    <div class="col-lg-4">
                        <div class="bg-light rounded p-5 mb-4 wow slideInUp" data-wow-delay="0.1s">
                            <h4 class="mb-4">Job Summery</h4>
                            <p><i class="fa fa-angle-right text-primary me-2"></i>Company Name: '.$companyName.'</p>
                            <p><i class="fa fa-angle-right text-primary me-2"></i>Company E-mail: '.$email.'</p>
                            <p><i class="fa fa-angle-right text-primary me-2"></i>Vacancy: '.$vacancy.' Position</p>
                            <p><i class="fa fa-angle-right text-primary me-2"></i>Experience Needed: '.$experience.' Year</p>
                            <p><i class="fa fa-angle-right text-primary me-2"></i>Catagory: '.$jobCategory.'</p>
                            <p><i class="fa fa-angle-right text-primary me-2"></i>Salary: '.$salaryFrom. '-' .$salaryTo. ' TK</p>
                            <p><i class="fa fa-angle-right text-primary me-2"></i>Location: '.$jobLocation.'</p>
                            <p><i class="fa fa-angle-right text-primary me-2"></i>Date Line: '.$dueDate.'</p>
                            <p><i class="fa fa-angle-right text-primary me-2"></i>Test Date: '.$exam_date.'</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

    }
}
    
    }
    
    $result->free();
    
    }
    
 



?>
        <!-- Job Detail End -->


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