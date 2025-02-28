<?php 
require_once('../Model/config.php');
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: search.php");
    exit;
}

$id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];
$response = null;

$sql = "SELECT question, answer FROM responses WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0) {
    $response = $result->fetch_assoc();
}else {
    header("Location: search.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = trim($_POST['question']);
    $Updatedanswer = trim($_POST['answer']);

    if(empty($question) || empty($Updatedanswer)) {
        echo "Question and response cannot be empty.";
    }else {
    $updateSQL = "UPDATE responses SET question = ?, answer = ? WHERE id = ?";
    $stmt = $conn->prepare($updateSQL);
    $stmt->bind_param("ssi", $question, $Updatedanswer, $id);

    if($stmt->execute()) {
        header("Location: search.php?search=" . urlencode($question));
        exit;
    }else {
        echo "Error updating response.";
    }
}
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


?>
<h3>Edit Response</h3>
<form method="POST">
    <label>Question:</label><br>
    <input type="text" name="question" value="<?php echo htmlspecialchars($response['question']); ?>" required><br>

    <label>Response:</label><br>
    <textarea name="answer" required><?php echo htmlspecialchars($response['answer']); ?></textarea><br>

    <button type="submit">Save Changes</button>
</form>
</form>

<a href="search.php">Back to Search</a>