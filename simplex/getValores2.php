<?php
//function getValores($numAlgoritmo,$quantX,$quantRestri){
//$quantB = $quantRestri;	
	
	$numAlgoritmo = 1;  //usado para teste
	$quantX = 3;
	$quantRestri = 2;
	$quantB = 2;


	
	$xArmazena;
	$restriArmazena;
	$fbArmazena;
	
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
		$sql = "CREATE TABLE IF NOT EXISTS vars".$numAlgoritmo." ( algoritmo double, quantX double, quantRestri double, qunatB double)";
		$conn->exec($sql);
		$sql = "use Simplex";
		$conn->exec($sql);
		$quantB = $quantRestri;
		$sql = 'INSERT INTO `vars'.$numAlgoritmo.'` (`algoritmo`, `quantX`, `quantRestri`, `qunatB`) 
		VALUES ('.$numAlgoritmo.','.$quantX.','.$quantRestri.','.$quantB.')';	
		$conn->exec($sql);
		
		
		$sql = "use Simplex";
		$conn->exec($sql);
		$sql = 'select * from algoritmo'.$numAlgoritmo;
		$teste = $conn->prepare($sql);
		$teste->execute();
		$rec = $teste->fetchAll();
		$rec2 = $rec[0];

		
		//------------------------------------------------ armazena x
		for($j = 1; $j <= $quantX; $j++){
			$xArmazena[$j] = $rec2[$j];
		}
		
		//------------------------------------------------armazena restricoes
		$somaRestri = ($quantX * $quantRestri)+$quantX+1;
		$restriArm;
		for($j = $quantX+2; $j <= $somaRestri; $j++){
			$restriArm[$j] = $rec2[$j];
		}
		$restriArmazena = array_chunk($restriArm,$quantX);
	//--------------------------------------------------------armazena xf+b	
		$quantK = (sizeof($rec2)/2) - $quantRestri;
		$k = $somaRestri+2;
		$fbArm;
		for($k ; $k < $quantK; $k++){
			$fbArm[$k] = $rec2[$k];
		}
		$fbArmazena = array_chunk($fbArm,$quantRestri+1); 
		
	
		// ----------------------------------------------------comecar calculos
		
		$menor = min($xArmazena); 																//menorrrrr numerooo de XARMAZENAAAAAA
		$posicaoMenor = array_search( $menor , $xArmazena ); // menor numero-menor posicao
		if($xArmazena[$posicaoMenor] >= 0){
			return -1;
		}
		
		$posicaoMenor2 = $posicaoMenor -1;
		
		for($i = 0; $i < $quantRestri; $i++){
		
		if($restriArmazena[$i][$posicaoMenor2] != 0){	
		$linha[$i] = ($fbArmazena[$i][$quantRestri]) /($restriArmazena[$i][$posicaoMenor]) ;  // divide linha por coluna para pegar menor numero positivo
		}
		
		if($linha[$i] > 0){
			$linhas[$i] = $linha[$i];
		}
		else {
			return -1;
		}
		
		}
		$menorPOsitivo = min($linhas);      // menor positivo
		
		$linhaMenorPOsitivo = array_search( $menorPOsitivo, $linha);
		
		$xfBPivo = $fbArmazena[$linhaMenorPOsitivo];  //  xf b - linha menor positivo
		$restriPivo = $restriArmazena[$linhaMenorPOsitivo]; // x linha menor positivo
		$elemenPivo = $restriArmazena[$linhaMenorPOsitivo][$posicaoMenor2]; // valor elemento pivo
	
		
		$nRestriPivo;
		$nXfBPivo;
		$nXArmazena;
		
		for($i = 0; $i < sizeof($restriPivo); $i++ ){
			if( $elemenPivo == 0){
				$nRestriPivo[$i] = 0;
			}else{
				$nRestriPivo[$i] = $restriPivo[$i] / $elemenPivo;   // numero linha dividido por elemento pivo
			}
		}
		for($i = 0; $i < sizeof($xfBPivo); $i++ ){
			if( $elemenPivo == 0){
				$nXfBPivo[$i] = 0;
			}else{
				$nXfBPivo[$i] = $xfBPivo[$i] / $elemenPivo; // numero linha dividido por elemento pivo
			}
		}
		
		
	//------------------------ nova linha pivo gerada a cima , nRestriPivo e nXfBPivo	
		
		$nRestriArmazena;  // valor resposta restri
		$nXfbArmazena;
		$nXFOArmazena;
		$bFO;
		
		$tamRestri = sizeof($restriArmazena[0]);
		
		for($j = 0; $j < sizeof($restriArmazena);$j++){ // roda o tanto de linha 
		for($i = 0; $i <  $tamRestri ;$i++){   // roda o tanto de item
			if($restriArmazena[$j] == $restriArmazena[$linhaMenorPOsitivo]){ // se linha for linha pivo
				$nRestriArmazena[$j] = $nRestriPivo; 
					
			}else{
				
				if( $restriArmazena[$j][$posicaoMenor2] < 0){
				$nRestriArmazena[$j][$i] = $restriArmazena[$j][$i] + ($nRestriPivo[$i] * (abs($restriArmazena[$j][$posicaoMenor])) ) ;
				
				}else{
				$nRestriArmazena[$j][$i] = $restriArmazena[$j][$i] + ($nRestriPivo[$i] * ($restriArmazena[$j][$posicaoMenor] * -1) ) ;
				
				
				}
				
				
			}
				
		}
		}
			
		
		
		for($j = 0; $j < sizeof($fbArmazena);$j++){ // roda o tanto de linha 
		for($i = 0; $i < sizeof($fbArmazena[0]);$i++){   // roda o tanto de item
		
			if($fbArmazena[$j] == $fbArmazena[$linhaMenorPOsitivo]){ // se linha for linha pivo
				$nXfbArmazena[$j] = $nXfBPivo; 
							
			}else{
				
				if( $restriArmazena[$j][$posicaoMenor] < 0){
				$nXfbArmazena[$j][$i] = $fbArmazena[$j][$i] + ($nXfBPivo[$i] * (abs($restriArmazena[$j][$posicaoMenor])) ) ; 
				
				}else{
			
				$nXfbArmazena[$j][$i] = $fbArmazena[$j][$i] + ($nXfBPivo[$i] * ($restriArmazena[$j][$posicaoMenor] * -1) ) ; 
				}
			
			}
		}
		}
		
		
		for($i = 0; $i < sizeof($xArmazena); $i++){
			if($xArmazena[$posicaoMenor] < 0){
				$nXFOArmazena[$i] = $xArmazena[$i+1] +($nRestriPivo[$i] * (abs($xArmazena[$posicaoMenor])) );
			}else{
				$nXFOArmazena[$i] = $xArmazena[$i+1] +($nRestriPivo[$i] * ($xArmazena[$posicaoMenor] * -1 ) );
			}
		}
		
		$b0 = $rec2[$somaRestri+1];  		
		$ondeB = sizeof($nXfBPivo) -1;		 
		$bFO =  $b0+( $nXfBPivo[$ondeB] * $xArmazena[$posicaoMenor] );
		$FOxf;
		
		$foFim = sizeof($rec2)/2-1 ;
		$foIni = $foFim - $quantRestri;	
		
		
		$UUK = $foIni+1;
		for($k = $foIni+1 ; $k <= $foFim; $k++){	
		if($xArmazena[$posicaoMenor] < 0){
		$FOxf[$k] = $rec2[$k] +  ( $nXfBPivo[$k - $UUK] * (abs($xArmazena[$posicaoMenor])) );
		}else{
			$FOxf[$k] = $rec2[$k] +  ( $nXfBPivo[$k - $UUK] * ( $xArmazena[$posicaoMenor] * -1 ) );
		}
		}
		
		print_r("-------------");
		print_r( $xArmazena );
		print_r("-------------");
		
			
		
//}		
	
?>

