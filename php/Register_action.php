<?php
session_start();
include 'db.php';

$_SESSION['message'] = null;
$_SESSION['msg_type'] = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $Name = trim($_POST['Name']);
    $Email = trim($_POST['Email']);
    $Pass = $_POST['Password'];
    $Conf_Pass = $_POST['Confirm_password']; 

    // Check if passwords match
    if ($Pass !== $Conf_Pass) {
        $_SESSION['message'] = "Passwords do not match!";
        $_SESSION['msg_type'] = "error";
        header("Location: ../register.php");
        exit();
    }

    // Check if email already exists
    if ($pdo === null) {
        $_SESSION['message'] = "Database connection failed!";
        $_SESSION['msg_type'] = "error";
        header("Location: ../register.php");
        exit();
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE Email = ?");
        $stmt->execute([$Email]);
        if ($stmt->fetch()) {
            $_SESSION['message'] = "Error: This email is already registered!";
            $_SESSION['msg_type'] = "error";
            header("Location: ../register.php");
            exit();
        }
    } catch (PDOException $e) {
        error_log("Email check failed in Register_action.php: " . $e->getMessage());
        $_SESSION['message'] = "Error checking email: " . $e->getMessage();
        $_SESSION['msg_type'] = "error";
        header("Location: ../register.php");
        exit();
    }

    // Hash the password securely
    $password_Hash = password_hash($Pass, PASSWORD_DEFAULT);

    // Insert user data
    try {
        $stmt = $pdo->prepare("INSERT INTO users (Name, Email, Password) VALUES (?, ?, ?)");
        $stmt->execute([$Name, $Email, $password_Hash]);
        $_SESSION['message'] = "Registration successful!";
        $_SESSION['msg_type'] = "success";
    } catch (PDOException $e) {
        error_log("Insert failed in Register_action.php: " . $e->getMessage());
        $_SESSION['message'] = "Error: Registration failed: " . $e->getMessage();
        $_SESSION['msg_type'] = "error";
    }

    header("Location: ../register.php");
    exit();
}
?>