<?php
session_start();

include_once "DBController.php";

$db = new DBController();
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $query = "SELECT * FROM users WHERE NumeUtilizator = :username";
        $params = [':username' => $username];
        $user = $db->getDBResult($query, $params);

        if ($user && password_verify($password, $user[0]['ParolaHash'])) {
            $_SESSION['username'] = $user[0]['NumeUtilizator'];
            $_SESSION['UserID'] = $user[0]['UserID'];
            header("Location: hpli.php");
            exit();
        } else {
            $error = "Username sau parola gresita.";
        }
    } catch (Exception $e) {
        $error = "Eroare la verificarea utilizatorului: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="clrimpreuna.css">
</head>
<body>
    <header>
	<div style="padding: 10px;">
        <h1> Log In</h1>
		</div>
    </header>

    <ul>
        <li><a class="active" href="homepage.html">Home Page</a></li>
        <li><a href="LogIn.php">Log In</a></li>
        <li><a href="sign_up.php">Sign Up</a></li>
        <li><a href="educational.html">Știai că?</a></li>
    </ul>

    <div class="login">
        
        <?php if ($error): ?>
            <div class="alert"><?= $error; ?></div>
        <?php endif; ?>

        <form action="LogIn.php" method="POST">
            <div class="form-group">
                <label for="username">Nume Utilizator</label>
                <input type="text" id="username" name="username" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="password">Parola</label>
                <input type="password" id="password" name="password" class="form-input" required>
            </div>

            <button type="submit" class="btn-submit">Login</button>
        </form>
    </div>
</body>
</html>
