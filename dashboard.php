<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ajouter une tâche
if ($_POST) {
    $title = trim($_POST['title']);
    $due_date = $_POST['due_date'] ?: null;
    $priority = $_POST['priority'] ?? 'Moyen';

    if ($title) {
        $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, due_date, priority) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $title, $due_date, $priority]);
    }
}

// Récupérer les tâches
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ?");
$stmt->execute([$user_id]);
$tasks = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main-container">
        
        
        <div class="task-form">
            <h2>Ajouter une tâche</h2>
            <form method="POST">
                <input name="title" placeholder="Nouvelle tâche" required>
                
                <label>Priorité :</label>
                <select name="priority">
                    <option value="Urgent">Urgent</option>
                    <option value="Moyen" selected>Moyen</option>
                    <option value="Faible">Faible</option>
                </select>
                
                <label>Date limite :</label>
                <input type="date" name="due_date">
                
                <button type="submit">Ajouter</button>
            </form>
            
            <p style="text-align: center; margin-top: 20px;">
                <a href="logout.php">Se déconnecter</a>
            </p>
        </div>

        
        <div class="task-list">
            <h2>Mes tâches</h2>
            <ul>
                <?php foreach ($tasks as $task): ?>
                    <li>
                        <div>
                            <strong><?= htmlspecialchars($task['title']) ?></strong>
                            
                            <?php if ($task['priority']): ?>
                                <span class="priority-<?= strtolower($task['priority']) ?>">
                                    [<?= $task['priority'] ?>]
                                </span>
                            <?php endif; ?>
                            
                            <?php if ($task['due_date']): ?>
                                <span class="due-date">
                                    (<?= date('d/m/Y', strtotime($task['due_date'])) ?>)
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <a href="delete_task.php?id=<?= $task['id'] ?>" class="delete-button">
                            Supprimer
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>