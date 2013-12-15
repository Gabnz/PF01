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
			
			/*carga simulada de datos*/
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
			
			
		?>
	</body>
</html>
