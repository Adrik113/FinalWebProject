<?php 
require_once('../Model/config.php');
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    $sql = "INSERT INTO responses (user_id, question, answer) VALUES(?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $question, $answer);
    $stmt->execute();

}

$sql = "SELECT question, answer FROM responses WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<h2>Welcome, <?php echo $_SESSION["username"]; ?></h2>
<h3>Save Interview Responses</h3>

<form method="POST">
    <select name="question" required>
        <option value="">Select a Question</option>
        <?php 
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
        foreach($questions as $q) {
            echo "<option value=\"$q\">$q</option>";
        }
        ?>
    </select>
    <textarea name="answer" placeholder="Your answer" required></textarea><br>
    <button type="submit">Save Responses</button>
</form>

<h3>Saved Responses</h3>
<ul>
    <?php while($row = $result->fetch_assoc()): ?>
        <li><strong><?php echo $row['question']; ?></strong>: <?php echo $row["answer"]; ?></li>
    <?php endwhile; ?>
</ul>

<a href="../Controller/logout.php">Logout</a>
<a href="search.php">Search users & Questions</a>
