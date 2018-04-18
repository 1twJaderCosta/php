<?php
function getValores($numAlgoritmo,$quantX,$quantRestri){
$quantB = $quantRestri;	
	/*
	$numAlgoritmo = 170;  //usado para teste
	*/
	
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
		//$k = $somaRestri+2;
		$fbArm;
		for($k = $somaRestri+2; $k < $quantK; $k++){
			$fbArm[$k] = $rec2[$k];
		}
		$fbArmazena = array_chunk($fbArm,$quantRestri+1); 
		
	
		// ----------------------------------------------------comecar calculos
		//$xArmazena = array_values($xArmazena);
		$menor = min($xArmazena); 
		print_r($xArmazena);
		
															//menorrrrr numerooo de XARMAZENAAAAAA
		$posicaoMenor = array_search( $menor , $xArmazena ); // menor numero-menor posicao
		print_r($posicaoMenor);
		if($xArmazena[$posicaoMenor] >= 0){
			$sql = "use Simplex";
			$conn->exec($sql);
			$sql = 'INSERT INTO `fim` (`fim`) VALUES ( '.$numAlgoritmo.')';
			$conn->exec($sql);
			return -1;
		}
		
		$posicaoMenor2 = $posicaoMenor -1;
		$linhas[0] = 1;
		for($i = 0; $i < $quantRestri; $i++){
		
		if($restriArmazena[$i][$posicaoMenor2] != 0){	
		$linha[$i] = ($fbArmazena[$i][$quantRestri]) /($restriArmazena[$i][$posicaoMenor]) ;  // divide linha por coluna para pegar menor numero positivo
		}
		
		else if($linha[$i] > 0){
			$linhas[$i] = $linha[$i];
		}
		else {
			$sql = "use Simplex";
			$conn->exec($sql);
			$sql = 'INSERT INTO `fim` (`fim`) VALUES ( '.$numAlgoritmo.')';
			$conn->exec($sql);
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
		
		//============== insere resultador Banco ---------
		/*
		$nRestriArmazena;  // valor resposta restri
		$nXfbArmazena;
		$nXFOArmazena;
		$bFO;
		$FOxf
		*/
		//---------------------------------------------------------- final xFO
		$sXFO = "1 ";
		$iXFO = " `x0` ";
		$cXFO = " x0 double";
		for($i = 0; $i < sizeof($nXFOArmazena);$i++){
			$sXFO .= ", ".round($nXFOArmazena[$i],2 )."";
			$j = $i+1;
			$iXFO .= ", `x".$j."`";	
			$cXFO .= ", x".$j." double";
		}
		//--------------------------------------------------------------------------
		$sFOx = "";
		$iFOx = "";
		$cFOx = "";
		for($i = 0; $i < sizeof($FOxf); $i++ ){
			$j = $i+1;
			$sFOx .= ", ".round($FOxf[$i+$UUK],2)."";
			$iFOx .= ", `FOxf".$j."`";
			$cFOx .= ", FOxf".$j." double";
		}
		//-------------------------------------- B fo incluido com FOxf
		$sRestri = "";
		$iRestri = "";
		$cRestri = "";
		for($j = 1; $j <= sizeof($nRestriArmazena);$j++){
			for($i = 1; $i <= sizeof($nRestriArmazena[0]); $i++){
				$sRestri .= " , ".round($nRestriArmazena[$j-1][$i-1],2)."";
				$iRestri .= ", `restri".$j."".$i."`";
				$cRestri .= ", restri".$j."".$i." double";
			}
		}
		
		$sXFB = "";
		$iXFB = "";
		$cXFB = "";
		/*
		$tamXF = sizeof($nXfbArmazena[0]);
		for($j = 1; $j <= sizeof($nXfbArmazena);$j++){
			for($i = 1; $i <= sizeof($nXfbArmazena[0]); $i++){
				if($tamXF == $i ){
					$sXFB .= " , ".round($nXfbArmazena[$j-1][$i-1],2)."";
					$iXFB .= ", `b".$j."`";
					$cXFB .= ", b".$j." double";
				}else{
				$sXFB .= " , ".round($nXfbArmazena[$j-1][$i-1],2)."";
				$iXFB .= ", `xf".$j."".$i."`";
				$cXFB .= ", xf".$j."".$i." double";
				}
			}
		}
		*/
		$sB = "";
		$iB = "";
		$cB = "";
		$tamXF = sizeof($nXfbArmazena[0]);
		for($j = 1; $j <= sizeof($nXfbArmazena);$j++){
			for($i = 1; $i <= sizeof($nXfbArmazena[0]); $i++){
				if($tamXF == $i ){
					$sB .= " , ".round($nXfbArmazena[$j-1][$i-1],2)."";
					$iB .= ", `b".$j."`";
					$cB .= ", b".$j." double";
				}else{
				$sXFB .= " , ".round($nXfbArmazena[$j-1][$i-1],2)."";
				$iXFB .= ", `xf".$j."".$i."`";
				$cXFB .= ", xf".$j."".$i." double";
				}
			}
		}
		$iB .= ", `b0`";
		$cB .= ", b0 double";
		$sB .= ", ".round($bFO)."";
		
		$numAlgoritmo2 = $numAlgoritmo+1;
		$sql = "use Simplex";
		$conn->exec($sql);
		$sql = 'CREATE TABLE IF NOT EXISTS Algoritmo'.$numAlgoritmo2.' (
                '.$cXFO.', restri0 double'.$cRestri.''.$cXFB.''.$cB.''.$cFOx.')';

		
		$conn->exec($sql);
		$sql = "use Simplex";
		$conn->exec($sql);
		$sql = 'INSERT INTO `algoritmo'.$numAlgoritmo2.'` ('.$iXFO.', `restri0`'.$iRestri.''.$iXFB.''.$iB.''.$iFOx.') 
		VALUES ('.$sXFO.', 0 '.$sRestri.''.$sXFB.''.$sB.''.$sFOx.')';
		$conn->exec($sql);

		
		
		$check1 = min($FOxf);
		$check2 = min($nXFOArmazena);
	
		if($check1 < 0 || $check2 < 0){
			return $numAlgoritmo2;
		}else{
			$sql = "use Simplex";
			$conn->exec($sql);
			$sql = 'INSERT INTO `fim` (`fim`) VALUES ( '.$numAlgoritmo2.')';
			$conn->exec($sql);
			return -1;
		}
		$conn->exec($sql);
		
			
		
}		
	
?>

