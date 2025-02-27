<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: ./php/chat.php");
    exit();
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styles.css"/>
    <title>SecureChat</title>
    <link rel="icon" type="image/svg+xml" href="./imgs/icons/secure_mail_icon.svg" />
    <link rel="icon" type="image/svg+xml" media="(prefers-color-scheme: dark)" href="./imgs/icons/secure_mail_icon_dark.svg" />
</head>
<body>
    <header>
        <a class="group-1" href="./index.php">
        <div>
            <img class="Icon" media="(prefers-color-scheme: dark)" src="./imgs/icons/secure_mail_icon_dark.svg" alt="logo">
        </div>
        </a>
        <nav class="primary-navbar">
            <ul>
                <li id="first"><a href="./index.php">Home</a></li>
                <li><a href="./register.php">Register</a></li>                     
            </ul>
        </nav>
    </header>
    
    <main>
        <h1 id="main_title">Secure Chat</h1>
        <div class="form_body">
            <h1 id="login_header">Login</h1>
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert <?php echo $_SESSION['msg_type']; ?>">
                    <?php echo $_SESSION['message']; ?>
                </div>
                <?php unset($_SESSION['message']); unset($_SESSION['msg_type']); ?>
            <?php endif; ?>
            <form action="./php/login.php" method="post" class="form" >
                <input name="Email" type="email" placeholder="email" class="form_input" required>
                <input name="Password" type="password" placeholder="password" class="form_input" required> 
                <input type="submit" value="Login" class="submit_button" required>
            </form>
        </div> 
    </main>
    <footer>
        <h1>© 2025 Rights reserved | MJ</h1>  
    </footer>
</body>
</html>