<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../index.php");
    exit();
}

if (!isset($_SESSION['user_id'])) {
    session_destroy();
    header("Location: ../index.php");
    exit();
}

include 'db.php';
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/chat.css?v=2"/> <!-- Added version query to force reload -->
    <title>SecureChat</title>
    <link rel="icon" type="image/svg+xml" href="../imgs/icons/secure_mail_icon.svg" />
    <link rel="icon" type="image/svg+xml" media="(prefers-color-scheme: dark)" href="../imgs/icons/secure_mail_icon_dark.svg" />
</head>
<body>
    <header>
        <a class="group-1" href="../index.php">
        <div>
            <img class="Icon" media="(prefers-color-scheme: dark)" src="../imgs/icons/secure_mail_icon_dark.svg" alt="logo">
        </div>
        </a>
        <nav class="primary-navbar">
            <ul>
                <li id="first"><a href="../index.php">Home</a></li>
                <li><a href="">Contact us</a></li>
                <li><a href="#" id="logout">Logout</a></li>                     
            </ul>
        </nav>
    </header>
    <main>
    <div class="chat_body">
        <div class="users">
            <!-- Users loaded here -->
        </div>
        <div class="chats">
            <div class="room-controls">
                <input type="text" id="roomKeyInput" placeholder="Enter room key to create" style="margin-right: 10px;">
                <button id="generateRoom">Generate Room</button>
                <input type="text" id="roomKey" placeholder="Enter room key to join" style="margin-left: 10px;">
                <button id="joinRoom">Join Room</button>
                <span id="generatedKey" style="display: none;"></span> <!-- Hidden by default -->
            </div>
            <div class="messages" id="messages">
                <!-- Messages loaded here -->
            </div>
            <div class="message-input">
                <input type="text" id="messageInput" placeholder="Type your message...">
                <button id="sendMessage">Send</button>
            </div>
        </div>
    </div>
    </main>
    <footer>
        <h1>© 2025 Rights reserved | MJ</h1>  
    </footer>

    <script src="../js/chat.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM fully loaded, checking initializeChat...');
            const peopleListDiv = document.querySelector('.users'); // Updated to .users
            if (!peopleListDiv) {
                console.error('Element with class "users" not found in the DOM.');
            } else {
                console.log('Found users div:', peopleListDiv);
            }
            if (typeof initializeChat === 'function') {
                const currentUserId = <?php echo json_encode($_SESSION['user_id']); ?>;
                console.log('Initializing chat with userId:', currentUserId);
                if (currentUserId === null) {
                    console.error('User ID is null, redirecting to login');
                    window.location = '../index.php';
                } else {
                    initializeChat(currentUserId);
                }
            } else {
                console.error('initializeChat is not defined. Ensure ../js/chat.js is loaded correctly.');
                const script = document.createElement('script');
                script.src = '../js/chat.js';
                script.onload = () => console.log('Manual load of chat.js succeeded');
                script.onerror = () => console.error('Failed to load chat.js manually');
                document.head.appendChild(script);
            }
        });
    </script>
</body>
</html>