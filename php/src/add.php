<?php
require_once 'config.php';
try{
     $conn = getDBConnection();
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $task = $_POST["task"];
        $due_date = $_POST["due_date"];
        if ($due_date === '') {
            $due_date = null;
        }
        if (trim($task) !== '') {
           $sql = "INSERT INTO todo (task, due_date) VALUES (:task, :due_date)";
           $stmt = $conn->prepare($sql);
           $stmt->execute([':task' => $task, ':due_date' => $due_date]);
           header("Location: /index.php");
           die;
          }
     }
}catch(PDOException $e){
    error_log("Database error in add.php: " . $e->getMessage());
    die("Operation failed. Please try again later.");
}

