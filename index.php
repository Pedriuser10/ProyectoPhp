<?php
include "sesion.php";
include "conexion/conexion.php";

$sql = "SELECT * FROM autos";
$resultado = mysqli_query($conexion, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Concesionario - Administración de Autos</title>
    <link rel="stylesheet" href="css/estilos.css">
    <script src="js/script.js"></script>
</head>
<body>
    <div class="contenedor">
        <nav class="menu-nav">
            <a href="index.php">Inicio</a>
            <a href="agregar.php">Agregar Auto</a>
            <a href="logout.php">Cerrar Sesión</a>
        </nav>

        <h1>Administración de Autos</h1>
        <p>Bienvenido, <?php echo $_SESSION['usuario_nombre']; ?></p>

        <?php if (isset($_GET['exito'])) {
            $mensajes = [
                'agregado' => 'Auto agregado correctamente ✅',
                'editado' => 'Auto actualizado correctamente ✅',
                'eliminado' => 'Auto eliminado correctamente ✅'
            ];
            if (isset($mensajes[$_GET['exito']])) {
                echo '<p class="mensaje-exito">' . $mensajes[$_GET['exito']] . '</p>';
            }
        } ?>

        <input type="text" id="buscador" onkeyup="filtrarAutos()" placeholder="Buscar auto...">
        <a href="agregar.php" class="btn btn-agregar">+ Agregar Auto</a>

        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Foto</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Precio</th>
                <th>Color</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
                <td data-label="ID"><?php echo $fila['id']; ?></td>
                <td data-label="Foto">
                    <?php if (!empty($fila['imagen'])) { ?>
                        <img src="img/<?php echo $fila['imagen']; ?>" width="80">
                    <?php } else { ?>
                        Sin foto
                    <?php } ?>
                </td>
                <td data-label="Marca"><?php echo $fila['marca']; ?></td>
                <td data-label="Modelo"><?php echo $fila['modelo']; ?></td>
                <td data-label="Año"><?php echo $fila['anio']; ?></td>
                <td data-label="Precio">$<?php echo number_format($fila['precio'], 0, ',', '.'); ?></td>
                <td data-label="Color"><?php echo $fila['color']; ?></td>
                <td data-label="Stock"><?php echo $fila['stock']; ?></td>
                <td data-label="Acciones">
                    <a href="editar.php?id=<?php echo $fila['id']; ?>" class="btn btn-editar">Editar</a>
                    <a href="eliminar.php?id=<?php echo $fila['id']; ?>" class="btn btn-eliminar" onclick="return confirmarEliminar()">Eliminar</a>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>