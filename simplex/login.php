<?php

$servername = 'localhost';
try
{
	$conn = new PDO("mysql:host=$servername", 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}



 ?>

 