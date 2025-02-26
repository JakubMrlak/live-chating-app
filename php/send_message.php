<?php
session_start(); 
include 'db.php';

if ($pdo === null) {
    http_response_code(500);
    exit();
}

$room = $_POST['room'];
$message = $_POST['message'];
$sender = $_SESSION['user_id'] ?? null; 

if ($sender === null) {
    http_response_code(403); 
    exit();
}

try {
    $stmt = $pdo->prepare("INSERT INTO messages (room_id, sender_id, message) VALUES (?, ?, ?)");
    $stmt->execute([$room, $sender, $message]);
} catch (PDOException $e) {
    error_log("Error in send_message.php: " . $e->getMessage());
    http_response_code(500);
}
?>