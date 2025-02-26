<?php
include 'db.php';

header('Content-Type: application/json');
try {
    if ($pdo === null) {
        throw new PDOException("Database connection not established.");
    }
    $stmt = $pdo->prepare("SELECT User_id, Name FROM users");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);
} catch (PDOException $e) {
    error_log("Error in get_users.php: " . $e->getMessage());
    echo json_encode(['error' => 'Failed to fetch users: ' . $e->getMessage()]);
}
?>