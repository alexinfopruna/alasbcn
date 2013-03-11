<?php
require_once('../Connections/alasdb.php'); 
$fitxa="WAKSM";
//$fitxa="F0104";

// CARREGA LES DADES DE LA FITXA        
  	$query_menu = "SELECT * FROM apartats2013 WHERE apartat='$fitxa'";
	$rs = mysql_query($query_menu, $alas);
    if ($row = mysql_fetch_assoc($rs))	$contingut=$row['text_cs'];
	else $contingut="Andrés waksman";
	print_r($row);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html40/loose.dtd">

<html>
  <head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="author" content="Alex Garcia">
    <meta name="description" content="Andrés Waksman: Agenda de actividades, cursos y formación">
    <meta name="keywords" content="2011, 2012, agosto, alas, alasbcn, alemania, antic, arte, artistica, atres, aula, autntico, autntico, azul, balear, barcelona, com, creacin, creacin, cuerpo, danza, de, del, dusseldorf, en, eneagrama, espaa, estreno, formación, formacion, gestalt, grupo, hombres, inglaterra, julio, junio, la, mallorca, mayo, montevideo, moviemento, movimiento, muniz, noviembre, octubre, palma, performance, petrleo, postgrado, programa, quincenal, regular, sala, sat, septiembre, solis, teatre, teatro, workshops, www, zavala">

<!-- 2011, 2012, agosto, alas, alasbcn, alemania, antic, arte, artistica, atres, -->

<!-- aula, autntico, autntico, azul, balear, barcelona, com, creacin, creacin, -->

<!-- cuerpo, danza, de, del, dusseldorf, en, eneagrama, espaa, estreno, formacin, -->

<!-- formacin, gestalt, grupo, hombres, inglaterra, julio, junio, la, mallorca, -->

<!-- mayo, montevideo, moviemento, movimiento, muniz, noviembre, octubre, palma, -->

<!-- performance, petrleo, postgrado, programa, quincenal, regular, sala, sat, -->

<!-- septiembre, solis, teatre, teatro, workshops, www, zavala -->

    <!-- Created by SWiSH Max - Flash Made Easy - www.swishzone.com -->

	<style>
		body
		{
			background:#BEAE7A;
			font-family: 'Times New Roman', Times, serif;
			margin-bottom:0;
		}
		
		div.marge
		{
			padding:4px 20px;
		}
		
		a{text-decoration:none;color:#444;font-weight:bold;}
		a:hover{text-decoration:underline;}
		
		
		#container
		{
			width:985px;
			margin:0 auto;
			background:white;
			padding:0px;
			/*height:100%*/

		}
		
		#capsalera
		{
			height:85px;
			border-bottom:#C7B98B solid 3px;
			text-align:right;
			padding-right:95px;
			padding-top:40px;
		}
		#capsalera_top
		{
			font-size:22px;
			letter-spacing:5px;
		}
		#capsalera_bottom
		{
			/*height:100px;*/
			font-size:12px;
			margin-top:12px;
		}
		
		#cos
		{
			padding-top:20px;
			padding-bottom:15px;
		}
		
		#area_text
		{
			float:right;
			background:red;
			width:470px;
			height:297px;
			overflow:none;
			overflow-x:none;
			overflow-y:auto;
		
		}
		
		#img_waksman
		{
			width:447px;
			height:297px;
			/*float:left;*/
		}
		
		#peu
		{
			clear:both;
			height:120px;
			font-size:14px;
		}
		#franja_peu
		{
			background:#C7B98B;
			color:white;
		
		}
		
		
		.sep1
		{
			margin:0 10px;
			min-witdh:20px;
		}
		
	</style>
	
	
  </head>

  <body>

	<div id="container">
		<div id="capsalera" class="marge">
			<div id="capsalera_top">
				ANDR&Eacute;S WAKSMAN
			</div>
			<div id="capsalera_bottom">
				WORKSHOPS <span class="sep1">|</span> FORMACION <span class="sep1">|</span> CREACION ARTISTICA
			</div>
		</div>
		<div id="cos" class="marge">
			<img id="img_waksman" src="img/waksman.jpg"/>
			
			<div id="area_text">
				<?php
					print $contingut;
				?>
			</div>
			
			
		</div>
		<div id="peu">
			<div id="franja_peu" class="marge">
				ALAS artes en movimiento <span class="sep1"></span> <a href="http://www.alasbcn.com">www.alasbcn.com</a>
			</div>
			
		</div>
	</div>
  

  </body>

</html>
