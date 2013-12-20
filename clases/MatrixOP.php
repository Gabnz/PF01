<?php
/**/
class MatrixOP{
	
	
	/*constructor*/
	public function MatrixOP(){
		print '<p>instancia de clase creada. MatrixOP </p>';
	}

	/* comentarios */
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


	/* comentarios */
	public static function MultiVxM($m, $v){

	    if (($length = count($m)) != count($v)) {
	          throw new \Exception('Vector and Matrix mismatch');
	    }

       	for ($i = 0; $i < $length; ++$i) {
       		for ($j=0; $j < $length; $j++) { 
       			$product[$i] += $m[$j][$i] * $v[$i];
       		}
       	}
        return $product;
	}

	/* comentarios */
	public static function MultiMxV($m, $v){

	    if (($length = count($m)) != count($v)) {
	          throw new \Exception('Vector and Matrix mismatch');
	    }

       	for ($i = 0; $i < $length; ++$i) {
       		for ($j=0; $j < $length; $j++) { 
       			$product[$i] += $m[$i][$j] * $v[$i];
       		}
       	}
        return $product;
	}	

	/* comentarios */
	public static function MultiVxV($a, $b){

	    if (($length = count($a)) != count($b)) {
	          throw new \Exception('Vector mismatch');
	    }

       	$product = 0;
       	for ($i = 0; $i < $length; ++$i) {
            $product += $a[$i] * $b[$i];
       	}
        return $product;
	}	


	/* comentarios */
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
	
	public function VectorPrint($a){
		
		$n = count($a);
		print	"<table border='1'>
					<tr>";
		for($i = 0; $i < $n; $i++){
			print "<td>".$a[$i]."</td>";
		}
		print	"	</tr>
				</table>";
	}


/*For calculating Determinant of the Matrix */
	public function  Determinant($a, $k){
		
		$s = 1; $det = 0;
		 if ($k == 1){
		    return ($a[0][0]);
		 }
		 else{
		    $det=0;
		    for ($c = 0; $c < $k ; $c++){
		      	$m=0;
		        $n=0;
		        for ($i=0 ; $i < $k; $i++){
		            for ( $j=0; $j < $k; $j++){
		                $b[$i][$j]=0;
		                if ($i != 0 && $j != $c){
		                   $b[$m][$n] = $a[$i][$j];
		                   if ($n < ($k-2))
		                    	$n++;
		                   else{
		                     $n=0;
		                     $m++;
		                   }
		                }
		             }
		        }
		          $det = $det + $s * ($a[0][$c] * $this->Determinant($b, ($k-1)));

		          $s=-1 * $s;
		    }
		}
	 
	    return $det;
	}


	public function  Cofactor($num, $f){

		for ($q=0; $q < $f; $q++){

		   for ($p=0; $p < $f ;$p++){

		     $m=0;
		     $n=0;
		     
		     for ($i=0; $i < $f; $i++){

		       for ($j=0; $j < $f; $j++){

		          if ($i != $q && $j != $p){

		            $b[$m][$n] = $num[$i][$j];
		            if ($n < ($f-2))
		             $n++;
		            else
		            {
		               $n=0;
		               $m++;
		               }
		            }
		        }
		      }
		      $fac[$q][$p]=pow(-1,$q + $p) * $this->Determinant($b,$f-1);
		    }
		}

		return $this->Transpose($num,$fac,$f);
	}


	/*Finding transpose of matrix*/ 
	public function Transpose($num, $fac, $r){
	  
	  	for ($i=0; $i < $r; $i++){

	    	 for ($j=0; $j < $r; $j++){
	         	$b[$i][$j]=$fac[$j][$i];
	        }
	    }

	  	$d = $this->Determinant($num, $r);
	  	for ($i=0; $i < $r; $i++){

	     	for ($j=0; $j < $r; $j++){
	        	$result[$i][$j]= $b[$i][$j] / $d;
	        }
	    }

		return $result;
	}


}
?>	
