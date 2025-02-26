<?php
include 'db.php';

header('Content-Type: application/json');
try {
    if ($pdo === null) {
        throw new PDOException("Database connection not established.");
    }

    $recipient = $_POST['recipient'];
    $key = $_POST['key'];
    $sender = $_SESSION['user_id'] ?? null;

    if ($sender === null) {
        throw new PDOException("User not logged in.");
    }

    $stmt = $pdo->prepare("SELECT room_key FROM chats WHERE room_key = ? AND ((user1 = ? AND user2 = ?) OR (user1 = ? AND user2 = ?))");
    $stmt->execute([$key, $sender, $recipient, $recipient, $sender]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo json_encode(['success' => true, 'room_key' => $result['room_key']]);
    } else {
        echo json_encode(['success' => false]);
    }
} catch (PDOException $e) {
    error_log("Error in join_room.php: " . $e->getMessage());
    echo json_encode(['error' => 'Failed to join room: ' . $e->getMessage()]);
}
?>