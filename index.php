<!DOCTYPE html>
<html>
	<head>
	<meta charset="UTF-8" />
	<title>Proyecto de FOC 1</title>
	</head>
	<body>
		<div align="center">Simplex Revisado</div>
		<?php

			include 'clases/SimplexRevisado.php';
			$problemaOriginal = new SimplexRevisado;

			/*carga simulada de datos
			$objetivo = 'MAX';
			$c = Array(3, 5);
			$x = Array('x1','x2');
			$AI = Array(Array(1, 0), Array(0, 2), Array(3, 2));
			$restricciones = Array('<=', '<=', '<=');
			$b = Array(4, 12, 18);
			$nincognitas = 2;
			$problemaOriginal->setObjetivo($objetivo);
			$problemaOriginal->setC($c);
			$problemaOriginal->setX($x);
			$problemaOriginal->setAI($AI);
			$problemaOriginal->setRestricciones($restricciones);
			$problemaOriginal->setB($b);
			$problemaOriginal->setNIncognitas($nincognitas);
			fin de carga simulada*/
			
			/*carga simulada de datos */
			$objetivo = 'MAX';
			$c = Array(5, 4);
			$x = Array('x1','x2');
			$AI = Array(Array(6, 4), Array(1, 2), Array(-1, 1), Array(0, 1));
			$restricciones = Array('<=', '<=', '<=', '<=');
			$b = Array(24, 6, 1, 2);
			$nincognitas = 2;
			$problemaOriginal->setObjetivo($objetivo);
			$problemaOriginal->setC($c);
			$problemaOriginal->setX($x);
			$problemaOriginal->setAI($AI);
			$problemaOriginal->setRestricciones($restricciones);
			$problemaOriginal->setB($b);
			$problemaOriginal->setNIncognitas($nincognitas);
			/*fin de carga simulada*/


			/*carga simulada de datos ejemplo de kiara 
			$objetivo = 'MAX';
			$c = Array(3, 5);
			$x = Array('x1','x2');
			$AI = Array(Array(1, 0), Array(0, 2), Array(3, 2));
			$restricciones = Array('<=', '<=', '<=');
			$b = Array(4, 12, 18);
			$nincognitas = 2;
			$problemaOriginal->setObjetivo($objetivo);
			$problemaOriginal->setC($c);
			$problemaOriginal->setX($x);
			$problemaOriginal->setAI($AI);
			$problemaOriginal->setRestricciones($restricciones);
			$problemaOriginal->setB($b);
			$problemaOriginal->setNIncognitas($nincognitas);
			/*fin de carga simulada*/

			
			$problemaOriginal->objetivo();
			$problemaOriginal->noNegatividad();
			
			$AI = $problemaOriginal->getAI();
			$restricciones = $problemaOriginal->getRestricciones();
			$b = $problemaOriginal->getB();
			$x = $problemaOriginal->getX();
			$c = $problemaOriginal->getC();
			
			print "<h1>Matriz (A,I) antes de estandarizar el modelo</h1>";
			
			print "funcion objetivo: ";
			for ($i = 0; $i < count($c); $i++)
				print $c[$i]." ";
			
			for ($i = 0; $i < count($b); $i++){
				print "<p>";
				for ($j = 0; $j < $problemaOriginal->getNIncognitas(); $j++){
					print $AI[$i][$j]." ";
				}
				print $restricciones[$i]." ".$b[$i]."</p>";
			}
			print "<p>";
			for ($i = 0; $i < $problemaOriginal->getNIncognitas(); $i++){
				print $x[$i]." ";
			}
			print "</p>";
			
			$problemaOriginal->formaEstandar();
			
			$AI = $problemaOriginal->getAI();
			$restricciones = $problemaOriginal->getRestricciones();
			$b = $problemaOriginal->getB();
			$x = $problemaOriginal->getX();
			$c = $problemaOriginal->getC();
			
			print "<h1>Matriz (A,I) Despues de estandarizar el modelo</h1>";
			
			print "funcion objetivo: ";
			for ($i = 0; $i < count($c); $i++)
				print $c[$i]." ";
				
			for ($i = 0; $i < count($b); $i++){
				print "<p>";
				for ($j = 0; $j < $problemaOriginal->getNIncognitas(); $j++){
					print $AI[$i][$j]." ";
				}
				print $restricciones[$i]." ".$b[$i]."</p>";
			}
			
			print "<p>";
			for ($i = 0; $i < $problemaOriginal->getNIncognitas(); $i++){
				print $x[$i]." ";
			}
			print "</p>";
			
			$problemaOriginal->metodoSimplexRevisado();

			/*

			print "<p> Probando inversa de una matriz. ";
			$matrix0 = array(array(1, 1, 0),	array(1, 0, 1), 	array(0, 1, 0));
			
			$matrixOP->MatrixPrint($matrix0); 
			$inverse = $matrixOP->Cofactor($matrix0, 3);
			$matrixOP->MatrixPrint($inverse);

			print " Salio </p>";
			*/

			/*
				$matrix1 = array(array(2, 1),	array(0, 3), 	array(1, 0));
				$matrix2 = array(array(1, 0, 0),	array(3, 4, 2));
			
				$matrix1 = array(1, 4);
				$matrix2 = array(3, 4);

				print "<h1> Prueba Multiplicacion de Matrices  y Vectores </h1>";
				print "<p>"; 
				// $matrix0 = $matrixOP->MultiMxM($matrix1, $matrix2);
				//$matrixOP->MatrixPrint($matrix0); 

				//$matrix0 = $matrixOP->MultiVxV($matrix1, $matrix2);
				//print $matrix0;
				print "</p>";
			*/
			
		?>
	</body>
</html>
