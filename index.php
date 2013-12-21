<?php
include 'header.php';
session_start();
include 'clases/SimplexRevisado.php';
?>

<?php
	$problemaOriginal = new SimplexRevisado;
	
	/*carga simulada de datos*/
	$objetivo = 'MAX';
	$_SESSION['objetivo'] = $objetivo;
	$c = Array(5, 4);
	$_SESSION['c'] = $c;
	$x = Array('x1','x2');
	$_SESSION['x'] = $x;
	$AI = Array(Array(6, 4), Array(1, 2), Array(-1, 1), Array(0, 1));
	$_SESSION['AI'] = $AI;
	$restricciones = Array('<=', '<=', '<=', '<=');
	$_SESSION['restricciones'] = $restricciones;
	$b = Array(24, 6, 1, 2);
	$_SESSION['b'] = $b;
	$nincognitas = 2;
	$problemaOriginal->setObjetivo($objetivo);
	$problemaOriginal->setC($c);
	$problemaOriginal->setX($x);
	$problemaOriginal->setAI($AI);
	$problemaOriginal->setRestricciones($restricciones);
	$problemaOriginal->setB($b);
	$problemaOriginal->setNIncognitas($nincognitas);
	/*fin de carga simulada*/
	
	/*Transformacion del modelo a su forma estandar*/
	/*Primero verifica ellado derecho de las restricciones para asegurarse de tenerlos
	 * todos positivos*/
	$problemaOriginal->noNegatividad();
	/*Se pasa el modelo a su forma estandar*/
	$problemaOriginal->formaEstandar();
	
	$c = $problemaOriginal->getC();
	$_SESSION['cEstandar'] = $c;
	$x = $problemaOriginal->getX();
	$_SESSION['xEstandar'] = $x;
	$AI = $problemaOriginal->getAI();
	$_SESSION['AIEstandar'] = $AI;
	$restricciones = $problemaOriginal->getRestricciones();
	$_SESSION['restriccionesEstandar'] = $restricciones;
	$b = $problemaOriginal->getB();
	$_SESSION['bEstandar'] = $b;
	
	if(!$problemaOriginal->existenArtificiales())
		$problemaOriginal->metodoSimplexRevisado($objetivo);
	else{
		print "<div align='center' style='background-color:#FF5123; width:30%;'><h3>Metodo de las 2 fases incompleto</h3></div>";
	}
	
	$_SESSION['z'] = $problemaOriginal->getZ();
	$AI = $problemaOriginal->getAI();
	$_SESSION['AIOptima'] = $AI;
	$b = $problemaOriginal->getB();
	$_SESSION['bOptima'] = $b;
?>

<div align="center" style="margin:10%; background-color:#FF5123;"><p style="font-size:20px;">Por problemas sin posibilidad de resolver antes de la entrega, la entrada solo se
realizara directamente desde el codigo y de alli se ejecutaran los algoritmos para la resolucion del problema.</p></div>

<div align="center"><a href="resultado.php" class="boton">Procesar</a></div>

<?php include 'footer.php' ?>


