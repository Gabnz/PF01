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
					//$this->nincognitas++;
					$nartificiales++;
					$this->x[] = "a".$nartificiales;
					$this->c[] = 1;
				}

				$this->restricciones[$i] = "=";
			}
			$this->nincognitas = $this->nincognitas + $nartificiales;
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
		$iteracion = 0;

		while(!$detenerse){
			
			$esOptima = true;
			/*Paso 1. Se calcula B^(-1)*/
			$B_1 = $matrixOP->Cofactor($B, $n);

			/*Paso 2.*/
			for($j = 0; $j < $nnobasicas; $j++){
				$aux = $matrixOP->MultiVxM($B_1, $Cb);
				for ($k = 0; $k < $n; $k++)
					$Pj[$k] = $this->AI[$k][$j];
				
				$aux = $matrixOP->MultiVxV($aux, $Pj);
				$z_c[$j] = $aux - $this->c[$j];
				
				/*evaluacion de condicion de parada de maximizacion y minimizacion*/
				if(($this->objetivo == "MAX" && $z_c[$j] < 0)
				|| ($this->objetivo == "MIN" && $z_c[$j] > 0))
					$esOptima = false;
			}
			
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
					
					if(($this->objetivo == "MAX" && $z_c[$j] < $z_c[$ventrante])
					|| ($this->objetivo == "MIN" && $z_c[$j] > $z_c[$ventrante]))
						$ventrante = $j;
				}
				
				/*paso 3*/
				for ($j = 0; $j < $n; $j++)
					$Pj[$j] = $this->AI[$j][$ventrante];
				
				$aux = $matrixOP->MultiMxV($B_1, $Pj);
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
							$razon[$j] = "-";
						else if($aux[$j] < 0 || $aux2[$j] < 0)
							$razon[$j] = "-";
						else{
							$vsaliente = $j;
							$razon[$j] = $aux2[$j]/$aux[$j];
						}
					}
					
					for($j = 0; $j < $n; $j++){
						
						if($razon[$j] != "-" && $razon[$j] < $razon[$vsaliente])
							$vsaliente = $j;
					}
					
					for ($j = 0; $j < $n; $j++){
						$intercambio = $B[$j][$vsaliente];
						$B[$j][$vsaliente] = $this->AI[$j][$ventrante];
						$this->AI[$j][$ventrante] = $intercambio;
					}
					
					$Cb[$vsaliente] = $this->c[$ventrante];
					
					$intercambio = $this->c[$nnobasicas + $vsaliente];
					$this->c[$nnobasicas + $vsaliente] = $this->c[$ventrante];
					$this->c[$ventrante] = $intercambio;
				}
			}
			$iteracion++;
		}
	}
	
	public function metodoDosFases(){
		
		/*fase 1*/
		$nartificiales=0;
		$n = count($this->x);
		$nnobasicas = $this->nincognitas - count($this->b);
		for ($i=0; $i < $n; $i++) {
			if ($this->x[$i][0] == "a") {
				$nartificiales++;
				$iartifiaciales[] = $i;
				$ecartifiaciales[] = $i - $nnobasicas;
			}
		}

		for($i=0; $i < $nartificiales; $i++){

			$nfilas = 0;
			for($j=0; $j < $this->nincognitas; $j++){

				if($j != $iartifiaciales[$i]){
					$filas[$i][$nfilas] = $this->AI[$ecartifiaciales[$i]][$j]*-1;
					$nfilas++;
				}
			}
			$filas[$i][$nfilas] = $this->b[$i];
		}

		$ncolumnas = count($filas[0]);

		for($i=0; $i < $nartificiales; $i++){

			for($j=0; $j < $ncolumnas; $j++){ 
				$resultado[$j]+=$filas[$i][$j];
			}
		}

		$matrixOP = new MatrixOP;
		print "<p>Ecuacion resultante</p>";
		$matrixOP->VectorPrint($resultado);

		for ($i=0; $i < $ncolumnas; $i++) { 
			$z[$i] = $resultado[$i] * -1;
		}
		$z[$i - 1] = $resultado[$i - 1];

		print "<p> Vector z </p>";
		$matrixOP->VectorPrint($z);



		print "<p> Matriz AI </p>";
		$matrixOP->MatrixPrint($this->AI);

		
		print "<p>veo que quieres ejecutar el metodo de las dos fases. seria una lastima si...</p>";
	}
}
?>
