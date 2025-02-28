<?php 
require_once('../Model/config.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <header>
        <h1>Login</h1>
</header>

<div class="container">
    <h2>Please login to continue</h2>

    <?php 
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT id, username, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $username, $hashed_password);
    
        if($stmt->fetch() && password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: Dashboard.php");
        }else {
            echo "<p class='error'>Invalid credentials.</p>";
        }
    }
    ?>
    
    <form method="POST">
        <input type="email" name="email" placeholder="email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
    <p><a href="forgot_password.php">Forgot Password?</a></p>
</div>
</body>
</html>