<?php

$hostname = 'localhost';

$username = 'root';

$password = '';

$db = 'calarim_impreuna';
try {
 
 $pdo = new PDO("mysql:host=$hostname;dbname=$db", $username, $password);

 
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 echo 'Conectat la baza de date: ' . $db;

 
} catch (PDOException $e) {
 echo 'Nu se poate conecta la baza de date: ' . $e->getMessage();
 exit();
}

?>