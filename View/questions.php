<?php 
require_once('/Model/config.php');
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$questions = [
    "Tell me about yourself",
    "Why do you want to work for this company?",
    "What are your strengths and weaknessess?",
    "why did you leave your last job?",
    "What are your long-term career goals?",
    "How do you handle street or pressure?",
    "Tell me about a time when you faced a challenge at work and how you handled it.",
    "What is your greatest achievement",
    "Describe a situation where you worked successfully in a team.",
    "What do you know about our company",
    "Why should we hire you?",
    "How do you prioritize your work?",
    "What motivates you?",
    "where do you see yourself in five years",
    "Tell me about a time you had to manage multiple tasks.",
    "how do you deal with difficult coworkers or customers?",
    "What makes you a good fit for this role?",
    "What are your salary expectations?",
    "how do you stay organized?",
    "Do you have any questions for us?"
];

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $selected_question = $_POST['question'];
    $response = $_POST['response'];
    $user_id  = $_SESSION["user_id"];

    $stmt = $conn->prepare("INSERT INTO responses (user_id, question, response) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $selected_question, $response);
    $stmt->execute();
    $stmt->close();

    echo "<p style='color:green;'>Response saved successfully!</p>";
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Interview Questions</title>
</head>
<body>

<h2>Interview Questions</h2>

<form action="questions.php" method="POST">
    <label for="question">Select a question:</label>
    <select name="question" id="question">
        <?php foreach ($questions as $question): ?>
            <option value="<?php echo htmlspecialchars($question);?>">
            <?php echo htmlspecialchars($question);?>
            </option>
        <?php endforeach; ?>
        </select>

        <br><br>

        <label for="response">Your Response:</label><br>
        <textarea name="response" id="response" rows="5" cols="40" required></textarea>

        <br><br>

        <button type="submit">Submit Response</button>
</form>

<a href="Dashboard.php">Go to Dashboard</a>
</body>
</html>
