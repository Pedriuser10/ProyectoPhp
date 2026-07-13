<?php
include "sesion.php";
include "conexion/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $anio = $_POST['anio'];
    $precio = $_POST['precio'];
    $color = $_POST['color'];
    $stock = $_POST['stock'];
    $nombreImagen = null;

    // Si el usuario subió una foto, la guardamos en img/ y sacamos el nombre
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $nombreImagen = uniqid() . "_" . basename($_FILES['imagen']['name']);
        move_uploaded_file($_FILES['imagen']['tmp_name'], "img/" . $nombreImagen);
    }

    $sql = "INSERT INTO autos (marca, modelo, anio, precio, color, stock, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ssidsis", $marca, $modelo, $anio, $precio, $color, $stock, $nombreImagen);
    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Auto</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="contenedor">
        <h1>Agregar Auto</h1>
        <form method="POST" enctype="multipart/form-data" onsubmit="return validarFormulario()">
            <label>Marca:</label>
            <select id="marca_select" name="marca" required onchange="mostrarCampoOtro('marca_select', 'marca_otro')">
                <option value="">-- Selecciona marca --</option>
                <option value="Toyota">Toyota</option>
                <option value="Chevrolet">Chevrolet</option>
                <option value="Nissan">Nissan</option>
                <option value="Hyundai">Hyundai</option>
                <option value="Kia">Kia</option>
                <option value="Suzuki">Suzuki</option>
                <option value="Mazda">Mazda</option>
                <option value="Volkswagen">Volkswagen</option>
                <option value="Ford">Ford</option>
                <option value="Chery">Chery</option>
                <option value="otro">Otra (escribir)</option>
            </select>
            <input type="text" id="marca_otro" placeholder="Escribe la marca" style="display:none;">

            <label>Modelo:</label>
            <select id="modelo_select" name="modelo" required onchange="mostrarCampoOtro('modelo_select', 'modelo_otro')">
                <option value="">-- Selecciona modelo --</option>
                <option value="Corolla">Corolla</option>
                <option value="Sail">Sail</option>
                <option value="Versa">Versa</option>
                <option value="Accent">Accent</option>
                <option value="Rio">Rio</option>
                <option value="Swift">Swift</option>
                <option value="Mazda3">Mazda3</option>
                <option value="Gol">Gol</option>
                <option value="Fiesta">Fiesta</option>
                <option value="Tiggo">Tiggo</option>
                <option value="otro">Otro (escribir)</option>
            </select>
            <input type="text" id="modelo_otro" placeholder="Escribe el modelo" style="display:none;">

            <label>Año:</label>
            <select name="anio" required>
                <option value="">-- Selecciona año --</option>
                <?php for ($y = 2026; $y >= 2015; $y--) { ?>
                    <option value="<?php echo $y; ?>"><?php echo $y; ?></option>
                <?php } ?>
            </select>

            <label>Precio:</label>
            <input type="text" name="precio" inputmode="numeric" oninput="formatearPrecio(this)" required>

            <label>Color:</label>
            <input type="text" name="color" required>

            <label>Stock:</label>
            <input type="number" name="stock" required>

            <label>Foto:</label>
            <input type="file" name="imagen" accept="image/*">

            <button type="submit">Guardar</button>
        </form>
        <br>
        <a href="index.php">Volver</a>
    </div>
    <script src="js/script.js"></script>
</body>
</html>