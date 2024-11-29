<?php
include_once 'DBController.php';

$error = '';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numeUtilizator = $_POST['NumeUtilizator'];
    $parola = password_hash($_POST['Parola'], PASSWORD_DEFAULT);
    $nivelCompetenta = $_POST['NivelCompetenta'];
    $nume = $_POST['Nume'];
    $email = $_POST['Email'];
    $nrTelefon = $_POST['NrTelefon'];
    $dataNasterii = $_POST['DataNasterii'];
    $dataCrearii = date('Y-m-d H:i:s');

    try {
        $dbController = new DBController();
        $db = $dbController->getConnection();

        $db->beginTransaction();

        $query = "INSERT INTO users (NumeUtilizator, ParolaHash, NivelCompetenta, DataCrearii, Nume, Email, NrTelefon, DataNasterii) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            $numeUtilizator, 
            $parola, 
            $nivelCompetenta, 
            $dataCrearii, 
            $nume, 
            $email, 
            $nrTelefon, 
            $dataNasterii
        ]);

        $db->commit();

        $message = "Înregistrarea a fost realizată cu succes!";
    } catch (Exception $e) {
        $db->rollBack();
        $error = "Eroare la inserarea datelor: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="clrimpreuna.css">
</head>
<body>
    <header>
	<div style="padding: 10px;">
        <h1> Călărim Împreună </h1>
		</div>
    </header>
    <ul>
        <li><a class="active" href="homepage.html">Home Page</a></li>
        <li><a href="LogIn.php">Log In</a></li>
        <li><a href="sign_up.php">Sign Up</a></li>
    </ul>

    <div class="registration-form">
        <h2>Înregistrare</h2>
        
        <?php if ($error): ?>
            <div class="alert"><?= $error; ?></div>
        <?php endif; ?>
        <?php if ($message): ?>
            <div class="alert"><?= $message; ?></div>
        <?php endif; ?>

        <form action="sign_up.php" method="POST">
            <div class="form-group">
                <label for="NumeUtilizator" class="form-label">Nume Utilizator</label>
                <input type="text" id="NumeUtilizator" name="NumeUtilizator" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="Parola" class="form-label">Parola</label>
                <input type="password" id="Parola" name="Parola" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="NivelCompetenta" class="form-label">Nivel Competentă</label>
                <select id="NivelCompetenta" name="NivelCompetenta" class="form-input" required>
                    <option value="Începător">Începător</option>
                    <option value="Intermediar">Intermediar</option>
                    <option value="Avansat">Avansat</option>
                </select>
            </div>

            <div class="form-group">
                <label for="Nume" class="form-label">Nume</label>
                <input type="text" id="Nume" name="Nume" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="Email" class="form-label">Email</label>
                <input type="email" id="Email" name="Email" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="NrTelefon" class="form-label">Nr Telefon</label>
                <input type="tel" id="NrTelefon" name="NrTelefon" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="DataNasterii" class="form-label">Data Nașterii</label>
                <input type="date" id="DataNasterii" name="DataNasterii" class="form-input" required>
            </div>

            <button type="submit" class="btn-submit">Înregistrează-te</button>
        </form>
    </div>
</body>
</html>
