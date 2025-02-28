<?php
require_once('../Model/config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$searchResults = [];
$searchTerm ='';

//check if search query exists
if(isset($_GET['search']) && !empty(trim($_GET['search']))){
    $searchTerm = "%" . trim($_GET['search']) . "%";
//join users and responses tables to get usernames 
$sql = "SELECT  responses.id, users.username, responses.question, responses.answer
      FROM responses 
      INNER JOIN users on responses.user_id = users.id
      WHERE users.email LIKE ? or responses.question LIKE ?";
    
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $searchResults[] = $row;
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
<h2>Interview Questions</h2>
<form method="GET">
    <input type="text" name="search" placeholder="Enter keyword..." required>
    <button type="submit">Search</button>
</form>

<h3>Add new Responses</h3>
<form method="POST" action="add.php">
    <label>Question:</label><br>
    <select name="question" required>
        <option value="">Select a Question</option>
        <?php foreach($questions as $q): ?>
            <option value="<?php echo htmlspecialchars($q); ?>"><?php echo htmlspecialchars($q); ?></option>
        <?php endforeach; ?>
        </select><br>

    <label>Response:</label><br>
    <textarea name="answer" required></textarea><br>
    <button type="submit" name="submit"> Add Responses</button>
</form>
   

<h3>Results</h3>,
<ul>
    <?php if(!empty($searchResults)): ?>
        <?php foreach($searchResults as $result): ?>
            <li>
                <strong>User: <?php echo htmlspecialchars($result['username']); ?></strong><br>
                <strong>Question:</strong> <?php echo htmlspecialchars($result['question']); ?>
                <strong>Response:</strong> <?php echo htmlspecialchars($result['answer']); ?>

               <form method="GET" action= "edit.php" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                    <button type="submit" class="edit-btn">Edit</button>
                 </form>

                 <form method="POST" action="delete.php" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                    <button type="submit" class="delete-btn">Delete</button>
             
                 </form>
            </li>   
        <?php endforeach; ?>
    <?php else: ?>
        <li>No Results Found.</li>
    <?php endif; ?>
</ul>

<a href="Dashboard.php">Back to home Screen</a>