<?php
/**/
class MatrixOP{
	
	
	/*constructor*/
	public function MatrixOP(){
		print '<p>instancia de clase creada. MatrixOP </p>';
	}

	public function MUltiMxM($a, $b){
		
		$filasA = count($a);
		$columnasA = count($a[0]);
		$filasB = count($b);
		$columnasB = count($b[0]);

		if ( $columnasA  != $filasB ) {
            throw new \Exception('Matrix mismatch');
        }
        else{

			for($i = 0; $i < $filasA; $i++) {
		        for($j = 0; $j < $columnasB; $j++) {
		            $ab[$i][$j] = 0;
	    	        for($k = 0; $k < $columnasA; $k++) {
	        	        $ab[$i][$j] += $a[$i][$k] * $b[$k][$j];
	            	}
	        	}
    		}
		}

		return $ab;
	}	
	

	public function MatrixPrint($a){
		
		$filasA = count($a);
		$columnasA = count($a[0]);

		print '<table border="1">';
    	for($i = 0; $i < $filasA; $i++) {
        	print '<tr>';
        	for($j = 0; $j < $columnasA; $j++) {
            	print '<td>' . $a[$i][$j] . '</td>';
        	}
        	print '</tr>';
    	}
		print '</table>';
	}

}
?>	