<?php
require_once 'config.php';
try{
    $conn = getDBConnection();
    $sql = "SELECT * FROM todo ORDER BY completed, id DESC";
    $stmt = $conn->query($sql);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    error_log("Database error in index.php: " . $e->getMessage());
    die("Failed to fetch tasks. Please try again later.");
}
require 'index.view.php';
?>
