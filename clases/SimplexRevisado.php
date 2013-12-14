<?php
/*clase del metodo simplex revisado*/
class SimplexRevisado{
	/*vector fila de coeficientes*/
	private $c;
	/*vector columna de variables de desicion*/
	private $x;
	/*matriz de coeficientes tecnologicos del problema*/
	private $A;
	/*vector columna de lados derechos de las restricciones*/
	private $b;
	/*matriz identidad*/
	private $I;
	
	private $prueba;
	
	public function SimplexRevisado($xin, $yin){
		$this->prueba = 'hola';
		
		$this->c = array($xin);
	}
	
	/*metodo de prueba*/
	public function getPrueba(){ 
		return $this->prueba; 
	}
}
?>
