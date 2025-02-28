<?php 
require_once('../Model/config.php');
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];

    $sql = "DELETE FROM responses WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $id, $user_id);

    if($stmt->execute()) {
        header("Location: search.php");
        exit;
    }else {
        echo 'Error deleting response';
    }
  } else {
    header("Location: search.php");
    exit;
  }
  ?>