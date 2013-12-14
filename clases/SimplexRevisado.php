<?php
/*clase del metodo simplex revisado*/
class SimplexRevisado{
	/*vector fila de coeficientes*/
	private $c;
	/*vector columna de variables de decision*/
	private $x;
	/*matriz de coeficientes tecnologicos del problema*/
	private $A;
	/*vector columna de lados derechos de las restricciones*/
	private $b;
	/*matriz identidad*/
	private $I;
	
	/*constructor*/
	public function SimplexRevisado(){
		//print 'hola';
	}
	
	public function setC($cin){
		
		$this->c = $cin;
	}
	
	public function formaEstandar(){
		
		return true;
	}
	
	public function dosFases(){
		
	}
}
?>
