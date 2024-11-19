<?php

$hostname = 'localhost';

$username = 'root';

$password = '';

$database= 'calarim_impreuna';
try {
 
 $db = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8", $username, $password);

 
 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);


 
} catch (PDOException $e) {
 die("Conexiunea la baza de date a esuat:") . $e->getMessage();

}
?>
