<?php 
require_once('../Model/config.php');
session_start();

if(!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] === "POST") {
    $new_password = $_POST['new_password'] ?? '';
    $email = $_SESSION['reset_email'];

    if(strlen($new_password) < 8 ||
    !preg_match('/[A-Z]/', $new_password) ||
    !preg_match('/[a-z]/', $new_password) ||
    !preg_match('/[0-9]/', $new_password) ||
    !preg_match('/[\W]/', $new_password)
    ) {
        echo "Password must be at least 8 characters long and include an uppercase letter, a lowercase letter , a number , and a special characters";
    }else {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $email);

        if($stmt->execute()) {
            echo "Passowrd successfully changed. <a href='login.php'>Login here</a>";

            session_unset();
            session_destroy();
            exit();
        }else {
            echo "Error updaing passowrd. Please try again.";
        }
    }
}
?>
<form method="POST">
    <input type="password" name="new_password" placeholder="Enter new password" required>
    <button type="submit">Reset Password</button>
</form>