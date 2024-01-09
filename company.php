<?php
@include 'config.php';
session_start();

if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_email'])) {
    header('location: login_form.php');
}

if (isset($_SESSION['user_name']) || isset($_SESSION['user_email'])) {
    $CompanyName = $_SESSION['user_name'];
    $CompanyEmail = $_SESSION['user_email'];
}
$errors = array();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    
    $companyName = $_POST['C_name'];
    $jobDescription = $_POST['description'];
    $jobTitle = $_POST['J_title'];
    $jobCategory = $_POST['categories'];
    $selectedSubcategories = isset($_POST["subcategories"]) ? $_POST["subcategories"] : [];
    $subcategoriesString = implode(', ', $selectedSubcategories);
    $jobLocation = $_POST['location'];
    $salaryFrom = $_POST['F_salary'];
    $salaryTo = $_POST['T_salary'];
    $email = $_POST['email'];
    $experience = $_POST['experience'];
    $dueDate = $_POST['due_date'];
    $exam_date = $_POST['exam_date'];
    $vacancy = $_POST['vacancy'];


    $experience2 = intval($experience); // Convert to integer for comparison
    $vacancy2 = intval($vacancy); // Convert to integer for comparison
    $currentDate = time(); // Current timestamp
    $dueDateTimestamp = strtotime($dueDate);
    $examDateTimestamp = strtotime($exam_date);

    if (empty($jobDescription)) {
        $errors[] = "Job Description is required.";
    }

    else if ($jobTitle == '') {
        $errors[] = "Job Title is required.";
    }

    else if (!preg_match("/^[a-zA-Z ]+$/", $jobTitle)) {
        $errors[] = "Job Title can only contain alphabets and spaces.";
    }

    else if ($jobCategory == 'Categories') {
        $errors[] = "Please select a Category.";
    }

    else if ($jobLocation == 'Location') {
        $errors[] = "Please select a Location.";
    }

    else if (empty($salaryFrom) || empty($salaryTo)) {
        $errors[] = "Salary fields are required.";
    }

    else if ($salaryFrom >= $salaryTo) {
        $errors[] = "Wrong Adjustment in salary fields.";
    }

    else if (empty($experience)) {
        $errors[] = "Experience is required.";
    }

    else if ($experience2 < 0) {
        $errors[] = "Experience cannot be less than 0.";
    }


    else if (empty($dueDate)) {
        $errors[] = "Due Date is required.";
    }

    else if ($dueDateTimestamp <= $currentDate) {
        $errors[] = "Due Date must be a future date.";
    }

    else if (empty($exam_date)) {
        $errors[] = "Exam Date is required.";
    }

    else if ($examDateTimestamp <= $currentDate) {
        $errors[] = "Exam Date must be a future date.";
    }

    else if (empty($vacancy)) {
        $errors[] = "Vacancy is required.";
    } 
    else if ($vacancy2 < 1) {
        $errors[] = "Vacancy cannot be less than 1.";
    }
    else {
        $stmt = $conn->prepare("INSERT INTO job_posts (company_name, job_description, job_title, job_category, subcategories, job_location, salary_from, salary_to, email, experience_years, due_date, vacancy, exam_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("sssssssssisis", $companyName, $jobDescription, $jobTitle, $jobCategory, $subcategoriesString, $jobLocation, $salaryFrom, $salaryTo, $email, $experience, $dueDate, $vacancy, $exam_date);

        
        if ($stmt->execute()) {
            $message = "Your form is saved in the database.";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Close the database connection
$conn->close();
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

    <!--  Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    
    <link href="css/style.css" rel="stylesheet">


    <script>
        // Display the pop-up message
        window.onload = function() {
            var message = "<?php echo $message; ?>";
            alert(message);
        };
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
            <a href="company.php" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
                <h1 class="m-0 text-primary">COMPANY</h1>
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="company.php" class="nav-item nav-link">Home</a>
                    <a href="contact2.php?CompanyName=<?php echo urlencode($CompanyName); ?>&CompanyEmail=<?php echo urlencode($CompanyEmail); ?>" class="nav-item nav-link">Contact</a>
                </div>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 profile-menu"> 
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="profile-pic">
                    
                    <img class="img-fluid w-100" src="img/teacher-1.png" alt="Profile Picture">
                </div>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="changePass2.php?userName=<?php echo urlencode($CompanyName); ?>&userEmail=<?php echo urlencode($CompanyEmail); ?>"><i class="fas fa-cog fa-fw"></i> Change Password</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt fa-fw"></i> Log Out</a></li>
          </ul>
        </li>
    </ul>
    </div>
        </nav>
        <!-- Navbar End -->


        <!-- Carousel Start -->
        <div class="container-fluid p-0">
            <div class="owl-carousel header-carousel position-relative">
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid" src="img/pexels-pixabay-269077.jpg" alt="">
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
                    <img class="img-fluid" src="img/pexels-vlada-karpovich-7433825.jpg" alt="">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(43, 57, 64, .5);">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-10 col-lg-8">
                                    <h1 class="display-3 text-white animated slideInDown mb-4">Find The Best Startup Job That Fit You</h1>
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


        


        <!-- About Start -->
        
             


        
        
        
        <div class="col-md-12">
                        <div class="wow fadeInUp" data-wow-delay="0.5s">
                             <h1 class="text-center mb-5 wow fadeInUp " data-wow-delay="0.1s" style="margin-top: 30px">Post A Job</h1>
                             <?php
// Display error messages if any
if (!empty($errors)) {
    echo '<div class="alert alert-danger" role="alert">';
    foreach ($errors as $error) {
        echo '<p>' . $error . '</p>';
    }
    echo '</div>';
}
?>
                             <form action="" method="post">
                                <div class="row g-3">
                                <div class="col-12">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="C_name" id="C_name" placeholder="Company Name" value="<?php echo $_SESSION['user_name'] ?>" readonly>
                        <label for="C_name">Company Name</label>
                    </div>
                </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Leave a message here" name="description" id="description" style="height: 150px"></textarea>
                                            <label for="description">Job Description</label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="J_title" id="J_title" placeholder="Enter job title">
                                            <label for="J_title">Job Title</label>
                                        </div>
                                    </div>
                                    
                                    


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

      <!-- Sub-categories -->
      <div id="Information Technology-subcategories" style="display: none;">
        <div class="col-md-12">
          <label>Software Development:</label><br>
          <input type="checkbox" name="subcategories[]" value="Software Engineer"> Software Engineer<br>
          <input type="checkbox" name="subcategories[]" value="Front-end Developer"> Front-end Developer<br>
          <input type="checkbox" name="subcategories[]" value="Back-end Developer"> Back-end Developer<br>
          <input type="checkbox" name="subcategories[]" value="Full-stack Developer"> Full-stack Developer<br>
          <input type="checkbox" name="subcategories[]" value="Mobile App Developer"> Mobile App Developer<br>
          <!-- Add more sub-categories as needed -->
        </div>
        <div class="col-md-12">
          <label>IT Support:</label><br>
          <input type="checkbox" name="subcategories[]" value="Help Desk Support"> Help Desk Support<br>
          <input type="checkbox" name="subcategories[]" value="IT Technician"> IT Technician<br>
          <input type="checkbox" name="subcategories[]" value="Systems Administrator"> Systems Administrator<br>
          <input type="checkbox" name="subcategories[]" value="Network Engineer"> Network Engineer<br>

          <!-- Add more sub-categories as needed -->
        </div>
        <div class="col-md-12">
          <label>Data Science and Analytics:</label><br>
          <input type="checkbox" name="subcategories[]" value="Data Scientist"> Data Scientist<br>
          <input type="checkbox" name="subcategories[]" value="Data Analyst"> Data Analyst<br>
          <input type="checkbox" name="subcategories[]" value="Business Intelligence Analyst"> Business Intelligence Analyst<br>
          <input type="checkbox" name="subcategories[]" value="Data Engineer"> Data Engineer<br>
          <!-- Add more sub-categories as needed -->
        </div>
        <!-- Repeat the structure for other categories -->
      </div>

      <div id="Engineering-subcategories" style="display: none;">
        <div class="col-md-12">
          <label>Mechanical Engineering:</label><br>
          <input type="checkbox" name="subcategories[]" value="Mechanical Engineer"> Mechanical Engineer<br>
          <input type="checkbox" name="subcategories[]" value="HVAC Engineer"> HVAC Engineer<br>
          <input type="checkbox" name="subcategories[]" value="Aerospace Engineer"> Aerospace Engineer<br>
          <!-- Add more sub-categories as needed -->
        </div>
        <div class="col-md-12">
          <label>Electrical Engineering:</label><br>
          <input type="checkbox" name="subcategories[]" value="Electrical Engineer"> Electrical Engineer<br>
          <input type="checkbox" name="subcategories[]" value="Electronics Engineer"> Electronics Engineer<br>
          <input type="checkbox" name="subcategories[]" value="Power Systems Engineer"> Power Systems Engineer<br>
          <!-- Add more sub-categories as needed -->
        </div>
        <div class="col-md-12">
          <label>Civil Engineering:</label><br>
          <input type="checkbox" name="subcategories[]" value="Civil Engineer"> Civil Engineer<br>
          <input type="checkbox" name="subcategories[]" value="Structural Engineer"> Structural Engineer<br>
          <input type="checkbox" name="subcategories[]" value="Environmental Engineer"> Environmental Engineer<br>
          <!-- Add more sub-categories as needed -->
        </div>
        <div class="col-md-12">
          <label>Computer Engineering:</label><br>
          <input type="checkbox" name="subcategories[]" value="Computer Hardware Engineer"> Computer Hardware Engineer<br>
          <input type="checkbox" name="subcategories[]" value="Embedded Systems Engineer"> Embedded Systems Engineer<br>
          
          <!-- Add more sub-categories as needed -->
        </div>
      </div>


      <div id="Healthcare-subcategories" style="display: none;">
        <div class="col-md-12">
          <label>Medical Practitioners:</label><br>
          <input type="checkbox" name="subcategories[]" value="Physician"> Physician<br>
          <input type="checkbox" name="subcategories[]" value="Nurse"> Nurse<br>
          <input type="checkbox" name="subcategories[]" value="Surgeon"> Surgeon<br>
          <input type="checkbox" name="subcategories[]" value="Pharmacist"> Pharmacist<br>
          <!-- Add more sub-categories as needed -->
        </div>
        <div class="col-md-12">
          <label>Healthcare Administration:</label><br>
          <input type="checkbox" name="subcategories[]" value="Hospital Administrator"> Hospital Administrator<br>
          <input type="checkbox" name="subcategories[]" value="Healthcare Manager"> Healthcare Manager<br>
          <input type="checkbox" name="subcategories[]" value="Medical Office Manager"> Medical Office Manager<br>
          <!-- Add more sub-categories as needed -->
        </div>
        <div class="col-md-12">
          <label>Allied Health Professions:</label><br>
          <input type="checkbox" name="subcategories[]" value="Physical Therapist"> Physical Therapist<br>
          <input type="checkbox" name="subcategories[]" value="Occupational Therapist"> Occupational Therapist<br>
          <input type="checkbox" name="subcategories[]" value="Radiographer"> Radiographer<br>
          <!-- Add more sub-categories as needed -->
        </div>
        <!-- Repeat the structure for other categories -->
      </div>

      <div id="Finance-subcategories" style="display: none;">
      <div class="col-md-12">
          <label>Accounting:</label><br>
          <input type="checkbox" name="subcategories[]" value="Accountant"> Accountant<br>
          <input type="checkbox" name="subcategories[]" value="Financial Analyst"> Financial Analyst<br>
          <input type="checkbox" name="subcategories[]" value="Auditor"> Auditor<br>
          <!-- Add more sub-categories as needed -->
        </div>
        <div class="col-md-12">
          <label>Investment Banking:</label><br>
          <input type="checkbox" name="subcategories[]" value="Help Desk Support"> Investment Analyst<br>
          <input type="checkbox" name="subcategories[]" value="Investment Banker"> Investment Banker<br>
          <!-- Add more sub-categories as needed -->
        </div>
        <div class="col-md-12">
          <label>Financial Services:</label><br>
          <input type="checkbox" name="subcategories[]" value="Financial Advisor"> Financial Advisor<br>
          <input type="checkbox" name="subcategories[]" value="Wealth Manager"> Wealth Manager<br>
          <!-- Add more sub-categories as needed -->
        </div>
        <!-- Repeat the structure for other categories -->
      </div>

      <div id="Education-subcategories" style="display: none;">
      <div class="col-md-12">
          <label>K-12 Education:</label><br>
          <input type="checkbox" name="subcategories[]" value="Teacher"> Teacher<br>
          <input type="checkbox" name="subcategories[]" value="School Counselor"> School Counselor<br>
          <input type="checkbox" name="subcategories[]" value="Principal"> Principal<br>
          <!-- Add more sub-categories as needed -->
        </div>
        <div class="col-md-12">
          <label>Higher Education:</label><br>
          <input type="checkbox" name="subcategories[]" value="Professor"> Professor<br>
          <input type="checkbox" name="subcategories[]" value="Researcher"> Researcher<br>
          <input type="checkbox" name="subcategories[]" value="Academic Advisor"> Academic Advisor<br>
          <!-- Add more sub-categories as needed -->
        </div>
        <!-- Repeat the structure for other categories -->
      </div>

      <div id="Sales and Marketing-subcategories" style="display: none;">
      <div class="col-md-12">
          <label>Sales:</label><br>
          <input type="checkbox" name="subcategories[]" value="Sales Representative"> Sales Representative<br>
          <input type="checkbox" name="subcategories[]" value="Sales Manager"> Sales Manager<br>
          <input type="checkbox" name="subcategories[]" value="Account Executive"> Account Executive<br>
          <!-- Add more sub-categories as needed -->
        </div>
        <div class="col-md-12">
          <label>Marketing:</label><br>
          <input type="checkbox" name="subcategories[]" value="Marketing Coordinator"> Marketing Coordinator<br>
          <input type="checkbox" name="subcategories[]" value="Digital Marketing Specialist"> Digital Marketing Specialist<br>
          <input type="checkbox" name="subcategories[]" value="Content Marketer"> Content Marketer<br>
          <!-- Add more sub-categories as needed -->
        </div>
      </div>

      <div id="Creative Arts-subcategories" style="display: none;">
      <div class="col-md-12">
          <label>Design:</label><br>
          <input type="checkbox" name="subcategories[]" value="Graphic Designer"> Graphic Designer<br>
          <input type="checkbox" name="subcategories[]" value="UI/UX Designer"> UI/UX Designer<br>
          <input type="checkbox" name="subcategories[]" value="Web Designer"> Web Designer<br>
          <!-- Add more sub-categories as needed -->
        </div>
        <div class="col-md-12">
          <label>Performing Arts:</label><br>
          <input type="checkbox" name="subcategories[]" value="Actor"> Actor<br>
          <input type="checkbox" name="subcategories[]" value="Musician"> Musician<br>
          <input type="checkbox" name="subcategories[]" value="Dancer"> Dancer<br>
          <!-- Add more sub-categories as needed -->
        </div>
        <div class="col-md-12">
          <label>Writing and Editing:</label><br>
          <input type="checkbox" name="subcategories[]" value="Content Writer"> Content Writer<br>
          <input type="checkbox" name="subcategories[]" value="Editor"> Editor<br>
          <input type="checkbox" name="subcategories[]" value="Technical Writer"> Technical Writer<br>
          <!-- Add more sub-categories as needed -->
        </div>
      </div>

      <div id="Human Resources-subcategories" style="display: none;">
      <div class="col-md-12">
          <label>Recruitment and Staffing:</label><br>
          <input type="checkbox" name="subcategories[]" value="Recruiter"> Recruiter<br>
          <input type="checkbox" name="subcategories[]" value="HR Coordinator"> HR Coordinator<br>
          <input type="checkbox" name="subcategories[]" value="Talent Acquisition Manager"> Talent Acquisition Manager<br>
          <!-- Add more sub-categories as needed -->
        </div>
        <div class="col-md-12">
          <label>Employee Relations:</label><br>
          <input type="checkbox" name="subcategories[]" value="HR Generalist"> HR Generalist<br>
          <input type="checkbox" name="subcategories[]" value="Employee Relations Specialist"> Employee Relations Specialist<br>
          <!-- Add more sub-categories as needed -->
        </div>
        <div class="col-md-12">
          <label>Training and Development:</label><br>
          <input type="checkbox" name="subcategories[]" value="Training Coordinator"> Training Coordinator<br>
          <input type="checkbox" name="subcategories[]" value="Learning and Development Manager"> Learning and Development Manager<br>
          <!-- Add more sub-categories as needed -->
        </div>
      </div>

      <div id="Manufacturing and Production-subcategories" style="display: none;">
      <div class="col-md-12">
          <label>Production:</label><br>
          <input type="checkbox" name="subcategories[]" value="Production Manager"> Production Manager<br>
          <input type="checkbox" name="subcategories[]" value="Manufacturing Engineer"> Manufacturing Engineer<br>
          <input type="checkbox" name="subcategories[]" value="Quality Control Inspector"> Quality Control Inspector<br>
          <!-- Add more sub-categories as needed -->
        </div>
        <div class="col-md-12">
          <label>Supply Chain:</label><br>
          <input type="checkbox" name="subcategories[]" value="Supply Chain Manager"> Supply Chain Manager<br>
          <input type="checkbox" name="subcategories[]" value="Logistics Coordinator"> Logistics Coordinator<br>
          <!-- Add more sub-categories as needed -->
        </div>
        <div class="col-md-12">
          <label>Quality Assurance:</label><br>
          <input type="checkbox" name="subcategories[]" value="Quality Assurance Analyst"> Quality Assurance Analyst<br>
          <input type="checkbox" name="subcategories[]" value="Quality Assurance Engineer"> Quality Assurance Engineer<br>
          <!-- Add more sub-categories as needed -->
        </div>
      </div>

      <div id="Customer Service-subcategories" style="display: none;">
        <div class="col-md-12">
          <label>Call Center:</label><br>
          <input type="checkbox" name="subcategories[]" value="Customer Service Representative"> Customer Service Representative<br>
          <input type="checkbox" name="subcategories[]" value="Call Center Supervisor"> Call Center Supervisor<br>
          <!-- Add more sub-categories as needed -->
        </div>
        <div class="col-md-12">
          <label>Client Success:</label><br>
          <input type="checkbox" name="subcategories[]" value="Client Success Manager"> Client Success Manager<br>
          <input type="checkbox" name="subcategories[]" value="Customer Support Specialis"> Customer Support Specialis<br>
          <!-- Add more sub-categories as needed -->
        </div>
        <!-- Repeat the structure for other categories -->
      </div>
                                    
                                    

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
                                    
                             <h4 class="mb-4">Salary (Monthly)</h4>
                                    
                                    <div class="col-md-2">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="F_salary" id="F_salary" placeholder="amount">
                                            <label for="F_salary">From</label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="T_salary" id="T_salary" placeholder="amount">
                                            <label for="T_salary">To</label>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    

                                    <div class="col-md-4">
                    <div class="form-floating">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" value="<?php echo $_SESSION['user_email'] ?>" readonly>
                        <label for="email">E-mail</label>
                    </div>
                </div>

                                    <h4 class="mb-4">Experience (Years)</h4>
                                    <div class="col-md-8">
                                    <div class="form-floating">
                                            <input type="number" class="form-control" name="experience" id="experience" placeholder="Number">
                                            <label for="experience">Experience</label>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" name="due_date" id="due_date" placeholder="date">
                                            <label for="due_date">Due Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" name="vacancy" id="vacancy" placeholder="Number">
                                            <label for="vacancy">Vacancy</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" name="exam_date" id="exam_date" placeholder="date">
                                            <label for="exam_date">Exam Date</label>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 py-3" type="submit">Post</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
        

                                    
           
                                    
                                    
        
                    

                    
        
        
                    
                   
        
        
        
        
        
        
        
        
        <!-- Jobs Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Recently Posted Jobs</h1>
                <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.3s">
                    
                    <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 active" data-bs-toggle="pill" href="#tab-1">
                        <h6 class="mt-n1 mb-0">Featured</h6>
                    </a>
                
            <div class="tab-content">
                

                <?php
                @include 'config.php';
               // $companyName="$_SESSION['user_name]";
/*$sql = "SELECT id, job_title, job_location, salary_from, salary_to FROM job_posts where company_name ='<?php echo $_SESSION['user_name'] ?>'";*/
$sql = "SELECT id, job_title, job_location, salary_from, salary_to, due_date, vacancy FROM job_posts WHERE company_name = '$CompanyName'";

if ($result = $conn->query($sql)) {
$i=0;

while ($row = $result->fetch_assoc()) {


$ID = $row["id"]; 
$Title = $row["job_title"];
$Location = $row["job_location"];
$Salary1 = $row["salary_from"];
$Salary2 = $row["salary_to"];
$Date_line = $row["due_date"];
$vacancy=$row["vacancy"];








echo '<div id="tab-1" class="tab-pane fade show p-0 active">
<div class="job-item p-4 mb-4">
<div class="row g-4">
<div class="col-sm-12 col-md-8 d-flex align-items-center">
    
    <div class="text-start ps-4">


    <h5 class="mb-3">'.$Title.'</h5>
<span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>'.$CompanyName.' From '.$Location.'</span>
<span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i>'.$Salary1. '-' .$Salary2.'TK </span>     
<span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i>Vacancy = '.$vacancy.'</span>

    </div>
</div>
<div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                        <div class="d-flex mb-3">
                                        
                                        <a style="background: #58FAD0;" class="btn btn-primary3" href="Applicants.php?jobid='.$ID.'&CompanyName='.$CompanyName.'&CompanyEmail='.$CompanyEmail.'">Applicant List</a>
                                         <a class="btn btn-primary" href="update_job.php?updateid='.$ID.'">Update</a>

                                            <a class="btn btn-primary1" href="delete_job.php?id='.$ID.'">Delete</a>
                                        </div>
                                        <small class="text-truncate"><i class="far fa-calendar-alt text-primary me-2"></i>Date Line: '.$Date_line.'</small>
                                    </div>

</div>

</div>

</div>
';
$i=$i+1;

}

$result->free();

}

$conn ->close();


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


    

    <script>
    function changeCategory() {
        // Hide all sub-categories
        var allSubcategories = document.querySelectorAll('[id$="-subcategories"]');
        allSubcategories.forEach(function (subcategory) {
            subcategory.style.display = 'none';
        });

        // Show the selected sub-category
        var selectedCategory = document.getElementById('categories').value;
        var selectedSubcategory = document.getElementById(selectedCategory + '-subcategories');
        selectedSubcategory.style.display = 'block';
        
        // Clear the selected sub-categories
        var checkboxes = selectedSubcategory.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(function (checkbox) {
            checkbox.checked = false;
        });
    }
</script>

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