<?php
include 'MatrixOP.php';
/*clase del metodo simplex revisado*/
class SimplexRevisado{
	/*objetivo del problema, maximizar o minimizar*/
	private $objetivo;
	/*vector fila de coeficientes de la funcion objetivo*/
	private $c;
	/*vector columna de variables de decision del problema (incluyendo v. de holgura, exceso y artificiales)*/
	private $x;
	/*A matriz de coeficientes tecnologicos del problema, I matriz identidad*/
	private $AI;
	/*restricciones de las ecuaciones*/
	private $restricciones;
	/*vector columna de lados derechos de las restricciones*/
	private $b;
	/*numero de incognitas*/
	private $nincognitas;
	
	/*constructor*/
	public function SimplexRevisado(){
		print '<p>instancia de clase creada.</p>';
	}
	
	public function setObjetivo($objetivoin){
		$this->objetivo = $objetivoin;
	}
	
	public function setC($cin){
		$this->c = $cin;
	}
	
	public function setX($xin){
		$this->x = $xin;
	}
	
	public function setAI($AIin){
		$this->AI = $AIin;
	}
	
	public function setRestricciones($restriccionesin){
		$this->restricciones = $restriccionesin;
	}
	
	public function setB($bin){
		$this->b = $bin;
	}
	
	public function setNIncognitas($nincognitasin){
		$this->nincognitas = $nincognitasin;
	}
	
	public function getObjetivo(){
		return $this->objetivo;
	}
	
	public function getC(){
		return $this->c;
	}
	
	public function getX(){
		return $this->x;
	}
	
	public function getAI(){
		return $this->AI;
	}
	
	public function getRestricciones(){
		return $this->restricciones;
	}
	
	public function getB(){
		return $this->b;
	}
	
	public function getNIncognitas(){
		return $this->nincognitas;
	}
	
	/*si el objetivo es minimizar, lo cambia a maximizar con la funcion objetivo
	 * multiplicada por (-1)*/
	public function objetivo(){
		
		if($this->objetivo == 'MIN'){
			
			$n = count($this->c);
			for($i = 0; $i < $n; $i++)
				$this->c[$i] = $this->c[$i]*-1;
		}
	}
	
	/*se asegura que los lados derechos de las restricciones sean no-negativas,
	 * de lo contrario realiza los cambios necesarios para que asi sea.*/
	public function noNegatividad(){
		
		$n = count($this->b);
		for ($i = 0; $i < $n; $i++){
			
			if($this->b[$i] < 0){
				/*si hay una variable independiente negativa, multiplica su ecuacion
				 * por (-1) y cambia la restriccion de desigualdad*/
				for ($j = 0; $j < $this->nincognitas; $j++){
					$this->AI[$i][$j] = $this->AI[$i][$j]*-1;
				}
				if($this->restricciones[$i] == "<=")
					$this->restricciones[$i] = ">=";
				else if($this->restricciones[$i] == ">=")
					$this->restricciones[$i] = "<=";
				/*la variable independiente pasa a ser positiva*/
				$this->b[$i] = $this->b[$i]*-1;
			}
		}
	}
	/*Convierte el modelo a forma estandar, realizando los cambios necesarios*/
	public function formaEstandar(){
		
		$n = count($this->b);
		$variableArtificial = false;
		for($i = 0; $i < $n && !$variableArtificial; $i++){
			/*se determina si alguna ecuacion necesita variable artificial*/
			if($this->restricciones[$i] == ">=" || $this->restricciones[$i] == "=")
				$variableArtificial = true;
		}
		/*si no se necesitan variables artificiales (caso corto donde todas las restricciones son <=)*/
		if(!$variableArtificial){
			for($i = 0; $i < $n; $i++){
				$this->AI[$i][] = 1;
				for($j = 0; $j < $n; $j++){
					if($j!=$i)
						$this->AI[$j][] = 0;
				}
				$this->restricciones[$i] = "=";
				$this->nincognitas++;
				$this->x[] = "x".$this->nincognitas;
				$this->c[] = 0;
			}
		}else{
		/*si se necesitan variables artificiales (caso extenso donde pueden haber restricciones >= o =)*/
			for($i = 0; $i < $n; $i++){
				/*se incluyen las variables de exceso primero*/
				if($this->restricciones[$i] == ">="){
					$this->AI[$i][] = -1;
					for($j = 0; $j < $n; $j++){
						if($j!=$i)
							$this->AI[$j][] = 0;
					}
					$this->nincognitas++;
					$this->x[] = "x".$this->nincognitas;
					$this->c[] = 0;
				}
			}
			
			$nartificiales = 0;
			for($i = 0; $i < $n; $i++){
				/*se incluyen luego las variables de holgura y artificiales de manera
				 * que quede la matriz identidad con la combinacion de estas*/
				if($this->restricciones[$i] == "<="){
					$this->AI[$i][] = 1;
					for($j = 0; $j < $n; $j++){
						if($j!=$i)
							$this->AI[$j][] = 0;
					}
					$this->nincognitas++;
					$this->x[] = "x".$this->nincognitas;
					$this->c[] = 0;
				}
				
				if($this->restricciones[$i] == "=" || $this->restricciones[$i] == ">="){
					$this->AI[$i][] = 1;
					for($j = 0; $j < $n; $j++){
						if($j!=$i)
							$this->AI[$j][] = 0;
					}
					$this->nincognitas++;
					$nartificiales++;
					$this->x[] = "a".$nartificiales;
					$this->c[] = 1;
				}
				$this->restricciones[$i] = "=";
			}
		}
	}
	/*retorna si hay variables artificiales en el modelo estandar*/
	public function existenArtificiales(){
		
		$n = $this->nincognitas;
		
		for ($i = 0; $i < $n; $i++){
			
			if($this->x[$i][0] == "a")
				return true;
		}
		return false;
	}
	
