<?php
require_once 'config.php';
try{
    $conn = getDBConnection();
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $sql="DELETE FROM todo WHERE id=:id";
        $stmt=$conn->prepare($sql);
        $stmt->execute([':id'=>$id]);
        header("Location: index.php");
        die;
    }else{
        die("Error: Missing task ID");
    }
}catch(PDOException $e){
    die("Database error:".$e->getMessage());
}
?>
