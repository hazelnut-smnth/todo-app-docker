<?php
require_once 'config.php';
try{
    $conn = getDBConnection();
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $sql="SELECT completed FROM todo WHERE id=:id";
        $stmt=$conn->prepare($sql);
        $stmt->execute([':id'=>$id]);
        $task=$stmt->fetch(PDO::FETCH_ASSOC);
        if(!$task){
            die("Error: Task not found");
        }
        $newCompleted=$task['completed']?0:1;
        $sql="UPDATE todo SET completed=:completed WHERE id=:id";
        $stmt=$conn->prepare($sql);
        $stmt->execute([':completed'=>$newCompleted,':id'=>$id]);
        if($newCompleted){
            $sql="UPDATE todo SET completed_at=NOW() WHERE id=:id";
        }else{
            $sql="UPDATE todo SET completed_at=NULL WHERE id=:id";
        }
        $stmt=$conn->prepare($sql);
        $stmt->execute([':id'=>$id]);
        header("Location: index.php");
        die;
    }else{
        die("Error: Missing task ID");
    }
}catch(PDOException $e){
     error_log("Database error in toggle.php: " . $e->getMessage());
    die("Failed to toggle status. Please try again later.");
}
?>
