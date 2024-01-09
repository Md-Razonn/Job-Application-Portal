<?php
@include 'config.php';
session_start();

if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_email'])) {
    header('location: login_form.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $jobId = $_GET['id'];
    
    // Perform the deletion
    $sql = "DELETE FROM job_posts WHERE id = '$jobId' AND company_name = '{$_SESSION['user_name']}'";
    if ($conn->query($sql)) {
        // Deletion successful
        header('location: company.php'); // Redirect to the page you want after deletion
        exit();
    } else {
        // Deletion failed
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