	public function metodoSimplexRevisado(){
		
		$matrixOP = new MatrixOP;
		/*Paso 0. $B tiene la matriz identidad y $Cb tiene ceros.*/
		$n = count($this->AI);
		$nnobasicas = $this->nincognitas - $n;
		$esOptima = true;
		$detenerse = false;
		for($i = 0; $i < $n; $i++){
			$Cb[$i] = 0;
			for($j = 0; $j < $n; $j++){
				if($i != $j)
					$B[$i][$j] = 0;
				else
					$B[$i][$j] = 1;
			}
		}
		
		print "<h4>Paso 0</h4>";
		print "<p>Funcion objetivo</p>";
		$matrixOP->VectorPrint($this->c);
		print "<p>V. de decision</p>";
		$matrixOP->VectorPrint($this->x);
		print "<p>Matriz actual</p>";
		$matrixOP->MatrixPrint($B);
		print "<p>Lado derecho</p>";
		$matrixOP->VectorPrint($this->b);
		$iteracion = 0;

		
		while(!$detenerse){
			$esOptima = true;
			print "<h1>Iteracion ".$iteracion."</h1>";
			/*Paso 1. Se calcula B^(-1)*/
			$B_1 = $matrixOP->Cofactor($B, $n);
			print "<h4>Paso 1</h4>";
			print "<p>Matriz invertida B^-1</p>";
			$matrixOP->MatrixPrint($B_1);
			print "<p>Solucion Cb</p>";
			$matrixOP->VectorPrint($Cb);
			
			print "<p>Xb = (B^-1)*b = </p>";
			//ERROR, b DEBE ACTUALIZARSE AL MOMENTO DE INVERTIR LA MATRIZ
			//$auxb = $matrixOP->MultiMxV($B_1,$this->b);
			//$this->b = $auxb;
			print "<p>------------------------------------</p>";
			/*Paso 2.*/
			for($j = 0; $j < $nnobasicas; $j++){
				//ERROR DE MULTIPLICACION
				$aux = $matrixOP->MultiVxM($B_1, $Cb);
				$print_aux = $aux;
				//HASTA AQUI TODO "BIEN"
				for ($k = 0; $k < $n; $k++)
					$Pj[$k] = $this->AI[$k][$j];
				print '</p>';
				
				$aux = $matrixOP->MultiVxV($aux, $Pj);
				$z_c[$j] = $aux - $this->c[$j];
				
				if($z_c[$j] < 0)
					$esOptima = false;
				
				//$this->c[$j] = $z_c[$j];
			}
			
			print "<h4>Paso 2</h4>";
			print "<p>(B^-1)*Cb</p>";
			$matrixOP->VectorPrint($print_aux);
			print "<p>------------------------------------</p>";
			print "<p>computo de optimalidad</p>";
			$matrixOP->VectorPrint($z_c);
			
			if($esOptima){
				print "listo, llegaste.";

				print "<p> valor optimo de las variables X</p>";

				$z = $matrixOP->MultiMxV($B_1,$this->b);
				$matrixOP->VectorPrint($z);

				$z_result = $matrixOP->MultiVxV($z,$Cb);
				print "<p> valor de z </p>";
				print $z_result;
				print "<p> bueno chao </p>";

				$detenerse = true;
			}else{
				
				/*se elige la variable entrante*/
				$ventrante = 0;
				
				for($j = 0; $j < $nnobasicas; $j++){
					if($z_c[$j] < $z_c[$ventrante])
						$ventrante = $j;
				}
				print "<p>variable entrante: ".$this->x[$ventrante]."</p>";
				
				/*paso 3*/
				print "<h4>Paso 3</h4>";
				for ($j = 0; $j < $n; $j++)
					$Pj[$j] = $this->AI[$j][$ventrante];
				
				print "<p>vector columna entrante</p>";
				$matrixOP->VectorPrint($Pj);
				print "<p>Matriz B_1</p>";
				$matrixOP->MatrixPrint($B_1);
				
				$aux = $matrixOP->MultiMxV($B_1, $Pj);
				
				print "<p>(B^-1)*Pj</p>";
				$matrixOP->VectorPrint($aux);
				
				$solucionAcotada = false;
				for ($j = 0; $j < $n && !$solucionAcotada; $j++){
					
					if($aux[$j] > 0)
						$solucionAcotada = true;
				}
				
				/*si no hay solucion acotada, detenerse.*/
				if(!$solucionAcotada){
					print "no hay solucion acotada.";
					$detenerse = true;
				}else{
					$aux2 = $matrixOP->MultiMxV($B_1,$this->b);
					
					for ($j = 0; $j < $n; $j++){
						
						if($aux[$j] == 0)
							$razon[$j] = "indeterminado";
						else if($aux[$j] < 0 || $aux2[$j] < 0)
							$razon[$j] = "negativo";
						else{
							$vsaliente = $j;
							$razon[$j] = $aux2[$j]/$aux[$j];
						}
					}
	
					
					print "<p>razon</p>";
					$matrixOP->VectorPrint($razon);
					for($j = 0; $j < $n; $j++){
						
						if($razon[$j] != "indeterminado" && $razon[$j] != "negativo" && $razon[$j] < $razon[$vsaliente])
							$vsaliente = $j;
					}
					print "<h4>Paso 4</h4>";
					print "<p>variable saliente: ".$this->x[$nnobasicas + $vsaliente]."</p>";


					for ($j = 0; $j < $n; $j++){
						$intercambio = $B[$j][$vsaliente];
						$B[$j][$vsaliente] = $this->AI[$j][$ventrante];
						$this->AI[$j][$ventrante] = $intercambio;
					}	

					$Cb[$vsaliente] = $this->c[$ventrante];

					$intercambio = $this->c[$nnobasicas + $vsaliente];
					$this->c[$nnobasicas + $vsaliente] = $this->c[$ventrante];
					$this->c[$ventrante] = $intercambio;

					print "<p>nueva matriz B</p>";
					$matrixOP->MatrixPrint($B);				
				}
			}
			$iteracion++;
		}
	}
	
	public function metodoDosFases(){
		
		print "<p>veo que quieres ejecutar el metodo de las dos fases. seria una lastima si...</p>";
	}
}
?>
