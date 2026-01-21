<?php
require_once 'config.php';
try{
    $conn = getDBConnection();
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $task = $_POST['task'];
        $due_date = $_POST['due_date'];
        if($due_date === ''){
            $due_date = null;
        }
        if(trim($task) !== '') {
            $sql = "UPDATE todo SET task = :task, due_date = :due_date WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':task' => $task, ':due_date' => $due_date, ':id' => $id]);
            header("Location: index.php");
            die;
        }
    }
} catch(PDOException $e) {
    error_log("Database error in update.php: " . $e->getMessage());
    die("Update failed. Please try again later.");
}
?>