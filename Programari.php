<?php

session_start();

include_once "ConectareBD.php";

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nume = trim($_POST['nume']);
    $email = trim($_POST['email']);
    $telefon = trim($_POST['telefon']);
    $data_programare = $_POST['data_programare'];
    $ora = $_POST['ora'];
    $mesaj = trim($_POST['mesaj']);

    // Validare
    if (empty($nume) || empty($email) || empty($data_programare) || empty($ora)) {
        $message = "Toate câmpurile obligatorii trebuie completate.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Adresa de email este invalidă.";
    } else {
        //ziua saptamanii, ora si data selectata
        $ziua_saptamanii = date('N', strtotime($data_programare)); // 1 = Luni, 7 = Duminică
        $ora_selectata = (int)substr($ora, 0, 2); // primele 2 caractere din 'HH:MM'
        // intervale orare:
        if (($ziua_saptamanii >= 1 && $ziua_saptamanii <= 5 && ($ora_selectata < 15 || $ora_selectata >= 19)) || // Luni-Vineri 15:00-19:00
            ($ziua_saptamanii == 6 || $ziua_saptamanii == 7) && ($ora_selectata < 9 || $ora_selectata >= 12)) { // Sâmbătă-Duminică 09:00-12:00
            $message = "Ora selectată nu este validă pentru această zi. Luni-Vineri între 15:00 și 19:00 sau Sâmbătă-Duminică între 09:00 și 12:00.";
        } else {
            try {
                //adaugam date in baza de date
                $query = "INSERT INTO programari (nume, email, telefon, data_programare, ora, mesaj) 
                      VALUES (:nume, :email, :telefon, :data_programare, :ora, :mesaj)";
                $stmt = $db->prepare($query);
                //leg parametrii
                $stmt->bindParam(':nume', $nume);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':telefon', $telefon);
                $stmt->bindParam(':data_programare', $data_programare);
                $stmt->bindParam(':ora', $ora);
                $stmt->bindParam(':mesaj', $mesaj);

                if ($stmt->execute()) {
                    $message = "Programarea a fost salvată cu succes!";
                } else {
                    $message = "A apărut o eroare la salvarea programării.";
                }
            } catch (PDOException $e) {
                $message = "Eroare la conexiunea cu baza de date: " . $e->getMessage();
            }
        }
    }
}
if (!empty($message)) {
    echo "<p>$message</p>";
}
?>


<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programare Călărie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            max-width: 600px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
        }
        input, textarea {
            margin-bottom: 10px;
            padding: 10px;
            font-size: 16px;
        }
        button {
            padding: 10px;
            font-size: 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<h1>Programare pentru călărie</h1>
<form action = "programari.php" method="post">
    <label for="nume">Nume complet:</label>
    <input type="text" id="nume" name="nume" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="telefon">Telefon:</label>
    <input type="text" id="telefon" name="telefon">

    <label for="data_programare">Data programării:</label>
    <input type="date" id="data_programare" name="data_programare" required>

    <label for="ora">Ora:</label>
    <input type="time" id="ora" name="ora" required>

    <label for="mesaj">Mesaj (opțional):</label>
    <textarea id="mesaj" name="mesaj" rows="4"></textarea>

    <button type="submit">Programează-te</button>
</form>
</body>
</html>

