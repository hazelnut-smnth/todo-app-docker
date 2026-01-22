<?php
require_once 'config.php';
try {
    $conn = getDBConnection();
    
    // Early return: check if ID exists first
    if (!isset($_GET['id'])) {
        die("Error: Missing task ID");
    }
    
    $id = $_GET['id'];
    
    // Fetch current status
    $sql = "SELECT completed FROM todo WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Early return: task not found
    if (!$task) {
        die("Error: Task not found");
    }
    
    // Calculate new status
    $new_completed = $task['completed'] ? 0 : 1;
    
    // Update completed status
    $sql = "UPDATE todo SET completed = :completed WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':completed' => $new_completed, ':id' => $id]);
    
    // Update completed_at timestamp
    if ($new_completed) {
        $sql = "UPDATE todo SET completed_at = NOW() WHERE id = :id";
    } else {
        $sql = "UPDATE todo SET completed_at = NULL WHERE id = :id";
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    
    header("Location: index.php");
    die;
} catch(PDOException $e) {
    error_log("Database error in toggle.php: " . $e->getMessage());
    die("Failed to toggle status. Please try again later.");
}
?>
