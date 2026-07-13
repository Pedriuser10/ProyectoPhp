<?php
include "sesion.php";
include "conexion/conexion.php";

$id = $_GET['id'];

$sql = "DELETE FROM autos WHERE id = ?";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

header("Location: index.php?exito=eliminado");
exit();
?>