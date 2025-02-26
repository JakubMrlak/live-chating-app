<?php
$servername = "localhost";
$username = "mrlakj";
$password = "Swr123jki159*";
$dbname = "mrlakj_live_chat";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    // Test the connection
    $pdo->query("SELECT 1");
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    if (isset($_SERVER['PHP_SELF']) && strpos($_SERVER['PHP_SELF'], 'index.php') === false) {
        $_SESSION['message'] = "Database connection failed: " . $e->getMessage();
        $_SESSION['msg_type'] = "error";
        header("Location: ../index.php");
        exit();
    } else {
        $pdo = null; // For API scripts, return null
    }
}
?>