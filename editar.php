<?php
include "sesion.php";
include "conexion/conexion.php";

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $anio = $_POST['anio'];
    $precio = $_POST['precio'];
    $color = $_POST['color'];
    $stock = $_POST['stock'];

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $nombreImagen = uniqid() . "_" . basename($_FILES['imagen']['name']);
        move_uploaded_file($_FILES['imagen']['tmp_name'], "img/" . $nombreImagen);

        $sql = "UPDATE autos SET marca=?, modelo=?, anio=?, precio=?, color=?, stock=?, imagen=? WHERE id=?";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ssidsisi", $marca, $modelo, $anio, $precio, $color, $stock, $nombreImagen, $id);
    } else {
        $sql = "UPDATE autos SET marca=?, modelo=?, anio=?, precio=?, color=?, stock=? WHERE id=?";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ssidsii", $marca, $modelo, $anio, $precio, $color, $stock, $id);
    }
    mysqli_stmt_execute($stmt);

    header("Location: index.php?exito=editado");
    exit();
}

$sql = "SELECT * FROM autos WHERE id = ?";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$auto = mysqli_fetch_assoc($resultado);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Auto</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="contenedor">
        <nav class="menu-nav">
            <a href="index.php">Inicio</a>
            <a href="agregar.php">Agregar Auto</a>
            <a href="logout.php">Cerrar Sesión</a>
        </nav>

        <h1>Editar Auto</h1>
        <form method="POST" enctype="multipart/form-data" onsubmit="return validarFormulario()">
            <label>Marca:</label>
            <select id="marca_select" name="marca" required onchange="mostrarCampoOtro('marca_select', 'marca_otro')">
                <option value="">-- Selecciona marca --</option>
                <?php
                $marcas = ["Toyota", "Chevrolet", "Nissan", "Hyundai", "Kia", "Suzuki", "Mazda", "Volkswagen", "Ford", "Chery"];
                foreach ($marcas as $m) {
                    $sel = ($m == $auto['marca']) ? "selected" : "";
                    echo "<option value=\"$m\" $sel>$m</option>";
                }
                ?>
                <option value="otro">Otra (escribir)</option>
            </select>
            <input type="text" id="marca_otro" placeholder="Escribe la marca" style="display:none;">

            <label>Modelo:</label>
            <select id="modelo_select" name="modelo" required onchange="mostrarCampoOtro('modelo_select', 'modelo_otro')">
                <option value="">-- Selecciona modelo --</option>
                <?php
                $modelos = ["Corolla", "Sail", "Versa", "Accent", "Rio", "Swift", "Mazda3", "Gol", "Fiesta", "Tiggo"];
                foreach ($modelos as $mo) {
                    $sel = ($mo == $auto['modelo']) ? "selected" : "";
                    echo "<option value=\"$mo\" $sel>$mo</option>";
                }
                ?>
                <option value="otro">Otro (escribir)</option>
            </select>
            <input type="text" id="modelo_otro" placeholder="Escribe el modelo" style="display:none;">

            <label>Año:</label>
            <select name="anio" required>
                <option value="">-- Selecciona año --</option>
                <?php for ($y = 2026; $y >= 2015; $y--) {
                    $sel = ($y == $auto['anio']) ? "selected" : "";
                    echo "<option value=\"$y\" $sel>$y</option>";
                } ?>
            </select>

            <label>Precio:</label>
            <input type="text" name="precio" inputmode="numeric" value="<?php echo number_format($auto['precio'], 0, ',', '.'); ?>" oninput="formatearPrecio(this)" required>

            <label>Color:</label>
            <input type="text" name="color" value="<?php echo $auto['color']; ?>" required>

            <label>Stock:</label>
            <input type="number" name="stock" value="<?php echo $auto['stock']; ?>" required>

            <label>Foto actual:</label>
            <?php if (!empty($auto['imagen'])) { ?>
                <img src="img/<?php echo $auto['imagen']; ?>" width="100"><br>
            <?php } else { ?>
                <p>Sin foto</p>
            <?php } ?>

            <label>Cambiar foto (opcional):</label>
            <input type="file" name="imagen" accept="image/*">

            <button type="submit">Actualizar</button>
        </form>
        <br>
        <a href="index.php">Volver</a>
    </div>
    <script src="js/script.js"></script>
</body>
</html>