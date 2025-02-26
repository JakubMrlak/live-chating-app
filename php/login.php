<?php
session_start();

$_SESSION['message'] = null;
$_SESSION['msg_type'] = null;

include 'db.php'; // Use PDO db.php

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $Email = trim($_POST['Email']);
    $Pass = $_POST['Password'];
    
    try {
        if ($pdo === null) {
            throw new PDOException("Database connection failed");
        }
        $stmt = $pdo->prepare("SELECT User_id, Password FROM users WHERE Email = ?");
        $stmt->execute([$Email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($Pass, $user['Password'])) {
            $_SESSION['user_id'] = $user['User_id'];
            $_SESSION['logged_in'] = true;
            $_SESSION['message'] = "Login successful!";
            $_SESSION['msg_type'] = "success";
            header("Location: ../php/chat.php"); 
            exit();
        } else {
            $_SESSION['message'] = "Error: Incorrect password!";
            $_SESSION['msg_type'] = "error";
            header("Location: ../index.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = "Error: Email not found or database issue: " . $e->getMessage();
        $_SESSION['msg_type'] = "error";
        header("Location: ../index.php");
        exit();
    }
}
?>