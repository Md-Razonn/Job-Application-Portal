<?php
include_once('config.php');
session_start();

if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_email'])) {
    header('location: login_form.php');
    exit();
}
?>

<?php

$id= $_GET['updateid'];
$sql= "SELECT * FROM job_posts WHERE id=$id";
$result=mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);




$companyName = $_SESSION['user_name'];
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


if(isset($_POST['submit'])){
    $jobDescription = mysqli_real_escape_string($conn, $_POST['description']);
$jobTitle = mysqli_real_escape_string($conn, $_POST['J_title']);
$jobCategory = mysqli_real_escape_string($conn, $_POST['categories']);
$selectedSubcategories = isset($_POST["subcategories"]) ? $_POST["subcategories"] : [];
$subcategoriesString = implode(', ', $selectedSubcategories);
$jobLocation = mysqli_real_escape_string($conn, $_POST['location']);
$salaryFrom = mysqli_real_escape_string($conn, $_POST['F_salary']);
$salaryTo = mysqli_real_escape_string($conn, $_POST['T_salary']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$experience = mysqli_real_escape_string($conn, $_POST['experience']);
$dueDate = mysqli_real_escape_string($conn, $_POST['due_date']);
$exam_date = mysqli_real_escape_string($conn, $_POST['exam_date']);
$vacancy = mysqli_real_escape_string($conn, $_POST['vacancy']);
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

else if ($jobCategory == 'Re-select the Category and Subcategory') {
    $errors[] = "Please select a Category.";
}

else if ($jobLocation == 'Location') {
    $errors[] = "Please select a Location.";
}

else if (empty($salaryFrom) || empty($salaryTo)) {
    $errors[] = "Salary fields are required.";
}

else if ($salaryFrom > $salaryTo) {
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


else{
  // Build the SQL query
$sql = "UPDATE job_posts SET job_description='$jobDescription', job_title='$jobTitle', job_category='$jobCategory', subcategories='$subcategoriesString', job_location='$jobLocation', salary_from='$salaryFrom', salary_to='$salaryTo', experience_years='$experience', due_date='$dueDate', vacancy='$vacancy', exam_date='$exam_date' WHERE id=$id";

// Execute the query
$run = mysqli_query($conn, $sql) or die(mysqli_error($conn));

if($run){

echo "<h1>Data Edited</h1>";

header("location:company.php");

}

else{

echo "<h1> Data not Edited </h1>";
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
</head>

<body>



<div class="col-md-12">
                        <div class="wow fadeInUp" data-wow-delay="0.5s">
                             <h1 class="text-center mb-5 wow fadeInUp " data-wow-delay="0.1s" style="margin-top: 30px">Update  Post</h1>
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
                             <form action="#" method="post">
                                <div class="row g-3">
                                <div class="col-12">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="C_name" id="C_name" placeholder="Company Name" value="<?php echo $_SESSION['user_name'] ?>" readonly>
                        <label for="C_name">Company Name</label>
                    </div>
                </div>
                <div class="col-12">
        <div class="form-floating">
            <textarea class="form-control" placeholder="Leave a message here" name="description" id="description" style="height: 150px"><?php echo $jobDescription; ?></textarea>
            <label for="description">Job Description</label>
        </div>
    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Enter job title" name="J_title" id="J_title" style="height: 150px"><?php echo $jobTitle; ?></textarea>
                                            <label for="J_title">Job Title</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <select name="categories" id="categories" class="form-floating" style="width: 100%; padding: 12px 20px; margin: 8px 0; display: inline-block; border-radius: 4px; box-sizing: border-box;" onchange="changeCategory()">
       
                                    <option selected>Re-select the Category and Subcategory</option>
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
       
        <option value="" <?php if ($jobLocation == '') echo 'selected'; ?>>Select Location</option>
        <option value="DHAKA" <?php if ($jobLocation == 'DHAKA') echo 'selected'; ?>>DHAKA</option>
        <option value="BARISAL" <?php if ($jobLocation == 'BARISAL') echo 'selected'; ?>>BARISAL</option>
        <option value="CHITTAGONG" <?php if ($jobLocation == 'CHITTAGONG') echo 'selected'; ?>>CHITTAGONG</option>
        <option value="KHULNA" <?php if ($jobLocation == 'KHULNA') echo 'selected'; ?>>KHULNA</option>
        <option value="MYMENSINGH" <?php if ($jobLocation == 'MYMENSINGH') echo 'selected'; ?>>MYMENSINGH</option>
        <option value="RAJSHAHI" <?php if ($jobLocation == 'RAJSHAHI') echo 'selected'; ?>>RAJSHAHI</option>
        <option value="RANGPUR" <?php if ($jobLocation == 'RANGPUR') echo 'selected'; ?>>RANGPUR</option>
        <option value="SYLHET" <?php if ($jobLocation == 'SYLHET') echo 'selected'; ?>>SYLHET</option>
         </select>
                        

                             <h4 class="mb-4">Salary (Monthly)</h4>
                                    
                                    <div class="col-md-2">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="F_salary" id="F_salary" value="<?php echo$salaryFrom;?>" placeholder="amount">
                                            <label for="F_salary">From</label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="T_salary" id="T_salary" value="<?php echo$salaryTo;?>" placeholder="amount">
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
                                            <input type="number" class="form-control" name="experience" id="experience" value="<?php echo$experience;?>" placeholder="Number">
                                            <label for="experience">Experience</label>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" name="due_date" id="due_date" value="<?php echo$dueDate;?>" placeholder="date">
                                            <label for="due_date">Due Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" name="vacancy" id="vacancy" value="<?php echo$vacancy;?>" placeholder="Number">
                                            <label for="vacancy">Vacancy</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" name="exam_date" id="exam_date" value="<?php echo$exam_date;?>" placeholder="date">
                                            <label for="exam_date">Exam Date</label>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-12">
        <button class="btn btn-primary w-100 py-3" type="submit" name="submit">Update</button>
        
    </div>
                                </div>
                            </form>
                        </div>
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
    

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>