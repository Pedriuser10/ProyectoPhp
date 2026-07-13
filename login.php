<?php
session_start();
include "conexion/conexion.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE usuario = ? AND password = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $usuario, $password);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $fila = mysqli_fetch_assoc($resultado);

    if ($fila) {
        $_SESSION['usuario_id'] = $fila['id'];
        $_SESSION['usuario_nombre'] = $fila['usuario'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="login-body">
    <div class="login-box">
        <h1>Iniciar Sesión</h1>

        <?php if ($error) { ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php } ?>

        <form method="POST">
            <label>Usuario:</label>
            <input type="text" name="usuario" required>

            <label>Contraseña:</label>
            <input type="password" name="password" required>

            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>
</html>