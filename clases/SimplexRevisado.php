<?php
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
			else
				$variableArtificial = false;
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
				}
				$this->restricciones[$i] = "=";
			}
		}
	}
	
	public function dosFases(){
		
	}
}
?>
