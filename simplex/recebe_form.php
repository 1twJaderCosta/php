<html>
 <head>
 <link rel="stylesheet" type="text/css" href="css/cubo.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
 </head>
 
 <body>
 

<?php
	require_once('getValores.php');
	
	$quantX = $_POST['quantX'];
	$quantRestri = $_POST['quantRestri'];
	
	 
	
	$valorTableX = "x0 int ";
	$insereTableX = "`x0` ";
	$insereTableRestri = "`restri0` ";
	$insereXPost = "1";
	$insereRestriPost = "0";
	$xf = ", b0 int";
	$bTable = "";
	$bInsereTable = "";
	$FOxf = "";
	$FOxf1 = "";
	$FOxf2 = "";
	
	for($x = 1; $x <= $quantX; $x++ ){	
		$valorTableX .= ", x".$x." int ";
		
		$insereTableX .= ",`x".$x."`";  //passa para insere
		$insereXPost .= ','.$_POST['x'.$x.''];
		
		
	}
	
	
	
	$valorTableRestri = "restri0 int ";
	for($j = 1; $j <= $quantRestri; $j++){
		  
		$FOxf .= ", FOxf".$j." int ";
		$FOxf1 .= ", `FOxf".$j."`";
		$FOxf2 .= ", 0 ";
		
	for($i = 1; $i <= $quantX; $i++ ){		
			$valorTableRestri .= ", restri".$j."".$i." int ";
					
			$insereTableRestri .= ',`restri'.$j.''.$i.'`';
			$insereRestriPost .= ','.$_POST['restri'.$j.''.$i.''];
				
			
	  }
	  
	  
		$bTable.= ",`b".$j."`";  // b posição
		$bInsereTable .= ','.$_POST['b'.$j.'']; //recebe B
		
		
	  
	  
	  }
	//--------------------------------------   
	
	
	
	$xfInsere = "";
	$xfInsere2 = "";
	for($y = 1; $y <= $quantRestri; ++$y){
		
		
	for($h = 1;$h <= $quantRestri; ++$h){
			$xfInsere2 .= ", `xf".$y."".$h."`";
			$xf .= ", xf".$y."".$h." int"; // xf
		 if($h == $y){
			 $xfInsere .= ", 1";
		 }else{
			 $xfInsere .= ", 0";
		 }	
	}
	
	$xf .= ", b".$y." int";  //insere b apos xf
	
	}
	
	
	
	//------------------------------------------------
	  
	  
	$valoresIns = $insereXPost.",".$insereRestriPost;
	$valoresCaminho = $insereTableX.", ".$insereTableRestri;
  	  
	function criarDB($valor,$vTable,$vTableRestri,$vCaminho,$vIns,$xfb,$xfI,$xfI2,$bT,$bIT,$FOxf,$FOxf1,$FOxf2,$quantX,$quantRestri){	
	require_once('login.php');
	
	$sql = "drop database simplex";
    $conn->exec($sql);
	
   	
		/*
		$sql = "use Simplex";
		$conn->exec($sql);
		$sql = 'select * from iniFim';
		$teste5 = $conn->prepare($sql);
		$teste5->execute();
		$iniFim2 = $teste5->fetchAll();
	*/
	
	
	
	$sql = "CREATE DATABASE IF NOT EXISTS Simplex";
    $conn->exec($sql);
    $sql = "use Simplex";
    $conn->exec($sql);
    $sql = "CREATE TABLE IF NOT EXISTS Algoritmo".$valor." (
                ".$vTable.",".$vTableRestri."".$xfb."".$FOxf.")";

    $conn->exec($sql);
	$b0 = ",`b0` ";
	$bVal = ", 0";
	$sql = "use Simplex";
    $conn->exec($sql);
	$sql = 'INSERT INTO `algoritmo'.$valor.'` ('.$vCaminho.''.$xfI2.''.$bT.''.$b0.''.$FOxf1.') 
	VALUES ('.$vIns.''.$xfI.''.$bIT.''.$bVal.''.$FOxf2.')';	
	$conn->exec($sql);
	//---------------------------------------------------------------------------------
	$sql = "use Simplex";
    $conn->exec($sql);
    $sql = "CREATE TABLE IF NOT EXISTS inicio ( inicio int)";
    $conn->exec($sql);
	$sql = "use Simplex";
    $conn->exec($sql);
    $sql = "CREATE TABLE IF NOT EXISTS fim ( fim int)";
    $conn->exec($sql);
	$sql = "use Simplex";
		$conn->exec($sql);
		$sql = 'INSERT INTO `inicio` (`inicio`) VALUES ( '.$valor.' )';	
		$conn->exec($sql);
	//------------------------------------------------------------------------------------
	
	

			$get = getValores($valor,$quantX,$quantRestri);
			$i = 0;		
			if($get != -1){
			$get = $get -1;	
			while( $get != -1 ){
			$sql = "use Simplex";
			$conn->exec($sql);
			$sql = 'select * from vars'.$get;
			$teste = $conn->prepare($sql);
			$teste->execute();
			$recebee = $teste->fetchAll();
			$recebe2 = $recebee[0];
			$i = $get;
			$get = $get-1;
			
			
			}
			
			}
			
			
			
			else{
				//---------------ini  fim
				$sql = "use Simplex";
				$conn->exec($sql);
				$sql = 'select * from inicio';
				$teste = $conn->prepare($sql);
				$teste->execute();
				$recebee = $teste->fetchAll();	
				$ini = $recebee[0][0];
				
				$sql = "use Simplex";
				$conn->exec($sql);
				$sql = 'select * from fim';
				$teste2 = $conn->prepare($sql);
				$teste2->execute();
				$recebee14 = $teste2->fetchAll();
				$fim = $recebee14[0][0];
				//--------------------------------------------------------------------
				
				$sql = "use Simplex";
				$conn->exec($sql);
				$sql = 'select * from vars'.$ini;
				$teste22 = $conn->prepare($sql);
				$teste22->execute();
				$quant22 = $teste22->fetchAll();
				//1 x //2 restr//3b
				
				$getX = $quant22[0][1];
				$getR = $quant22[0][2];
				$getB = $quant22[0][3];
				
				$j1 = 0;

				
				for($i = $ini; $i <= $fim; $i++){
					
					$sql = "use Simplex";
					$conn->exec($sql);
					$sql = 'select * from algoritmo'.$i;
					$teste2 = $conn->prepare($sql);
					$teste2->execute();
					$recebeeR[$j1] = $teste2->fetchAll();
					$j1++;
				}
				
				
				$quantXX = sizeof($recebeeR);
				$quantL = sizeof($recebeeR[0][0])/2;
				$quantR = ($getX * $getR) + $getX;
				$gambi = $getX;
				$xff = ($getR * $getR) + ($quantR+1) + $getR;
				$saveX;
				$saveXF;
				for($i = 0; $i < $quantXX; $i++){
				for($x = 0; $x < $getX; $x ++){
					$saveX[$i][$x] = $recebeeR[$i][0][$x];
				}
				}
				for($i = 0; $i < $quantXX; $i++){
				for($x = ($xff+2); $x < $quantL; $x ++){
					$saveXF[$i][$x] = $recebeeR[$i][0][$x];
				}
				}
				
				
				$saveB;
				for($i = 0; $i < $quantXX; $i++){		
				for($j = 0; $j < $quantL; $j++ ) {
				if( $j >= ($quantR+2) &&  $j < ($quantR+3) ){
					$saveB[$i][$j] = $recebeeR[$i][0][$j];				
				}
				}
				}
				//print_r($recebeeR[1]);
				
				$xPrinta;
				for($i = 0; $i < $quantXX; $i++){
				$xPrinta[$i] = array_merge ( $saveX[$i], $saveXF[$i], $saveB[$i] );
				}
				//---------------------------------------------------
				$somaRestri2 = ($getX * $getR)+$getX+2;
				$restriArm2;
				for($i = 0; $i < $getR; $i++){
				for($j = $getX+2; $j < $somaRestri2; $j++){
				$restriArm2[$i][$j] = $recebeeR[$i][0][$j];
				}
				}
				//$restriArmazena = array_chunk($restriArm,$quantX);
				
				
				$quantK2 = (sizeof($recebeeR[0][0])/2) - $getR;
				$k = $somaRestri2+1;
				$fbArm2;
				for($i = 0; $i < $quantXX; $i++){	
				for($k = $somaRestri2+1 ; $k < $quantK2; $k++){
				$fbArm2[$i][$k] = $recebeeR[$i][0][$k];
				}
				}
				for ($i = 0; $i < $getR; $i++){
				$restriArmazena2[$i] = array_chunk($restriArm2[$i],$quantX);	
				}
				for ($t = 0; $t < $getR; $t++){
				$fbArm2[$t] = array_values($fbArm2[$t]);
				}
				for($n = 0; $n < $getR; $n++){
				for($o=0; $o < $getR; $o++){
				$fbA2[$n] = array_chunk($fbArm2[$n],$getR+1);
				}
				}
				//print_r($restriArmazena2[0]);
						
				
				for($n = 0; $n < $getR; $n++){
				for($i=0; $i < $getR; $i++){
					$restriPrinta[$n][$i] = array_merge (  $restriArmazena2[$n][$i], $fbA2[$n][$i]);
				}
				}
		
				//print_r($restriPrinta[0]);
				//$fbArmazena2 = array_chunk($fbArm2[0],$getR+1);
						
				
				for($i = 0; $i < $quantXX; $i++){	
				$gambi = sizeof($xPrinta[0]);	
					$po = $i+1;
					echo "<br>";
					echo '<label class="w3-text-blue "> Algoritmo '.$po.' </label><br>';
					for($j = 0; $j < $quantL; $j++ ) {
						
						
						if($j < $getX){
							if($j == 0){
								//for($j = 0; $j < sizeof($xPrinta); $j++ ){
								for($y = 0; $y < sizeof($xPrinta[0]); $y++ ){	
									
								echo "<input type='text' class='w3-input w3-border' style='width:60px; display:inline' value = '".$xPrinta[$i][$y]."' >";
								}
							
							}
						}
						
								if($j == 0){
								for($y = 0; $y < sizeof($restriPrinta[0]); $y++ ){
									echo "<br>";
									for($b=0; $b < sizeof($xPrinta[0]); $b++ ){
									//print_r($restriPrinta[$i][$y][$b]);
							
									echo "<input type='text' class='w3-input w3-border' style='width:60px; display:inline' value = '".$restriPrinta[$i][$y][$b]."' >";
								
								}
								}
								echo "<br>";
								}
						
						
				/*
						
							else if( $j >= $getX &&  $j < $quantR  ){
								
								echo "<input type='text' value = '".$recebeeR[$i][0][$j]."' >";
								
								
							}
							
							else if( $j >= ($quantR+1) &&  $j < ($quantR+2) ){
								print_r(" b 0");
							}
							
							else if( $j >= ($quantR+2) && $j < ($xff+2)){
								
							}
						}				
						print_r("Nova Tab");
				} 
			//print_r($recebeeR[$i][0][$j]);
				
			*/			
			}}
				
				
			} //ELSE TOP
			

	
	} // function fim
	
	
	$numAlgoritmo = rand ( 1 ,10000000 );
	criarDB($numAlgoritmo,$valorTableX,$valorTableRestri,$valoresCaminho,$valoresIns,$xf,$xfInsere,$xfInsere2,$bTable,$bInsereTable,$FOxf,$FOxf1,$FOxf2,$quantX,$quantRestri); //cria e insere valores
	
	
?>
</body>
</html>
