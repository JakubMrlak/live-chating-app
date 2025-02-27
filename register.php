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
                <li><a href="./index.php">Login</a></li>                     
            </ul>
        </nav>
    </header>
    
    <main>
        <h1 id="main_title">Secure Chat</h1>
        <div class="form_body">
            <h1 id="login_header">Register</h1>
            <br>
            <?php session_start(); ?>
                <?php if (isset($_SESSION['message'])): ?>
                <div class="alert <?php echo $_SESSION['msg_type']; ?>">
                    <?php echo $_SESSION['message']; ?>
                </div>
                <?php unset($_SESSION['message']); unset($_SESSION['msg_type']); ?>
            <?php endif; ?>

            <form action="./php/Register_action.php" method="post" class="form" >
                <input name="Name" type="text" placeholder="Name" class="form_input" required>
                <input name="Email" type="email" placeholder="Email" class="form_input" required>
                <input name="Password" type="password" placeholder="Password" class="form_input" required>
                <input name="Confirm_password" type="password" placeholder="Confirm password" class="form_input" required> 
                <input type="submit" value="Register" class="submit_button" required>
            </form>
        </div> 
    </main>
    <footer>
        <h1>© 2025 Rights reserved | MJ</h1>  
    </footer>
</body>
</html>