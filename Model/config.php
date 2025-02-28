<?php 

$host = "localhost";
$user = "sdc342final_user";
$password = "6TusdNdKdUoACkHm";
$dbname = "interview_prep";

$conn = new mysqli($host, $user, $password, $dbname);

if($conn->connect_error) {
    die("connection failed: " . $conn->connect_error);
}
?>