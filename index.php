<?php
include 'db.php';

// Handle new task submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['title'])) {
    $title = $_POST['title'];
    $stmt = $conn->prepare("INSERT INTO tasks (title) VALUES (:title)");
    $stmt->bindParam(':title', $title);
    $stmt->execute();
}

// Fetch tasks from the database
$stmt = $conn->prepare("SELECT * FROM tasks ORDER BY created_at DESC");
$stmt->execute();
$tasks = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Task Manager</h1>
        <form method="POST" action="index.php">
            <input type="text" name="title" placeholder="Enter a new task" required>
            <button type="submit">Add Task</button>
        </form>

        <ul>
            <?php foreach ($tasks as $task): ?>
                <li>
                    <?php echo htmlspecialchars($task['title']); ?>
                    <a href="delete.php?id=<?php echo $task['id']; ?>" class="delete-btn">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
