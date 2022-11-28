<?php
//datos del servidor
$server		="localhost";
$username	="root";
$password	="";
$inmuebless			="inmuebless";

//creamos una conexión
$conn = mysqli_connect($server, $username, $password, $inmuebless);

//Chequeamos la conexión
if(!$conn){
	die("Conexión fallida:" . mysqli_connect_error());
}

//Chequeamos la conexión
if(!$conn){
	die("Conexión fallida:" . mysqli_connect_error());
}
?>