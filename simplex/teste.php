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

		$sql = "use Simplex";
		$conn->exec($sql);
		$sql = 'select * from algoritmo151';
		$teste = $conn->prepare($sql);
		$teste->execute();
		$rec = $teste->fetchAll();
		$rec2 = $rec[0];
		print_r($rec2);
		
?>