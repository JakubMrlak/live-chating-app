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
        <a class="group-1" href="index.php">
        <div>
            <img class="Icon" media="(prefers-color-scheme: dark)" src="./imgs/icons/secure_mail_icon_dark.svg" alt="logo">
        </div>
        </a>
        <nav class="primary-navbar">
            <ul>
                <li id="first"><a href="index.php">Home</a></li>
                <li><a href="">Contact us</a></li>
                <li><a href="">Explore</a></li>                     
            </ul>
        </nav>
    </header>
    
    <main>
        <h1 id="main_title">Secure Chat</h1>
        <div class="form_body">
            <h1 id="login_header">Login</h1>
            <form action="login.php" method="get" class="form" >
                <input type="text" placeholder="email" class="form_input" required>
                <input type="password" placeholder="password" class="form_input" required> 
            </form>
            <div class="other_func">   
                <div class="other func">
                    <a type="submit" href="register.php">Register</a>
                </div>
                <div class="forgoten_password">
                    <a type="submit" href="forgoten_pass.php">Forgoten password?</a>
                </div>
            </div>
            <input type="submit" value="Login" class="submit_button" required>
        </div> 
    </main>
    <footer>
        <h1>
        © 2025 Rights reserved | MJ
        </h1>  
    </footer>
</body>
</html>