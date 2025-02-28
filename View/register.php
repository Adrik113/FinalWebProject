<?php 
require_once('../Model/config.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    
    if(strlen($password) < 8 ||
    !preg_match("/[0-9]/", $password) ||
    !preg_match("/[\W]/", $password)) {
        echo "Password must be at least 8 characters long and include at least one number and one special character.";
    }else {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $username, $email, $hashedPassword);

        if($stmt->execute()){
            echo "Registration successful! <a href='login.php'>Login here </a>";
        }else {
            echo "Error: " . $stmt->error;
        }
    }

   
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Registration</h1>
</header>

<form method="Post">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="email" name="email" placeholder="Email" require><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Register</button>
</form>

<a href="login.php">Already have an Account? Login</a>

</body>
</html>