 <!DOCTYPE html>
 <html>
 <head>
 <link rel="stylesheet" type="text/css" href="css/cubo.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
 </head>
 
 <body>
 
	<!--  Inserindo Java Script  -->
	<h1 id="jSimplex"> Método Simplex </h1>
	<h4 id="jOP"> Otimizar os recursos com Programação Linear </h4>
	<div class="meuWrap">
	
	<div class="w3-row-padding">
		<div class="w3-half">
		<label class="w3-text-blue "> Insira a quantidade de x </label>
		<input type="text" id="x" class="w3-input w3-border" placeholder="X">
		</div>
		<div class="w3-half">
		<label class="w3-text-blue "> Insira a quantidade de restrições </label>
		<input type="text" id="restricoes" class="w3-input w3-border" placeholder="Restrições"><br>
		</div>
		<button class="w3-btn w3-black" id="botao" style="width:100%;margin-botton:10px">Enviar </button>
	</div>
	
	<form method="post" action="recebe_form.php">
	<p id="inside" hidden> Teste</p>
	</form>	
	
	
	</div>
	<!-- Fim script Java Script -->
	
	
<div class="float-sm">
  <div class="fl-fl float-fb aponta">
    <i class="fa fa-cogs" style="font-size:24px;"></i>
    <a id="usoSimplex"> Uso Simplex</a>
  </div>
  <div class="fl-fl float-tw aponta">
    <i class="fa fa-users" style="font-size:24px;"></i>
    <a id="criadores" >Criadores</a>
  </div>
  <div class="fl-fl float-gp aponta">
	<i class="fa fa-linode" style="font-size:24px;"></i>
    <a>Gráfico</a>
  </div>
  <div class="fl-fl float-rs aponta">
    <i class="fa fa-arrows-alt" style="font-size:24px;"></i>
    <a>Programação Linear</a>
  </div>
  <div class="fl-fl float-ig aponta">
	<i class="fa fa-hashtag" style="font-size:24px;"></i>
    <a>Pesquisa Operacional</a>
  </div>
  <div class="fl-fl float-pn aponta">
    <i class="fa fa-university" style="font-size:24px;"></i>
    <a>Fatec</a>
  </div>
</div>

<div id="outras">

<div id="div2" class="divs" style="background-color:blue;">
<img src="img/jader.jpg" class="w3-circle jPhoto" alt="Jader">
<h2 class="emLinha"> Jader Costa </h2>
<h6 class="emLinha"> RA:0040481722008 </h6>
</div><br>

<div id="div1" class="divs" style="background-color:orange;">
<img src="img/maini.jpg" class="w3-circle jPhoto" alt="Jader">
<h2 class="emLinha"> Maini Militão </h2>
<h6 class="emLinha"> RA:---------- </h6>
</div><br>


<div id="div3" class="divs" style="background-color:green;">
<img src="img/andre.jpg" class="w3-circle jPhoto" alt="Jader">
<h3 class="emLinha"> André Nicoletti </h3>
<h6 class="emLinha"> RA:--------- </h6>
</div><br>
<div id="div4" class="divs" style="background-color:red;">
<img src="img/vitor.jpg" class="w3-circle jPhoto" alt="Jader">
<h2 class="emLinha"> Vitor </h2>
<h6 class="emLinha"> RA:---------- </h6>
</div>
</div>


<div class="foot">
 <p class="footP" > Simplex desenvolvido por alunos da Faculdade de Tecnologia de Americana, FATEC - 3 Semestre Vespertino   - Professor Andre de Lima, Programação Linear</p>
</div>

<div id="div5" class="div5">
<h2 style="margin-left:32%;color:white"> Uso método Simplex </h2>
<p style="margin:50px;color:white">
O método Simplex é um processo iterativo que permite melhorar a solução da função objetivo em cada etapa. O processo finaliza quando não é possível continuar melhorando este valor, ou seja, quando se obtenha a solução ótima (o maior ou menor valor possível, segundo o caso, para que todas as restrições sejam satisfeitas).

Com base no valor da função objetivo, em um ponto qualquer, o procedimento consiste em procurar outro ponto que melhore o valor anterior. Como se pode ver no método Gráfico, tais pontos são os vértices do polígono (ou poliedro ou polícoro, se o número de variáveis é maior do que 2) e que faz parte da região determinada pelas restrições a que está sujeito o problema (chamada de região viável). A pesquisa é realizada por meio de deslocamentos pelas arestas do polígono, a partir do vértice atual até um adjacente que melhore o valor da função objetivo. Sempre que exista região viável, e como seu número de vértices e de arestas é finito, será possível encontrar a solução.

