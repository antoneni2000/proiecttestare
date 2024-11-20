<?php
require_once 'ConectareBD.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$nume= $_POST['nume'];
	$data_nasterii= $_POST['data_nasterii'];
	$email= $_POST['email'];
	$telefon=$_POST['telefon'];
	$Username= $_POST['Username'];
	$parola = password_hash($_POST['parola'], PASSWORD_DEFAULT);
	$NivelCompetenta= $_POST['NivelCompetenta'];
	$db=new DBController();
	$query="INSERT INTO users (nume, data_nasterii, email, telefon, Username, parola, NivelCompetenta) VALUES (?, ?, ?, ?, ?, ?, ?)";
	
	 try {
		  $db->updateDB($query, [$nume, $data_nasterii, $email, $telefon, $Username, $parola, $NivelCompetenta]);
           	  echo "Înregistrarea a fost adăugată cu succes!";
        } catch(Exception $e) {
            echo "Eroare la inserarea datelor: " . $e->getMessage();
        }
 
}

if ($e) {
    echo "<p style='color:red;'>$e</p>";
}	
?>

<!DOCTYPE html>
<html>
	<head>
	<title> Sign Up </title>
	<link rel="stylesheet" href="clrimpreuna.css">
	</head>
	<body>
		<header>
		<h1> Calarim Impreuna </h1>
		</header>
		<ul>
			<li><a class="active" href="homepage.html">Home Page</a></li>
			<li><a href="login.html">Log In</a></li>
			<li><a href="signup.html">Sign Up</a></li>
			<li><a href="programari.html">Programeaza-te</a></li>
			<li><a href="educational.html">Stiai ca?</a></li>
		</ul>
	
		<div class="registration-form">
    <h2>Inregistrare</h2>
    <form action="register.php" method="post">
        <div class="form-group">
            <label for="nume">Nume</label>
            <input type="text" id="nume" name="nume" required>
        </div>
        <div class="form-group">
            <label for="data_nasterii">Data Nasterii</label>
            <input type="date" id="data_nasterii" name="data_nasterii" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="telefon">Nr de Telefon</label>
            <input type="tel" id="telefon" name="telefon" required>
        </div>
		<div class="form-group">
		<label for="NivelCompetenta">Nivel competenta</label>
		<select id="NivelCompetenta" name="NivelCompetenta">
			<option value="incepator">Incepator</option>
			<option value="incepator">Intermediar</option>
			<option value="incepator">Avansat</option>
		</select>
        <div class="form-group">
            <label for="Username">Username</label>
            <input type="text" id="Username" name="Username" required>
        </div>
        <div class="form-group">
            <label for="parola">Parola</label>
            <input type="password" id="parola" name="parola" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Inregistreaza-te">
        </div>
    </form>
</div>

</body>
</html>
	</body>
</html>
	
