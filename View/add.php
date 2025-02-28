<?php 
require_once('../Model/config.php');
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

if( $_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $question = trim($_POST['question']);
    $answer = trim($_POST['answer']);

    $sql = "INSERT INTO responses (user_id, question, answer) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $question, $answer);

    if($stmt->execute()){
        header("Location: search.php?search=" . urlencode($question));
        exit;
    }else {
        echo "Error adding response.";
    }
}
?>
