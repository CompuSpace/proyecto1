
<?php
date_default_timezone_set('America/Bogota');
session_start();
include 'conexion.php';

// Verifica si el usuario ha iniciado sesión
$autenticado = isset($_SESSION['empleado_id']);

// Si el usuario está autenticado, obtener datos de ventas
if ($autenticado) {
    $fecha_hoy = date("Y-m-d");

    // Consulta para obtener las ventas del día
    $sql_ventas = "SELECT V.id_venta, V.fecha, V.total, E.nombre AS empleado 
                   FROM Ventas V
                   JOIN Empleados E ON V.empleado_id = E.id_empleado
                   WHERE DATE(V.fecha) = '$fecha_hoy'
                   ORDER BY V.fecha DESC";
    $result_ventas = $conn->query($sql_ventas);

    // Calcular el total de ventas del día
    $sql_total = "SELECT SUM(total) AS total_vendido FROM Ventas WHERE DATE(fecha) = '$fecha_hoy'";
    $result_total = $conn->query($sql_total);
    $total_vendido = $result_total->fetch_assoc()['total_vendido'] ?? 0;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Sistema de Ventas</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
</head>
<body>

<?php
if (isset($_GET['mensaje'])) {
    echo "<script>alert('" . htmlspecialchars($_GET['mensaje']) . "');</script>";
}

// Si el usuario está autenticado, mostrar la información del sistema
if ($autenticado) {
?> 
<div class="contenedor-principal">
    <div class="container">
        <h1>Sistema de Ventas</h1>
        <h2>Bienvenido, <?php echo $_SESSION['nombre']; ?> (<?php echo $_SESSION['cargo']; ?>)</h2>
    </div>
    <div class="container2">
        <h2>Ventas del Día (<?php echo $fecha_hoy; ?>)</h2>
        <h3>Total Vendido: $<?php echo number_format($total_vendido, 2); ?></h3>
    </div>
</div>
    <!-- Menú de navegación -->
     <br>
    <nav>
        <ul>
            <li><a href="venta.php">Registrar Venta</a></li>
            <li><a href="inventario.php">Ver Inventario</a></li>
            <?php if ($_SESSION['cargo'] === 'Administrador') { ?>
                <li><a href="empleado.html">Agregar Empleado</a></li>
            <?php } ?>
        </ul>
    </nav>
    <br>
    <h3>Detalle de Ventas</h3>
    <table border="1">
        <tr>
            <th>ID Venta</th>
            <th>Fecha</th>
            <th>Empleado</th>
            <th>Total</th>
            <th>Detalles</th>
        </tr>
        <?php while ($row = $result_ventas->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id_venta']; ?></td>
                <td><?php echo $row['fecha']; ?></td>
                <td><?php echo $row['empleado']; ?></td>
                <td>$<?php echo number_format($row['total'], 2); ?></td>
                <td><a href="detalle_venta.php?id_venta=<?php echo $row['id_venta']; ?>" target="_blank">Ver Detalle</a></td>
            </tr>
            
        <?php } ?>
    </table>
    <br><br>
    <a href="logout.php">Cerrar Sesión</a>

<?php
} else {
    // Si el usuario no ha iniciado sesión, mostrar el formulario de inicio de sesión
?>
   <div class="wrapper">
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <form action="login.php" method="POST">
            <label>Cédula:</label>
            <input type="text" name="cedula" required>

            <label>Contraseña:</label>
            <input type="password" name="contraseña" required>

            <button type="submit">Ingresar</button>
        </form>
    </div>
</div>
    
<?php
}
?>

</body>
</html>

<?php
$conn->close();
?>
