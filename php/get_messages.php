<?php
session_start();
include 'db.php';

header('Content-Type: text/html');
try {
    if ($pdo === null) {
        throw new PDOException("Database connection not established.");
    }

    $room = $_GET['room'];
    $stmt = $pdo->prepare("SELECT m.sender_id, m.message, m.timestamp, u.Name 
                          FROM messages m 
                          JOIN users u ON m.sender_id = u.User_id 
                          WHERE m.room_id = ? 
                          ORDER BY m.timestamp");
    $stmt->execute([$room]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html = '';
    foreach ($result as $row) {
        $sender = ($row['sender_id'] == $_SESSION['user_id']) ? 'You' : $row['Name'];
        $html .= "<div class='text'> <p class='sender'>{$sender}: </p> <p class='text_content'> {$row['message'] } </p> <p class='time'> {$row['timestamp'] }</p></div>";
    }
    echo $html;
} catch (PDOException $e) {
    error_log("Error in get_messages.php: " . $e->getMessage());
    echo "Error loading messages";
}
?>