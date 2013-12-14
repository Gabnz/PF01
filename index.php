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
			
			/*entrada de datos arbitraria*/
			
			/*problema de maximizacion o minimizacion*/
			$tipoProblema = 'MAX'; echo $tipoProblema;
			
			/*vector fila de coeficientes*/
			$c = Array('a','b','c');
			
			/*vector columna de variables de decision*/
			$x = Array('1','2','3');
			
			/*matriz de coeficientes tecnologicos del problema*/
			$A = Array(
					Array('Origen', '1'),
					Array('juas', '2'));
					
			/*vector columna de lados derechos de las restricciones*/
			$b = Array('z','x','c');
			
			/*matriz identidad*/
			$I = Array(
					Array('Origen', '1'),
					Array('juas', '2'));
			
			echo $A[0][0]." ".$A[0][1];
		?>
	</body>
</html>
