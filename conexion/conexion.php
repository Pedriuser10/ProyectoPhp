<?php
$host = "localhost";
$usuario = "root";
$password = "";
$basedatos = "concesionario";

$conexion = mysqli_connect($host, $usuario, $password, $basedatos);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>