O método Simplex baseia-se na seguinte propriedade: se a função objetivo Z não toma seu valor máximo no vértice A, quer dizer que existe uma aresta que parte de A e ao longo da qual o valor de Z aumenta.

Será necessário considerar que o método Simplex trabalha apenas com restrições do problema cujas desigualdades sejam do tipo "≤" (menor ou igual) e seus coeficientes independentes sejam maiores ou iguais a 0. Portanto, é preciso padronizar as restrições para atender aos requisitos antes de iniciar o algoritmo Simplex. Caso apareçam, depois deste processo, restrições do tipo "≥" (maior ou igual) ou "=" (igualdade), ou não seja possível alterá-las, será necessário utilizar outros métodos de resolução, sendo o mais comum, o método das Duas Fases.
</p>
</div><br>

<div class="container">
  <div class="wrap">
    <div class="cube">
      <div class="top"></div>
      <div class="twitter"><a href="#"><i class="fa  jFa" aria-hidden="true" style="font-size:35px;"><h1 style="font-size:35px;margin-left:-30px;margin-top:30px;">Jader</h1> &#xf2b9 </i></a><br></div>
      <div class="linkedin"><a href="#"><i class="fa jFa" aria-hidden="true" style="font-size:25px"><h1 style="font-size:35px;margin-left:-30px;margin-top:30px;">Andre</h1> &#xf2b9;</i></a></div>
      <div class="google-plus"><a href="#"><i class="fa  jFa" aria-hidden="true" style="font-size:35px"><h1 style="font-size:35px;margin-left:-30px;margin-top:30px;">Maini</h1> &#xf2b9;</i></a></div>
      <div class="facebook"><a href="#"><i class="fa  jFa" aria-hidden="true" style="font-size:35px"><h1 style="font-size:35px;margin-left:-30px;margin-top:30px;">Vitor</h1> &#xf2b9;</i></a></div>
      <div class="bottom"></div>
    </div>
  </div>
</div>


	
	
 </body>
 
 <script>
 $(document).ready(function(){
    $("#botao").click(function(){
      var xrec = $("#x").val();
	  var restri = $("#restricoes").val();
		document.getElementById("inside").innerHTML = '';
		document.getElementById("inside").innerHTML += '<label> MAX   -   Z </label>'
	  for(i = 1; i <= xrec; i++){

		document.getElementById("inside").innerHTML += '<input class="w3-input w3-border" placeholder="x'+i+'" style="width:60px; display:inline" type="text" name="x'+i+'">';
		/*
		if( !(i == xrec) ){
		document.getElementById("inside").innerHTML += '(<input type="radio" name="gender" value="0" checked>+<input type="radio" name="gender" value="1">- )';
		}
		*/
	  }

	  document.getElementById("inside").innerHTML += '<label> b = 0 </label>';
	  document.getElementById("inside").innerHTML += '<br><br>';
	  for(j = 1; j <= restri; j++){
		  document.getElementById("inside").innerHTML += '<label> Restrição '+j+' </label>';
	for(i = 1; i <= xrec; i++){		
			document.getElementById("inside").innerHTML += '<input class="w3-input w3-border" style="width:60px; display:inline " placeholder="x'+i+'" type="text" name="restri'+j+''+i+'" >';
	  }
	  
	  document.getElementById("inside").innerHTML += '<input class="w3-input w3-border" style="width:60px; display:inline" placeholder="b" type="text" name="b'+j+'" >';
	  document.getElementById("inside").innerHTML += '<br><br>';
	  }
	  document.getElementById("inside").innerHTML += '<input type="text" name="quantRestri" value="'+restri+'" hidden>';
	  document.getElementById("inside").innerHTML += '<input type="text" name="quantX" value="'+xrec+'" hidden>';
	  document.getElementById("inside").innerHTML += '<br><input class="w3-btn w3-black" type="submit" name="submit" value = "Calcular Simplex" style="width:100%;margin-botton:10px">';
        $("p").toggle();
			
		
		
    });
	
	//--------------------------------- Botoes menu lateral
	
    $("#criadores").click(function(){
        $("#div1").fadeToggle();
        $("#div2").fadeToggle("slow");
        $("#div3").fadeToggle(1000);
		$("#div4").fadeToggle(1000);
    });
	
	$("#usoSimplex").click(function(){
        $("#div5").fadeToggle(1000);
    });
	
	
	
});

 </script>
 
 </html>
 
