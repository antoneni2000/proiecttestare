<?php

session_start();
include_once "ConectareBD.php";  

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    $db= new DBController();

    
    $query = "SELECT * FROM users WHERE username = :username";
    $user = $db->getDBResult($query, [$username]);

    if ($user && password_verify($password, $user[0]['password'])) {
        $_SESSION['username'] = $user[0]['username'];
        header("Location: home.php");
        exit;
    } else {
        $error = "Username sau parola gresita.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="clrimpreuna.css">
</head>
<body>
    <header>
        <h1>Calarim Impreuna</h1>
    </header>
    <ul>
			<li><a class="active" href="homepage.html">Home Page</a></li>
			<li><a href="login.html">Log In</a></li>
			<li><a href="signup.html">Sign Up</a></li>
			<li><a href="programari.html">Programeaza-te</a></li>
			<li><a href="educational.html">Stiai ca?</a></li>
    </ul>
    <div class="login">
        <h2 class="login-title">Login</h2>
        <?php if ($error): ?>
            <div class="alert"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-input" id="username" required>
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-input" id="password" required>
            </div>
            <button type="submit" class="btn-submit">Login</button>
        </form>
    </div>
</body>
</html>
