<?php
session_start();

// Includem clasa DBController
include_once "DBController.php"; 

// Creăm o instanță a clasei DBController
$db = new DBController();


$message = '';
$horses = [];

try {
    // Obține lista de cai din baza de date
    $query = "SELECT HorseID, Nume FROM horses";
    $horses = $db->getDBResult($query);
} catch (Exception $e) {
    $message = "Eroare la încărcarea listei de cai: " . $e->getMessage();
}

// Verificăm dacă formularul a fost trimis	
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Variabilele PHP pentru datele primite din formular
    $data_programare = $_POST['data_programare'] ?? '';
    $ora = $_POST['ora'] ?? '';
    $mesaj = trim($_POST['mesaj'] ?? '');
    $HorseID = $_POST['HorseID'] ?? '';
    $UserID = $_SESSION['UserID'];

    // Validare date
    if (empty($data_programare) || empty($ora) || empty($HorseID) || empty($UserID)) {
        $message = "Toate câmpurile obligatorii trebuie completate.";
    } else {
        // Validare intervale orare
        $ziua_saptamanii = date('N', strtotime($data_programare)); // 1 = Luni, 7 = Duminică
        $ora_selectata = (int)substr($ora, 0, 2); // primele 2 caractere din 'HH:MM'
        
        if (($ziua_saptamanii >= 1 && $ziua_saptamanii <= 5 && ($ora_selectata < 15 || $ora_selectata >= 19)) ||
            ($ziua_saptamanii == 6 || $ziua_saptamanii == 7) && ($ora_selectata < 9 || $ora_selectata >= 12)) {
            $message = "Ora selectată nu este validă pentru această zi.";
        } else {
            try {
                // Inserare programare în baza de date
                $query = "INSERT INTO programari (data_programare, ora, mesaj, HorseID, UserID) 
                          VALUES (:data_programare, :ora, :mesaj, :HorseID, :UserID)";
                $params = [
                    ':data_programare' => $data_programare,
                    ':ora' => $ora,
                    ':mesaj' => $mesaj,
                    ':HorseID' => $HorseID,
                    ':UserID' => $UserID
                ];

                // Executăm inserarea în baza de date
                $db->updateDB($query, $params); 

                // Verificăm dacă trigger-ul a fost activat
                // De obicei trigger-ele nu dau feedback direct, dar dacă nu a apărut o eroare, presupunem că a fost activat
                $message = "Programarea a fost salvată cu succes!";
            } catch (Exception $e) {
                $message = "Eroare la conexiunea cu baza de date: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="clrimpreuna.css">
    <title>Programare Călărie</title>
</head>
<body>
    <header>
        <div style="padding: 10px;">
            <h1>Programare pentru călărie</h1>
        </div>
    </header>
    <ul>
        <li><a class="active" href="homepage.html">Home Page</a></li>
        <li><a href="LogIn.php">Log In</a></li>
        <li><a href="sign_up.php">Sign Up</a></li>
        <li><a href="Programari.php">Programeaza-te</a></li>
        <li><a href="educational.html">Stiai ca?</a></li>
    </ul>
    <div>
        <img src="HomePage.jpg" style="height:200px; width:400px">
    </div>
    <div class="my-div">
        <form action="programari.php" method="post">
            <div class="form-group">
                <label class="form-label" for="nume">Nume complet:</label>
                <input class="form-input" type="text" id="nume" name="nume" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="data_programare">Data programării:</label>
                <input class="form-input" type="date" id="data_programare" name="data_programare" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="ora">Ora:</label>
                <input class="form-input" type="time" id="ora" name="ora" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="mesaj">Mesaj (opțional):</label>
                <textarea class="form-input" id="mesaj" name="mesaj" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="HorseID">Selectează calul:</label>
                <select name="HorseID" class="form-input" required>
                    <?php
                    foreach ($horses as $horse) {
                        echo "<option value='" . $horse['HorseID'] . "'>" . $horse['Nume'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <button class="btn-submit" type="submit">Programează-te</button>
        </form>
        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
