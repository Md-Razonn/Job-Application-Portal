<?php
@include 'config.php';
session_start();

if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_email'])) {
    header('location: login_form.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $jobDescription = $_POST['description'];
    // Collect other form fields as needed

    // Perform the update
    $sql = "UPDATE job_posts SET job_description = '$jobDescription' WHERE id = '$jobId' AND company_name = '{$_SESSION['user_name']}'";

    if ($conn->query($sql)) {
        // Update successful
        header('location: company.php'); // Redirect to the page you want after the update
        exit();
    } else {
        // Update failed
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>