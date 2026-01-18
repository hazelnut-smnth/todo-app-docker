<?php
require_once 'config.php';
try{
    $conn = getDBConnection();
    $sql="SELECT * FROM todo ORDER BY completed, id DESC";
    $stmt=$conn->query($sql);
    $tasks=$stmt->fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    die("Database error:".$e->getMessage());
}
require 'index.view.php';
?>
