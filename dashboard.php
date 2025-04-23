<?php
session_start();
if (!isset($_SESSION['empleado_id'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control</title>
</head>
<body>
    <h2>Bienvenido, <?php echo $_SESSION['nombre']; ?> (<?php echo $_SESSION['cargo']; ?>)</h2>

    <?php if ($_SESSION['cargo'] === 'Administrador') { ?>
        <a href="empleado.html">Agregar Empleados</a><br>
        <a href="inventario.php">Gestionar Productos</a><br>
    <?php } ?>

    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>

