<?php
include 'header.php';
session_start();
include 'clases/SimplexRevisado.php';
?>

<div align="center">
	<h2>Resultados</h2>
</div>

<?php
//recoleccion de datos a mostrar
$objetivo = $_SESSION['objetivo'];
$c = $_SESSION['c'];
$x = $_SESSION['x'];
$AI = $_SESSION['AI'];
$restricciones = $_SESSION['restricciones'];
$b = $_SESSION['b'];
?>

<?php
print "<div><h3 style='margin-left:2%;'>Modelo original</h3></div>";

print "<div><p style='margin-left:2%;'>";

if($objetivo == "MAX"){
	print "Maximizar";
}else{
	print "Minimizar";
}

print " Z = ";

for ($i = 0; $i < count($c); $i++){
	if($i != 0){
		if($c[$i] >= 0)
			print "+";
	}
	print $c[$i]."".$x[$i]." ";
}

print "</p></div>";

print "<div><p style='margin-left:2%;'>Sujeato a:</p></div>";

print "<table border='1' style='margin-left:2%;'>";

for($i = 0; $i < count($AI); $i++){
	print '<tr>';
	for($j = 0; $j < count($AI[0]); $j++){
		print '<td>';
		if($j != 0){
			if($AI[$i][$j] >= 0)
			print "+";
		}
		print $AI[$i][$j]."".$x[$j]." ";
		print '</td>';
	}
	print "<td>".$restricciones[$i]."</td>";
	print "<td>".$b[$i]."</td>";
	print '</tr>';
}
print '</table>';

print "<div><p style='margin-left:2%;'>";

for($i = 0; $i < count($x); $i++){
	
	if($i!=0)
		print ",";
	
	print $x[$i]." ";
}
print ">= 0</p></div>";
?>

<?php
//recoleccion de datos a mostrar
$objetivo = $_SESSION['objetivo'];
$c = $_SESSION['cEstandar'];
$x = $_SESSION['xEstandar'];
$AI = $_SESSION['AIEstandar'];
$restricciones = $_SESSION['restriccionesEstandar'];
$b = $_SESSION['bEstandar'];
?>

<?php
print "<div><h3 style='margin-left:2%;'>Modelo en su forma estandar</h3></div>";

print "<div><p style='margin-left:2%;'>";

if($objetivo == "MAX"){
	print "Maximizar";
}else{
	print "Minimizar";
}

print " Z = ";

for ($i = 0; $i < count($c); $i++){
	if($i != 0){
		if($c[$i] >= 0)
			print "+";
	}
	print $c[$i]."".$x[$i]." ";
}

print "</p></div>";

print "<div><p style='margin-left:2%;'>Sujeato a:</p></div>";

print "<table border='1' style='margin-left:2%;'>";

for($i = 0; $i < count($AI); $i++){
	print '<tr>';
	for($j = 0; $j < count($AI[0]); $j++){
		print '<td>';
		if($j != 0){
			if($AI[$i][$j] >= 0)
			print "+";
		}
		print $AI[$i][$j]."".$x[$j]." ";
		print '</td>';
	}
	print "<td>".$restricciones[$i]."</td>";
	print "<td>".$b[$i]."</td>";
	print '</tr>';
}
print '</table>';

print "<div><p style='margin-left:2%;'>";

for($i = 0; $i < count($x); $i++){
	
	if($i!=0)
		print ",";
	
	print $x[$i]." ";
}
print ">= 0</p></div>";
?>

<?php
$z = $_SESSION['z'];
print "<div><h3 style='margin-left:2%;'>Valor de Z optimo</h3></div>";

print "<div style='margin-left:2%;'><p>".$z."</p></div>";

?>

<?php
$AI = $_SESSION['AIOptima'];
$b = $_SESSION['bOptima'];
print "<div><h3 style='margin-left:2%;'>Tabla optima</h3></div>";

print "<table border='1' style='margin-left:2%;'>";

for($i = 0; $i < count($AI); $i++){
	print '<tr>';
	for($j = 0; $j < count($AI[0]); $j++){
		print '<td>';
		if($j != 0){
			if($AI[$i][$j] >= 0)
			print "+";
		}
		print $AI[$i][$j]."".$x[$j]." ";
		print '</td>';
	}
	print "<td>".$restricciones[$i]."</td>";
	print "<td>".$b[$i]."</td>";
	print '</tr>';
}
print '</table>';

?>

<div align="center"><a href="index.php" class="boton">Regresar</a></div>

<?php include 'footer.php' ?>
