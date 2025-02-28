<?php 
require_once('../Model/config.php');
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'] ?? '';

        //check if email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0) {
            $_SESSION['reset_email'] = $email;
            header("Location: change_password.php");
            exit();
        }else{
            echo "No account found with that email.";
        }
}
?>
<form method="POST">
    <input type="email" name="email" placeholder="Enter your email" required>
    <button type="submit">Submit</button>
</form>