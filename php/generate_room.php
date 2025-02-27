<?php
session_start(); // Already included
include 'db.php';

header('Content-Type: application/json');
try {
    if ($pdo === null) {
        throw new PDOException("Database connection not established.");
    }

    $recipient = $_POST['recipient'];
    $key = $_POST['key'] ?? '';
    $sender = $_SESSION['user_id'] ?? null;

    if ($sender === null) {
        throw new PDOException("User not logged in.");
    }
    if (empty($key)) {
        throw new PDOException("Room key is required.");
    }

    $stmt = $pdo->prepare("INSERT INTO rooms (room_key, user1, user2) VALUES (?, ?, ?)");
    $success = $stmt->execute([$key, $sender, $recipient]);
    if ($success) {
        error_log("Room created: key=$key, user1=$sender, user2=$recipient");
        echo json_encode(['success' => true, 'room_key' => $key]);
    } else {
        throw new PDOException("Insert failed: " . implode(", ", $stmt->errorInfo()));
    }
} catch (PDOException $e) {
    error_log("Error in generate_room.php: " . $e->getMessage());
    echo json_encode(['error' => 'Failed to generate room: ' . $e->getMessage()]);
}
?>